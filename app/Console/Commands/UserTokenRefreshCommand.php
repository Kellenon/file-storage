<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Facades\UserTokenRefresher;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

final class UserTokenRefreshCommand extends Command
{
    protected $signature = 'user:refresh-token';
    protected $description = 'Refresh token';

    public function handle(): bool
    {
        $email = $this->ask('Укажите email пользователя, токен которого нужно обновить');

        try {
            $token = UserTokenRefresher::refresh(User::where('email', $email)->firstOrFail());
        } catch (ModelNotFoundException) {
            $this->error("Пользовать с email [$email] не найден");

            return false;
        } catch (Throwable) {
            $this->error('Не обновить токен пользователя');

            return false;
        }

        $this->info('Токен успешно обновлен');

        $this->info(
            print_r([
                'email' => $email,
                'api_token' => $token,
            ], true)
        );

        return true;
    }
}
