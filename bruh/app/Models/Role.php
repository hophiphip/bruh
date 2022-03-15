<?php

namespace App\Models;

use App\Observers\RoleObserver;
use App\Providers\DatabaseTableNamesProvider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Redis;

class Role extends Model
{
    use HasFactory;

    /**
     * @var string database table name
     */
    protected $table = DatabaseTableNamesProvider::ROLE_TABLE;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
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
            RoleObserver::initialize();
            Role::observe(RoleObserver::class);
        }
    }

    /**
     * Cached key for value of insurer role id.
     *
     * @var string
     */
    public static string $cacheInsurerRoleId = 'role:insurer:id';

    /**
     * Get users by role.
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Get insurer role id.
     *
     * @return int
     */
    public static function insurerRoleId(): int
    {
        $id = Redis::get(self::$cacheInsurerRoleId);

        if ($id == null) {
            RoleObserver::set();
            $id = Redis::get(self::$cacheInsurerRoleId);
        }

        return $id;
    }
}
