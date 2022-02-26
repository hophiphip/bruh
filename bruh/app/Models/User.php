<?php

namespace App\Models;

use App\Jobs\SendEmail;
use App\Mail\LoginLink;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public int $tokenLifetimeInMinutes = 15;

    /**
     * @var string $table user table name
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get authentication session tokens.
     *
     * @return HasMany authentication tokens
     */
    public function loginTokens(): HasMany
    {
        return $this->hasMany(LoginToken::class);
    }

    /**
     * Get user insurer instance.
     *
     * @return HasOne insurer instance
     */
    public function insurer(): HasOne
    {
        return $this->hasOne(Insurer::class);
    }

    /**
     * Get user verification status.
     *
     * @return bool
     */
    public function isVerified(): bool
    {
        return $this->email_verified_at != null;
    }

    /**
     * Verify user email.
     */
    public function verify()
    {
        if (!$this->isVerified()) {
            $this->update(['email_verified_at' => now()]);
        }
    }

    /**
     * Send login link in email.
     */
    public function sendLoginLink()
    {
        $plainToken = Str::random(32);
        $tokenHash = hash('sha256', $plainToken);

        $token = $this->loginTokens()->create([
            'token' => $tokenHash,
            'expires_at' => now()->addMinutes($this->tokenLifetimeInMinutes),
        ]);

        SendEmail::dispatch($this->email, new LoginLink($plainToken, $token->expires_at));
    }
}
