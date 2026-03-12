<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Workout\ListWorkoutRequest;
use App\Http\Requests\Api\Workout\StoreWorkoutRequest;
use App\Http\Requests\Api\Workout\UpdateWorkoutRequest;
use App\Http\Resources\Api\WorkoutResource;
use App\Models\Workout;
use App\Services\WorkoutService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HTTP;

class WorkoutController extends BaseApiController
{
    public function __construct(
        private readonly WorkoutService $workoutService
    ) {
    }

    public function index(ListWorkoutRequest $request): JsonResponse
    {
        $workouts = $this->workoutService->paginateForUser(
            user: $request->user(),
            filters: $request->validated()
        );

        return $this->paginatedResponse(
            message: 'Workouts retrieved successfully.',
            collection: WorkoutResource::collection($workouts),
            status: HTTP::HTTP_OK
        );
    }

    public function store(StoreWorkoutRequest $request): JsonResponse
    {
        $workout = $this->workoutService->createForUser(
            user: $request->user(),
            payload: $request->validated()
        );

        return $this->resourceResponse(
            message: 'Workout created successfully.',
            resource: new WorkoutResource($workout),
            status: HTTP::HTTP_CREATED
        );
    }

    public function show(Request $request, Workout $workout): JsonResponse
    {
        $workout = $this->workoutService->showForUser(
            user: $request->user(),
            workout: $workout
        );

        return $this->resourceResponse(
            message: 'Workout retrieved successfully.',
            resource: new WorkoutResource($workout),
            status: HTTP::HTTP_OK
        );
    }

    public function update(UpdateWorkoutRequest $request, Workout $workout): JsonResponse
    {
        $workout = $this->workoutService->updateForUser(
            user: $request->user(),
            workout: $workout,
            payload: $request->validated()
        );

        return $this->resourceResponse(
            message: 'Workout updated successfully.',
            resource: new WorkoutResource($workout),
            status: HTTP::HTTP_OK
        );
    }

    public function destroy(Request $request, Workout $workout): JsonResponse
    {
        $this->workoutService->deleteForUser(
            user: $request->user(),
            workout: $workout
        );

        return $this->success(
            message: 'Workout deleted successfully.',
            data: null,
            status: HTTP::HTTP_OK
        );
    }
}

