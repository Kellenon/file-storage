<?php

declare(strict_types=1);

namespace App\Facades;

use App\Models\User;
use App\Services\Auth\UserPasswordRefresher as MainUserPasswordRefresher;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string refresh(User $user, string $newPassword = null)
 * @see MainUserPasswordRefresher
 */
final class UserPasswordRefresher extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return MainUserPasswordRefresher::class;
    }
}
