<?php

namespace App\Listeners;

use App\Events\UserSignUp;
use App\Jobs\SendEmail;
use App\Mail\SignUpLink;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Str;

class SendUserSignUpLink
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
     * @param UserSignUp $event
     * @return void
     */
    public function handle(UserSignUp $event)
    {
        $plainToken = Str::random(32);
        $tokenHash = hash('sha256', $plainToken);

        $user = $event->user;

        $token = $user->loginTokens()->create([
            'token' => $tokenHash,
            'expires_at' => now()->addMinutes($user->tokenLifetimeInMinutes),
        ]);

        SendEmail::dispatch($user->email, new SignUpLink($plainToken, $token->expires_at));
    }
}
