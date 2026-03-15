<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkoutSet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'workout_exercise_id',
        'set_number',
        'reps',
        'weight',
        'weight_unit',
        'is_warmup',
        'is_completed',
        'rpe',
        'rest_seconds',
        'performed_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'set_number' => 'integer',
            'reps' => 'integer',
            'weight' => 'decimal:2',
            'is_warmup' => 'boolean',
            'is_completed' => 'boolean',
            'rpe' => 'decimal:1',
            'rest_seconds' => 'integer',
            'performed_at' => 'datetime',
        ];
    }

    public function workoutExercise(): BelongsTo
    {
        return $this->belongsTo(WorkoutExercise::class);
    }
}
