<?php

namespace App\Providers;

use App\Models\Insurer;
use App\Models\Offer;
use App\Models\OfferRequest;
use App\Observers\InsurerObserver;
use App\Observers\OfferObserver;
use App\Observers\OfferRequestObserver;
use App\Observers\RoleObserver;
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
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->forceHTTPSInProd();
    }
}
