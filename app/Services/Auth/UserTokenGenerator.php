<?php

declare(strict_types=1);

namespace App\Services\Auth;

use Illuminate\Support\Str;

final class UserTokenGenerator
{
    public function generate(): string
    {
        return Str::random(80);
    }
}
