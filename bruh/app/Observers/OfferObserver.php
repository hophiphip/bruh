<?php

namespace App\Observers;

use App\Models\Offer;
use Illuminate\Support\Facades\Redis;

class OfferObserver
{
    /**
     * Initialize cached value.
     *
     * @return void
     */
    public static function initialize()
    {
        Redis::set(Offer::$cacheKey, Offer::count());
    }

    /**
     * Handle the Offer "created" event.
     *
     * @param Offer $offer
     * @return void
     */
    public function created(Offer $offer)
    {
        Redis::set(Offer::$cacheKey, Offer::count());
    }

    /**
     * Handle the Offer "updated" event.
     *
     * @param Offer $offer
     * @return void
     */
    public function updated(Offer $offer)
    {
        //
    }

    /**
     * Handle the Offer "deleted" event.
     *
     * @param Offer $offer
     * @return void
     */
    public function deleted(Offer $offer)
    {
        Redis::set(Offer::$cacheKey, Offer::count());
    }

    /**
     * Handle the Offer "restored" event.
     *
     * @param Offer $offer
     * @return void
     */
    public function restored(Offer $offer)
    {
        Redis::set(Offer::$cacheKey, Offer::count());
    }

    /**
     * Handle the Offer "force deleted" event.
     *
     * @param Offer $offer
     * @return void
     */
    public function forceDeleted(Offer $offer)
    {
        Redis::set(Offer::$cacheKey, Offer::count());
    }
}
