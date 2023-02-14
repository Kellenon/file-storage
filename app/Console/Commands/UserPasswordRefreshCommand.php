<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Facades\UserPasswordRefresher;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

final class UserPasswordRefreshCommand extends Command
{
    protected $signature = 'user:refresh-password';
    protected $description = 'Refresh password';

    public function handle(): bool
    {
        $email = $this->ask('Укажите email пользователя, пароль которого нужно обновить');
        $newPassword = $this->ask('Укажите новый пароль для пользователя');

        try {
            UserPasswordRefresher::refresh(User::where('email', $email)->firstOrFail(), $newPassword);
        } catch (ModelNotFoundException) {
            $this->error("Пользовать с email [$email] не найден");

            return false;
        } catch (Throwable) {
            $this->error('Не обновить токен пользователя');

            return false;
        }

        $this->info('Пароль успешно обновлен');

        $this->info(
            print_r([
                'email' => $email,
                'password' => $newPassword,
            ], true)
        );

        return true;
    }
}
