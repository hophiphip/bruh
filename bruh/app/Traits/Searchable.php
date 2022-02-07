<?php

namespace App\Traits;

use App\Elasticsearch\ElasticsearchObserver;

trait Searchable
{
    public static function bootSearchable()
    {
        if (config('services.search.enabled')) {
            static::observe(ElasticsearchObserver::class);
        }
    }

    public function getSearchIndex(): string
    {
        return $this->getTable();
    }

    public function getSearchType()
    {
        if (property_exists($this, 'useSearchType')) {
            return $this->useSearchType;
        }

        return $this->getTable();
    }

    public function toSearchArray(): array
    {
        /* TODO: Mb. move Offer->toArray() here ? OF no ? as it is a general trait */
        return $this->toArray();
    }
}
