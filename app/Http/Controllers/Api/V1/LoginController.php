<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Contracts\LoginContract;
use App\DTO\LoginDTO;
use App\Facades\Normalizer;
use App\Facades\UserTokenRefresher;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Traits\Controllers\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Throwable;

final class LoginController extends Controller
{
    use ApiResponse;

    public function __invoke(LoginRequest $loginRequest, LoginContract $action): JsonResponse
    {
        try {
            if ($action->handle(Normalizer::denormalize($loginRequest->validated(), LoginDTO::class))) {
                /** @var User $user */
                $user = Auth::user();

                return $this->sendResponse([
                    'token' => UserTokenRefresher::refresh($user),
                    'type' => 'bearer',
                ], 200);
            }

            return $this->sendError('Неверный логин или пароль');
        } catch (Throwable) {
            return $this->sendError('Аутентификация временно недоступна');
        }
    }
}
