<?php

namespace App\Http\Requests\Api\Workout;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => ['nullable', 'string', 'max:255'],
            'performed_at' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
            'duration_minutes' => ['nullable', 'integer', 'min:1', 'max:1000'],
            'exercises' => ['required', 'array', 'min:1'],
            'exercises.*.exercise_id' => ['required', 'integer', 'exists:exercises,id'],
            'exercises.*.order' => ['nullable', 'integer', 'min:1'],
            'exercises.*.notes' => ['nullable', 'string'],
            'exercises.*.exercise_name_snapshot' => ['nullable', 'string', 'max:255'],
            'exercises.*.sets' => ['required', 'array', 'min:1'],
            'exercises.*.sets.*.set_number' => ['nullable', 'integer', 'min:1', 'max:255'],
            'exercises.*.sets.*.reps' => ['required', 'integer', 'min:0', 'max:1000'],
            'exercises.*.sets.*.weight' => ['nullable', 'numeric', 'min:0', 'max:9999.99'],
            'exercises.*.sets.*.weight_unit' => ['required', 'string', 'in:kg,lb'],
            'exercises.*.sets.*.is_warmup' => ['nullable', 'boolean'],
            'exercises.*.sets.*.is_completed' => ['nullable', 'boolean'],
            'exercises.*.sets.*.rpe' => ['nullable', 'numeric', 'min:1', 'max:10'],
            'exercises.*.sets.*.rest_seconds' => ['nullable', 'integer', 'min:0', 'max:36000'],
            'exercises.*.sets.*.performed_at' => ['nullable', 'date'],
        ];
    }
}
