<?php

namespace App\Models;

use App\Observers\InsurerObserver;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\Insurer
 *
 * @property int $id
 * @property int $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $company_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Offer[] $offers
 * @property-read int|null $offers_count
 * @property-read User $user
 * @method static \Database\Factories\InsurerFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Insurer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Insurer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Insurer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Insurer whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Insurer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Insurer whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Insurer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Insurer whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Insurer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Insurer whereUserId($value)
 * @mixin \Eloquent
 */
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
     * Define model observers.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        if (!env('APP_WORKER'))
        {
            InsurerObserver::initialize();
            Insurer::observe(InsurerObserver::class);
        }
    }

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
