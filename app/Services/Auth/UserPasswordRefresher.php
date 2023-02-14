<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Events\UserPasswordUpdated;
use App\Models\User;

final class UserPasswordRefresher
{
    public function refresh(User $user, string $newPassword): bool
    {
        $user->password = bcrypt($newPassword);

        if (!$user->save()) {
            return false;
        }

        UserPasswordUpdated::dispatch($user);

        return true;
    }
}
