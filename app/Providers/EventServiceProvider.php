<?php

namespace App\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\UserRegisterEvent' => [
            'App\Listeners\UserRegisterEventListener',
        ],
        'App\Events\UserLoginEvent' => [
            'App\Listeners\UserLoginEventListener',
        ],
        'App\Events\UserLogoutEvent' => [
            'App\Listeners\UserLogoutEventListener',
        ],
    ];
}
