<?php

namespace App\Listeners;

use App\Events\UserLogIn;
use App\Jobs\SendEmail;
use App\Mail\LoginLink;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SendUserLogInLink
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
     * @param UserLogIn $event
     * @return void
     */
    public function handle(UserLogIn $event)
    {
        $plainToken = Str::random(32);
        $tokenHash = hash('sha256', $plainToken);

        $user = $event->user;

        $token = $user->loginTokens()->create([
            'token' => $tokenHash,
            'expires_at' => now()->addMinutes($user->tokenLifetimeInMinutes),
        ]);

        SendEmail::dispatch($user->email, new LoginLink($plainToken, $token->expires_at));
    }
}
