<?php

namespace App\Providers;

use App\Actions\Authentication\LoginWithPassword;
use App\Contracts\LoginContract;
use Illuminate\Support\ServiceProvider;

final class LoginServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(LoginContract::class, function() {
            return new LoginWithPassword();
        });
    }
}
