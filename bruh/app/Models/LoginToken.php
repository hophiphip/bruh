<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/* TODO: Delete login tokens with Model Observer --> cron task might be better but it'll cost in prod that is why I won't do it that way */

class LoginToken extends Model
{
    use HasFactory;

    /**
     * @var string $table login token table name
     */
    protected $table = 'login_tokens';

    protected $guarded = [];

    protected $dates = [
        'expires_at', 'consumed_at',
    ];

    /**
     * Get owner of this session token.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Test whether token is valid.
     *
     * @return bool
     */
    public function isValid(): bool
    {
        return !$this->isExpired() && !$this->isConsumed();
    }

    /**
     * Test whether token is expired.
     *
     * @return bool
     */
    public function isExpired(): bool
    {
        return $this->expires_at->isBefore(now());
    }

    /**
     * Test whether token was consumed.
     *
     * @return bool
     */
    public function isConsumed(): bool
    {
        return $this->consumed_at !== null;
    }

    /**
     * Consume token.
     */
    public function consume()
    {
        $this->consumed_at = now();
        $this->save();
    }
}
