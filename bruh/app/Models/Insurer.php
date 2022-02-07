<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Insurer extends Model
{
    use HasFactory;

    /**
     * @var string $table insurer table name
     */
    protected $table = 'insurers';

    /**
     * Get insurers' offers.
     * TODO: This is slooow, and baaad...
     *
     * @return HasMany offers
     */
    public function getOffers(): HasMany
    {
        return $this->hasMany(Offer::class);
    }

    /**
     * @var array $fillable fields to be mass-assigned.
     */
    protected $fillable = ['first_name', 'last_name', 'email', 'company_name'];
}
