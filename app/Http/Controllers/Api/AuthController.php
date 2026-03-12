<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Resources\Api\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HTTP;

class AuthController extends BaseApiController
{
    public function __construct(
        private readonly AuthService $authService
    ) {
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authService->login($request->validated());

        return $this->success(
            message: 'Login successful.',
            data: [
                'token' => $result['token'],
                'token_type' => $result['token_type'],
                'user' => UserResource::make($result['user'])->resolve(),
            ],
            status: HTTP::HTTP_OK
        );
    }

    public function me(Request $request): JsonResponse
    {
        return $this->resourceResponse(
            message: 'Authenticated user retrieved successfully.',
            resource: new UserResource($request->user()),
            status: HTTP::HTTP_OK
        );
    }

    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user) {
            $this->authService->logout($user);
        }

        return $this->success(
            message: 'Logout successful.',
            data: null,
            status: HTTP::HTTP_OK
        );
    }
}

