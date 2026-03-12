<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Workout */
class WorkoutResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'title' => $this->title,
            'performed_at' => $this->performed_at?->toIso8601String(),
            'notes' => $this->notes,
            'duration_minutes' => $this->duration_minutes,
            'workout_exercises_count' => $this->whenCounted('workoutExercises'),
            'workout_sets_count' => $this->whenCounted('workoutSets'),
            'user' => new UserResource($this->whenLoaded('user')),
            'exercises' => WorkoutExerciseResource::collection($this->whenLoaded('workoutExercises')),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}

