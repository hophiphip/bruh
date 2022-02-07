<?php

namespace App\Providers;

use App\Services;
use App\Services\Interfaces;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;

class QueryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            Interfaces\SearchServiceInterface::class,

            function ($app) {
                //
                // toggling db-search/elasticsearch
                //
                if (!config('services.search.enabled')) {
                    return new Services\OffersSearchService();
                }

                return new Services\ElasticsearchSearchService(
                    $app->make(Client::class)
                );
            }
        );

        $this->bindSearchClient();
    }

    private function bindSearchClient()
    {
        $this->app->bind(Client::class, function ($app) {
            return ClientBuilder::create()
                ->setHosts($app['config']->get('services.search.hosts'))
                ->build();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
