<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\UserPasswordUpdated;
use App\Facades\UserTokenRefresher;

final class UserTokenRefresh
{
    public function handle(UserPasswordUpdated $event): void
    {
        UserTokenRefresher::refresh($event->user);
    }
}
