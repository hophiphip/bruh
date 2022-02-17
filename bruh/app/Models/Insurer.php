<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Insurer extends Model
{
    use HasFactory;

    /**
     * @var string $table insurer table name
     */
    protected $table = 'insurers';

    /**
     * Get insurers' offers.
     * TODO: This is slooow, and baaad...or is it?
     *
     * @return HasMany offers
     */
    public function getOffers(): HasMany
    {
        return $this->hasMany(Offer::class);
    }

    /**
     * Get insurer user instance.
     *
     * @return BelongsTo user
     */
    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    /**
     * @var array $fillable fields to be mass-assigned.
     */
    protected $fillable = ['first_name', 'last_name', 'company_name'];
}
