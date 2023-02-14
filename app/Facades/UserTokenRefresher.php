<?php

declare(strict_types=1);

namespace App\Facades;

use App\Models\User;
use App\Services\Auth\UserTokenRefresher as MainUserTokenRefresher;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string refresh(User $user)
 * @see MainUserTokenRefresher
 */
final class UserTokenRefresher extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return MainUserTokenRefresher::class;
    }
}
