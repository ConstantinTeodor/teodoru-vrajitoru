<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UpdateSavedExercisesRequest;
use App\Services\SavedExerciseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HTTP;

class SavedExerciseController extends BaseApiController
{
    public function __construct(
        private readonly SavedExerciseService $savedExerciseService
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $data = $this->savedExerciseService->listForUser($request->user());

        return $this->success(
            message: 'Saved exercises retrieved successfully.',
            data: $data,
            status: HTTP::HTTP_OK
        );
    }

    public function update(UpdateSavedExercisesRequest $request): JsonResponse
    {
        $data = $this->savedExerciseService->updateForUser(
            user: $request->user(),
            payload: $request->validated()
        );

        return $this->success(
            message: 'Saved exercises updated successfully.',
            data: $data,
            status: HTTP::HTTP_OK
        );
    }
}

