<?php

namespace App\Models;

use App\Jobs\SendEmail;
use App\Mail\OfferRequestNotification;
use App\Observers\OfferRequestObserver;
use App\Providers\DatabaseTableNamesProvider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/* TODO: Add optional request message */

/**
 * App\Models\OfferRequest
 *
 * @property int $id
 * @property int $offer_id
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Offer $offer
 * @method static \Database\Factories\OfferRequestFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|OfferRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OfferRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OfferRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|OfferRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfferRequest whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfferRequest whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfferRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfferRequest whereOfferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfferRequest whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OfferRequest extends Model
{
    use HasFactory;

    /**
     * @var string $table database table name
     */
    protected $table = DatabaseTableNamesProvider::OFFER_REQUEST_TABLE;

    /**
     * Redis key for offer request count value.
     *
     * @var string
     */
    public static string $cacheCountKey = 'offer_request:count';

    /**
     *  @var array $fillable contains collection fields names
     */
    protected $fillable = [
        'email',
        'email_verified_at',
    ];

    protected $dates = [
        'expires_at', 'consumed_at',
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
     * Define model observer.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        if (!env('APP_WORKER'))
        {
            OfferRequestObserver::initialize();
            OfferRequest::observe(OfferRequestObserver::class);
        }
    }

    /**
     * Get request's offer.
     *
     * @return BelongsTo
     */
    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class);
    }

    /**
     * Get client location info.
     *
     * @return array|null
     */
    public function location(): ?array
    {
        return ClientLocation::whereEmail($this->email)->first()?->location;
    }
}
