<?php

namespace App\Services;

use App\Models\Equipment;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class EquipmentService
{
    /**
     * @param array<string, mixed> $filters
     */
    public function paginate(array $filters = []): LengthAwarePaginator
    {
        $perPage = (int) ($filters['per_page'] ?? 20);
        $search = $filters['search'] ?? null;

        return Equipment::query()
            ->withCount('exercises')
            ->where('is_active', true)
            ->when(filled($search), function (Builder $query) use ($search): void {
                $query->where(function (Builder $subQuery) use ($search): void {
                    $subQuery
                        ->where('name', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('name')
            ->paginate($perPage);
    }

    public function show(Equipment $equipment): Equipment
    {
        if (! $equipment->is_active) {
            throw (new ModelNotFoundException())->setModel(Equipment::class, [(string) $equipment->getKey()]);
        }

        return $equipment->load(['exercises:id,name,slug,muscle_group']);
    }
}
