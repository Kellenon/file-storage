<?php

namespace App\Providers;

use App\Events\FilesRegistered;
use App\Events\NotAllFilesRegistered;
use App\Events\UserPasswordUpdated;
use App\Listeners\FileCleaner;
use App\Listeners\UserTokenRefresh;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserPasswordUpdated::class => [
            UserTokenRefresh::class,
        ],
        FilesRegistered::class => [],
        NotAllFilesRegistered::class => [
            FileCleaner::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
