<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSavedExercisesRequest extends FormRequest
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
            'selected_exercise_ids' => ['required', 'array'],
            'selected_exercise_ids.*' => ['integer', 'distinct', 'exists:exercises,id'],
        ];
    }
}

