<?php

namespace App\Listeners;

use App\Events\RequestNotification;
use App\Jobs\SendEmail;
use App\Mail\OfferRequestNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendRequestNotificationEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param RequestNotification $event
     * @return void
     */
    public function handle(RequestNotification $event)
    {
        SendEmail::dispatch($event->user->email, new OfferRequestNotification());
    }
}
