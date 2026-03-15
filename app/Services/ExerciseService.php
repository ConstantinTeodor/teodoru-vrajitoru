<?php

namespace App\Services;

use App\Models\Exercise;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class ExerciseService
{
    /**
     * @param array<string, mixed> $filters
     */
    public function paginate(array $filters = []): LengthAwarePaginator
    {
        $perPage = (int) ($filters['per_page'] ?? 20);
        $search = $filters['search'] ?? null;
        $muscleGroup = $filters['muscle_group'] ?? null;
        $equipmentId = $filters['equipment_id'] ?? null;
        $includeInactive = filter_var($filters['include_inactive'] ?? false, FILTER_VALIDATE_BOOLEAN);

        return Exercise::query()
            ->with(['equipment:id,name,slug'])
            ->when(! $includeInactive, fn (Builder $query): Builder => $query->where('is_active', true))
            ->when(filled($search), function (Builder $query) use ($search): void {
                $query->where(function (Builder $subQuery) use ($search): void {
                    $subQuery
                        ->where('name', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%');
                });
            })
            ->when(filled($muscleGroup), fn (Builder $query): Builder => $query->where('muscle_group', $muscleGroup))
            ->when(filled($equipmentId), function (Builder $query) use ($equipmentId): void {
                $query->whereHas('equipment', fn (Builder $equipmentQuery): Builder => $equipmentQuery->whereKey($equipmentId));
            })
            ->orderBy('name')
            ->paginate($perPage);
    }

    public function show(Exercise $exercise): Exercise
    {
        if (! $exercise->is_active) {
            throw (new ModelNotFoundException())->setModel(Exercise::class, [(string) $exercise->getKey()]);
        }

        return $exercise->load(['equipment:id,name,slug']);
    }
}
