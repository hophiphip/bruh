<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OfferRequest extends Model
{
    use HasFactory;

    /**
     * @var string $table database table name
     */
    protected $table = 'offer_requests';


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
     * Get request's offer.
     *
     * @return BelongsTo
     */
    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class);
    }
}
