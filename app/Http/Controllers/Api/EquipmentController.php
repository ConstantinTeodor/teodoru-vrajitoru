<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\ListEquipmentRequest;
use App\Http\Resources\Api\EquipmentResource;
use App\Models\Equipment;
use App\Services\EquipmentService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HTTP;

class EquipmentController extends BaseApiController
{
    public function __construct(
        private readonly EquipmentService $equipmentService
    ) {
    }

    public function index(ListEquipmentRequest $request): JsonResponse
    {
        $equipment = $this->equipmentService->paginate($request->validated());

        return $this->paginatedResponse(
            message: 'Equipment retrieved successfully.',
            collection: EquipmentResource::collection($equipment),
            status: HTTP::HTTP_OK
        );
    }

    public function show(Equipment $equipment): JsonResponse
    {
        $equipment = $this->equipmentService->show($equipment);

        return $this->resourceResponse(
            message: 'Equipment item retrieved successfully.',
            resource: new EquipmentResource($equipment),
            status: HTTP::HTTP_OK
        );
    }
}

