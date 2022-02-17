<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

class LoginLink extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * User session token.
     *
     * @var string $plainToken
     */
    public string $plainToken;

    /**
     * Token expiration date.
     *
     * @var Carbon $expiresAt
     */
    public Carbon $expiresAt;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $plainToken, Carbon $expiresAt)
    {
        $this->plainToken = $plainToken;
        $this->expiresAt = $expiresAt;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(config('app.name') . ' Login Verification')
            ->markdown('emails.login-link', [
                'url' => URL::temporarySignedRoute('verify-login', $this->expiresAt,
                    [ 'token' => $this->plainToken, ]
                ),
        ]);
    }
}
