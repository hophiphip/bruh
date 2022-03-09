<?php

namespace App\Models;

use App\Providers\DatabaseTableNamesProvider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/* TODO: Delete login tokens with Model Observer --> cron task might be better but it'll cost in prod that is why I won't do it that way */

/**
 * App\Models\LoginToken
 *
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property Carbon|null $consumed_at
 * @property Carbon $expires_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|LoginToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoginToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoginToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|LoginToken whereConsumedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginToken whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginToken whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginToken whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginToken whereUserId($value)
 * @mixin \Eloquent
 */
class LoginToken extends Model
{
    use HasFactory;

    /**
     * @var string $table login token table name
     */
    protected $table = DatabaseTableNamesProvider::LOGIN_TOKEN_TABLE;

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
