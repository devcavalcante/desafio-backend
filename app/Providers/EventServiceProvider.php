<?php

namespace App\Providers;

use App\Events\SendNotification;
use App\Listeners\NotificationListener;
use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        SendNotification::class => [
            NotificationListener::class,
        ],
    ];
}
