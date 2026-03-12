<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response as HTTP;

abstract class BaseApiController extends Controller
{
    /**
     * @param array<string, mixed> $meta
     */
    protected function success(
        string $message,
        mixed $data = null,
        int $status = HTTP::HTTP_OK,
        array $meta = []
    ): JsonResponse {
        return response()->json([
            'message' => $message,
            'data' => $data,
            'meta' => (object) $meta,
        ], $status);
    }

    protected function resourceResponse(
        string $message,
        JsonResource $resource,
        int $status = HTTP::HTTP_OK
    ): JsonResponse {
        return $this->success($message, $resource->resolve(), $status);
    }

    protected function paginatedResponse(
        string $message,
        AnonymousResourceCollection $collection,
        int $status = HTTP::HTTP_OK
    ): JsonResponse {
        /** @var array<string, mixed> $payload */
        $payload = $collection->response()->getData(true);

        return response()->json([
            'message' => $message,
            'data' => $payload['data'] ?? [],
            'meta' => $payload['meta'] ?? [],
            'links' => $payload['links'] ?? [],
        ], $status);
    }
}

