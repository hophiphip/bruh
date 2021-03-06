<?php

namespace App\Providers;

use App\Events\RequestNotification;
use App\Events\UserLogIn;
use App\Events\UserSignUp;
use App\Listeners\SendRequestNotificationEmail;
use App\Listeners\SendUserLogInLink;
use App\Listeners\SendUserSignUpLink;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        UserLogIn::class => [
            SendUserLogInLink::class,
        ],

        UserSignUp::class => [
            SendUserSignUpLink::class,
        ],

        RequestNotification::class => [
            SendRequestNotificationEmail::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
