<?php

declare(strict_types=1);

namespace App\Actions\Authentication;

use App\Contracts\LoginContract;
use App\DTO\LoginDTO;
use Illuminate\Support\Facades\Auth;

final class LoginWithPassword implements LoginContract
{
    public function handle(LoginDTO $loginDTO): bool
    {
        return Auth::attempt([
            'email' => $loginDTO->getEmail(),
            'password' => $loginDTO->getPassword(),
        ]);
    }
}
