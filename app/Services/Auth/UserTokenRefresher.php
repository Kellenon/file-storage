<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Models\User;
use RuntimeException;

final class UserTokenRefresher
{
    /**
     * @param User $user
     * @return string
     */
    public function refresh(User $user): string
    {
        $token = (new UserTokenGenerator())->generate();
        $user->api_token = hash('sha256', $token);

        if (!$user->save()) {
            throw new RuntimeException(sprintf('Не удалось обновить токен пользователя [%s]', $user->email));
        }

        return $token;
    }
}
