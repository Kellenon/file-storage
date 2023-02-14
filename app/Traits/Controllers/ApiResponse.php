<?php

declare(strict_types=1);

namespace App\Traits\Controllers;

use Illuminate\Http\JsonResponse;

use function response;

trait ApiResponse
{
    final public function sendResponse(mixed $message, int $status): JsonResponse
    {
        return response()->json($message, $status);
    }

    final public function sendSuccess(mixed $message): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }

    final public function sendError(string $error): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $error,
        ], 400);
    }
}
