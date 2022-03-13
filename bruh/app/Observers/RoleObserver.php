<?php

namespace App\Observers;

use App\Models\Role;
use Illuminate\Support\Facades\Redis;

class RoleObserver
{
    /**
     * Initialize cached value.
     *
     * @return void
     */
    public static function initialize()
    {
        Redis::set(Role::$cacheInsurerRoleId, Role::whereName('insurer')->firstOrFail()->id);
    }

    /**
     * Handle the Role "created" event.
     *
     * @param Role $role
     * @return void
     */
    public function created(Role $role)
    {
        //
    }

    /**
     * Handle the Role "updated" event.
     *
     * @param Role $role
     * @return void
     */
    public function updated(Role $role)
    {
        Redis::set(Role::$cacheInsurerRoleId, Role::whereName('insurer')->firstOrFail()->id);
    }

    /**
     * Handle the Role "deleted" event.
     *
     * @param Role $role
     * @return void
     */
    public function deleted(Role $role)
    {
        Redis::set(Role::$cacheInsurerRoleId, Role::whereName('insurer')->firstOrFail()->id);
    }

    /**
     * Handle the Role "restored" event.
     *
     * @param Role $role
     * @return void
     */
    public function restored(Role $role)
    {
        Redis::set(Role::$cacheInsurerRoleId, Role::whereName('insurer')->firstOrFail()->id);
    }

    /**
     * Handle the Role "force deleted" event.
     *
     * @param Role $role
     * @return void
     */
    public function forceDeleted(Role $role)
    {
        //
    }
}
