<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use App\Services\Auth\UserTokenGenerator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Throwable;

final class UserGeneratorCommand extends Command
{
    protected $signature = 'user:generate';
    protected $description = 'Generate a new user';

    public function handle(): bool
    {
        $email = $this->ask('Какая электронная почта?');
        $name = $this->ask('Какое имя пользователя?');
        $password = $this->ask('Какой пароль?');
        $token = (new UserTokenGenerator())->generate();

        $validator = Validator::make([
            'email' => $email,
            'name' => $name,
            'password' => bcrypt($password),
            'api_token' => hash('sha256', $token),
        ], [
            'email' => 'email|required|string|min:1|max:255|unique:users',
            'name' => 'string|required|string|min:1|max:255',
            'password' => 'string|required|min:1|max:255',
            'api_token' => 'string|required|string|min:1',
        ]);

        if (!empty($validator->errors()->getMessages())) {
            $this->error($validator->errors()->first());

            return false;
        }

        try {
            $user = new User();
            $user->fill($validator->validated());
            $user->save();
        } catch (Throwable) {
            $this->error('Не удалось создать пользователя');

            return false;
        }

        $this->info('Пользователь успешно создан');
        $this->info(print_r([
            'email' => $email,
            'name' => $name,
            'password' => $password,
            'api_token' => $token,
        ], true));

        return true;
    }
}
