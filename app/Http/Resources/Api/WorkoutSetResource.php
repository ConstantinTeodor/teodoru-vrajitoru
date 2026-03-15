<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\WorkoutSet */
class WorkoutSetResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'set_number' => $this->set_number,
            'reps' => $this->reps,
            'weight' => $this->weight,
            'weight_unit' => $this->weight_unit,
            'is_warmup' => (bool) $this->is_warmup,
            'is_completed' => (bool) $this->is_completed,
            'rpe' => $this->rpe,
            'rest_seconds' => $this->rest_seconds,
            'performed_at' => $this->performed_at?->toIso8601String(),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
