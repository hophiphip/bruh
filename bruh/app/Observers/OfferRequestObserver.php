<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\OfferRequest;
use Illuminate\Support\Facades\Redis;

class OfferRequestObserver
{
    /**
     * Initialize cached value.
     *
     * @return void
     */
    public static function initialize()
    {
        Redis::set(OfferRequest::$cacheCountKey, OfferRequest::count());
    }

    /**
     * Handle the OfferRequest "created" event.
     *
     * @param OfferRequest $offerRequest
     * @return void
     */
    public function created(OfferRequest $offerRequest)
    {
        Redis::incr(OfferRequest::$cacheCountKey);
    }

    /**
     * Handle the OfferRequest "deleted" event.
     *
     * @param OfferRequest $offerRequest
     * @return void
     */
    public function deleted(OfferRequest $offerRequest)
    {
        Redis::decr(OfferRequest::$cacheCountKey);
    }

    /**
     * Handle the OfferRequest "restored" event.
     *
     * @param OfferRequest $offerRequest
     * @return void
     */
    public function restored(OfferRequest $offerRequest)
    {
        Redis::incr(OfferRequest::$cacheCountKey);
    }

    /**
     * Handle the OfferRequest "force deleted" event.
     *
     * @param OfferRequest $offerRequest
     * @return void
     */
    public function forceDeleted(OfferRequest $offerRequest)
    {
        Redis::decr(OfferRequest::$cacheCountKey);
    }
}
