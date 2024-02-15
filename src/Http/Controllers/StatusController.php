<?php

namespace RehanKanak\Guardian\Http\Controllers;

use Illuminate\Http\JsonResponse;
use RehanKanak\Guardian\Http\Requests\GenerateStoreRequest;
use RehanKanak\Guardian\Services\StatusService;

class StatusController
{
    public function __invoke(GenerateStoreRequest $generateStoreRequest, StatusService $statusService): JsonResponse
    {
        $statusService->fetchLatestTokenByResource($generateStoreRequest->input('resourceId'));

        if (! $statusService->guardian) {
            return response()->json(['message' => 'No valid token available'], 400);
        }

        $statusService->fetchStatus();

        return response()->json([
            'status' => $statusService->status,
        ]);
    }
}
