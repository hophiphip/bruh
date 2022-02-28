<?php

namespace App\Providers;

use App\Models\Insurer;
use App\Models\Offer;
use App\Models\OfferRequest;
use App\Observers\InsurerObserver;
use App\Observers\OfferObserver;
use App\Observers\OfferRequestObserver;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Force HTTPS in production.
     *
     * @return void
     */
    protected function forceHTTPSInProd()
    {
        if ($this->app->environment('production'))
        {
            URL::forceScheme('https');
        }
    }

    /**
     * Set model observers.
     *
     * @return void
     */
    protected function setObservers()
    {
        //
        // `APP_WORKER` doesn't need to do model-related things.
        //
        //  NOTE: This is just a workaround for fast local development
        //        to skip installing unnecessary extensions.
        //
        if (!env('APP_WORKER'))
        {
            InsurerObserver::initialize();
            Insurer::observe(InsurerObserver::class);

            OfferObserver::initialize();
            Offer::observe(OfferObserver::class);

            OfferRequestObserver::initialize();
            OfferRequest::observe(OfferRequestObserver::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->forceHTTPSInProd();
        $this->setObservers();
    }
}
