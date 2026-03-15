<?php

namespace App\Services;

use App\Models\Exercise;
use App\Models\User;
use Illuminate\Support\Collection;

class SavedExerciseService
{
    /**
     * @return array{selected_exercise_ids: list<int>}
     */
    public function listForUser(User $user): array
    {
        $allExerciseIds = $this->allExerciseIds();
        $hiddenExerciseIds = $this->hiddenExerciseIdsForUser($user);

        $selectedExerciseIds = $allExerciseIds
            ->diff($hiddenExerciseIds)
            ->values()
            ->all();

        return [
            'selected_exercise_ids' => $selectedExerciseIds,
        ];
    }

    /**
     * @param array<string, mixed> $payload
     * @return array{selected_exercise_ids: list<int>}
     */
    public function updateForUser(User $user, array $payload): array
    {
        $allExerciseIds = $this->allExerciseIds();

        /** @var Collection<int, int> $selectedExerciseIds */
        $selectedExerciseIds = collect($payload['selected_exercise_ids'] ?? [])
            ->map(fn (mixed $id): int => (int) $id)
            ->unique()
            ->intersect($allExerciseIds)
            ->values();

        $hiddenExerciseIds = $allExerciseIds
            ->diff($selectedExerciseIds)
            ->values();

        $user->hiddenExercises()->sync($hiddenExerciseIds->all());

        return [
            'selected_exercise_ids' => $selectedExerciseIds->all(),
        ];
    }

    /**
     * @return Collection<int, int>
     */
    private function allExerciseIds(): Collection
    {
        return Exercise::query()
            ->orderBy('id')
            ->pluck('id')
            ->map(fn (mixed $id): int => (int) $id);
    }

    /**
     * @return Collection<int, int>
     */
    private function hiddenExerciseIdsForUser(User $user): Collection
    {
        return $user->hiddenExercises()
            ->pluck('exercises.id')
            ->map(fn (mixed $id): int => (int) $id);
    }
}

