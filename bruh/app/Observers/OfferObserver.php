<?php

declare(strict_types=1);

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
        Redis::set(Offer::$cacheCountKey, Offer::count());
    }

    /**
     * Handle the Offer "created" event.
     *
     * @param Offer $offer
     * @return void
     */
    public function created(Offer $offer)
    {
        Redis::incr(Offer::$cacheCountKey);
    }

    /**
     * Handle the Offer "deleted" event.
     *
     * @param Offer $offer
     * @return void
     */
    public function deleted(Offer $offer)
    {
        Redis::decr(Offer::$cacheCountKey);
    }

    /**
     * Handle the Offer "restored" event.
     *
     * @param Offer $offer
     * @return void
     */
    public function restored(Offer $offer)
    {
        Redis::incr(Offer::$cacheCountKey);
    }

    /**
     * Handle the Offer "force deleted" event.
     *
     * @param Offer $offer
     * @return void
     */
    public function forceDeleted(Offer $offer)
    {
        Redis::decr(Offer::$cacheCountKey);
    }
}
