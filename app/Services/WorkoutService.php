<?php

namespace App\Services;

use App\Models\Exercise;
use App\Models\User;
use App\Models\Workout;
use App\Models\WorkoutExercise;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Access\AuthorizationException;

class WorkoutService
{
    /**
     * @param array<string, mixed> $filters
     */
    public function paginateForUser(User $user, array $filters = []): LengthAwarePaginator
    {
        $perPage = (int) ($filters['per_page'] ?? 20);
        $from = $filters['from'] ?? null;
        $until = $filters['until'] ?? null;

        return Workout::query()
            ->withCount(['workoutExercises', 'workoutSets'])
            ->where('user_id', $user->getKey())
            ->when(filled($from), fn (Builder $query): Builder => $query->whereDate('performed_at', '>=', $from))
            ->when(filled($until), fn (Builder $query): Builder => $query->whereDate('performed_at', '<=', $until))
            ->latest('performed_at')
            ->paginate($perPage);
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function createForUser(User $user, array $payload): Workout
    {
        return DB::transaction(function () use ($user, $payload): Workout {
            $workout = Workout::query()->create([
                'user_id' => $user->getKey(),
                'title' => $payload['title'] ?? null,
                'performed_at' => $payload['performed_at'],
                'notes' => $payload['notes'] ?? null,
                'duration_minutes' => $payload['duration_minutes'] ?? null,
            ]);

            $this->syncWorkoutExercises($workout, $payload['exercises']);

            return $this->loadWorkoutDetails($workout);
        });
    }

    public function showForUser(User $user, Workout $workout): Workout
    {
        $this->assertWorkoutOwnership($user, $workout);

        return $this->loadWorkoutDetails($workout);
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function updateForUser(User $user, Workout $workout, array $payload): Workout
    {
        $this->assertWorkoutOwnership($user, $workout);

        return DB::transaction(function () use ($workout, $payload): Workout {
            $workout->update([
                'title' => array_key_exists('title', $payload) ? $payload['title'] : $workout->title,
                'performed_at' => array_key_exists('performed_at', $payload) ? $payload['performed_at'] : $workout->performed_at,
                'notes' => array_key_exists('notes', $payload) ? $payload['notes'] : $workout->notes,
                'duration_minutes' => array_key_exists('duration_minutes', $payload) ? $payload['duration_minutes'] : $workout->duration_minutes,
            ]);

            if (array_key_exists('exercises', $payload)) {
                $workout->workoutExercises()->delete();
                $this->syncWorkoutExercises($workout, $payload['exercises']);
            }

            return $this->loadWorkoutDetails($workout->refresh());
        });
    }

    public function deleteForUser(User $user, Workout $workout): void
    {
        $this->assertWorkoutOwnership($user, $workout);
        $workout->delete();
    }

    /**
     * @param array<int, array<string, mixed>> $exerciseEntries
     */
    private function syncWorkoutExercises(Workout $workout, array $exerciseEntries): void
    {
        foreach ($exerciseEntries as $exerciseIndex => $exerciseEntry) {
            $exercise = Exercise::query()
                ->select(['id', 'name'])
                ->findOrFail($exerciseEntry['exercise_id']);

            $workoutExercise = $workout->workoutExercises()->create([
                'exercise_id' => $exercise->getKey(),
                'exercise_name_snapshot' => $exerciseEntry['exercise_name_snapshot'] ?? $exercise->name,
                'order' => $exerciseEntry['order'] ?? ($exerciseIndex + 1),
                'notes' => $exerciseEntry['notes'] ?? null,
            ]);

            $this->syncWorkoutSets($workoutExercise, $exerciseEntry['sets'] ?? []);
        }
    }

    /**
     * @param array<int, array<string, mixed>> $setEntries
     */
    private function syncWorkoutSets(WorkoutExercise $workoutExercise, array $setEntries): void
    {
        foreach ($setEntries as $setIndex => $setEntry) {
            $workoutExercise->sets()->create([
                'set_number' => $setEntry['set_number'] ?? ($setIndex + 1),
                'reps' => $setEntry['reps'],
                'weight' => $setEntry['weight'] ?? null,
                'weight_unit' => $setEntry['weight_unit'],
                'is_warmup' => (bool) ($setEntry['is_warmup'] ?? false),
                'is_completed' => (bool) ($setEntry['is_completed'] ?? false),
                'rpe' => $setEntry['rpe'] ?? null,
                'rest_seconds' => $setEntry['rest_seconds'] ?? null,
                'performed_at' => $setEntry['performed_at'] ?? null,
            ]);
        }
    }

    private function loadWorkoutDetails(Workout $workout): Workout
    {
        return $workout
            ->loadCount(['workoutExercises', 'workoutSets'])
            ->load([
                'user:id,name,email',
                'workoutExercises.exercise:id,name,slug',
                'workoutExercises.sets',
            ]);
    }

    private function assertWorkoutOwnership(User $user, Workout $workout): void
    {
        if ((int) $workout->user_id !== (int) $user->getKey()) {
            throw new AuthorizationException('You are not allowed to access this workout.');
        }
    }
}
