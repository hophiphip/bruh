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
     * Redis key for insurer count value.
     *
     * @var string
     */
    public static string $cacheCountKey = 'insurer:count';

    /**
     * Get insurers' offers.
     *
     * @return HasMany offers
     */
    public function offers(): HasMany
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
        return $this->belongsTo(User::class);
    }

    /**
     * @var array $fillable fields to be mass-assigned.
     */
    protected $fillable = ['first_name', 'last_name', 'company_name'];
}
