<?php

namespace App\Observers;

use App\Models\Insurer;

class InsurerObserver
{
    /**
     * Redis key for insurer count value.
     *
     * @var string
     */
    public static string $cacheKey = 'insurer:count';

    /**
     * Handle the Insurer "created" event.
     *
     * @param Insurer $insurer
     * @return void
     */
    public function created(Insurer $insurer)
    {
        //
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
        //
    }

    /**
     * Handle the Insurer "restored" event.
     *
     * @param Insurer $insurer
     * @return void
     */
    public function restored(Insurer $insurer)
    {
        //
    }

    /**
     * Handle the Insurer "force deleted" event.
     *
     * @param Insurer $insurer
     * @return void
     */
    public function forceDeleted(Insurer $insurer)
    {
        //
    }
}
