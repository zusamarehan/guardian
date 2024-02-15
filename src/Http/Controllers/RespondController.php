<?php

namespace RehanKanak\Guardian\Http\Controllers;

use Illuminate\Http\JsonResponse;
use RehanKanak\Guardian\Http\Requests\RespondStoreRequest;
use RehanKanak\Guardian\Services\RespondService;

class RespondController
{
    public function __invoke(RespondStoreRequest $generateStoreRequest, RespondService $respondService): JsonResponse
    {
        $respondService->checkIfValidTokenAvailable($generateStoreRequest->input('resourceId'));

        if (! $respondService->guardian) {
            return response()->json(['message' => 'No valid token available'], 400);
        }

        $respondService
            ->setResponse($generateStoreRequest->input('response'))
            ->process()
            ->invalidateToken();

        return response()->json();
    }
}
