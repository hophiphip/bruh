<?php

namespace App\Observers;

use App\Models\Insurer;
use Illuminate\Support\Facades\Redis;

class InsurerObserver
{
    /**
     * Initialize cached value.
     *
     * @return void
     */
    public static function initialize()
    {
        Redis::set(Insurer::$cacheCountKey, Insurer::count());
    }

    /**
     * Handle the Insurer "created" event.
     *
     * @param Insurer $insurer
     * @return void
     */
    public function created(Insurer $insurer)
    {
        Redis::incr(Insurer::$cacheCountKey);
    }

    /**
     * Handle the Insurer "updated" event.
     *
     * @param Insurer $insurer
     * @return void
     */
    public function updated(Insurer $insurer)
    {
        //
    }

    /**
     * Handle the Insurer "deleted" event.
     *
     * @param Insurer $insurer
     * @return void
     */
    public function deleted(Insurer $insurer)
    {
        Redis::decr(Insurer::$cacheCountKey);
    }

    /**
     * Handle the Insurer "restored" event.
     *
     * @param Insurer $insurer
     * @return void
     */
    public function restored(Insurer $insurer)
    {
        Redis::incr(Insurer::$cacheCountKey);
    }

    /**
     * Handle the Insurer "force deleted" event.
     *
     * @param Insurer $insurer
     * @return void
     */
    public function forceDeleted(Insurer $insurer)
    {
        Redis::decr(Insurer::$cacheCountKey);
    }
}
