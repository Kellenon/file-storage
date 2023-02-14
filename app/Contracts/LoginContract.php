<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DTO\LoginDTO;

interface LoginContract
{
    public function handle(LoginDTO $loginDTO): bool;
}
