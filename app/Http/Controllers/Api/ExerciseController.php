<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\ListExerciseRequest;
use App\Http\Resources\Api\ExerciseResource;
use App\Models\Exercise;
use App\Services\ExerciseService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HTTP;

class ExerciseController extends BaseApiController
{
    public function __construct(
        private readonly ExerciseService $exerciseService
    ) {
    }

    public function index(ListExerciseRequest $request): JsonResponse
    {
        $exercises = $this->exerciseService->paginate($request->validated());

        return $this->paginatedResponse(
            message: 'Exercises retrieved successfully.',
            collection: ExerciseResource::collection($exercises),
            status: HTTP::HTTP_OK
        );
    }

    public function show(Exercise $exercise): JsonResponse
    {
        $exercise = $this->exerciseService->show($exercise);

        return $this->resourceResponse(
            message: 'Exercise retrieved successfully.',
            resource: new ExerciseResource($exercise),
            status: HTTP::HTTP_OK
        );
    }
}

