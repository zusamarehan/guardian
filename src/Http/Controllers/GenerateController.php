<?php

namespace RehanKanak\Guardian\Http\Controllers;

use Illuminate\Http\JsonResponse;
use RehanKanak\Guardian\Http\Requests\GenerateStoreRequest;
use RehanKanak\Guardian\Services\GenerateTokenService;

class GenerateController
{
    public function __invoke(GenerateStoreRequest $generateStoreRequest, GenerateTokenService $generateTokenService): JsonResponse
    {
        $generateTokenService->inValidatePreviousTokens($generateStoreRequest->input('resourceId'));

        $generateTokenService
            ->initiate()
            ->setResource($generateStoreRequest->input('resourceId'))
            ->pickType()
            ->generate();

        return response()->json([
            'resource_uuid' => $generateTokenService->guardian->resource_uuid,
            'type' => $generateTokenService->guardian->type,
            'options' => $generateTokenService->guardian->options,
            'right_option' => $generateTokenService->guardian->right_option,
        ], 201);
    }
}
