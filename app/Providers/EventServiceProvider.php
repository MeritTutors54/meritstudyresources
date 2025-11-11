<?php

namespace App\Providers;

use App\Events\UserRegistered;
use App\Listeners\SendWelcomeEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
//        Registered::class => [
//            SendWelcomeEmail::class
//        ]
        UserRegistered::class => [
            SendWelcomeEmail::class
        ],
    ];

    public function boot(): void
    {
        parent::boot();

        static::disableEventDiscovery();
    }
}
