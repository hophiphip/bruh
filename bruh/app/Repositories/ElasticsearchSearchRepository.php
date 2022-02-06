<?php

namespace App\Repositories;

use App\Models\Offer;
use App\Repositories\Interfaces\SearchRepositoryInterface;
use Elasticsearch\Client;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class ElasticsearchSearchRepository implements SearchRepositoryInterface
{
    /**
     * @var Client
     */
    private Client $elasticsearch;

    public function __construct(Client $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    public function search(string $query = ''): Collection
    {
        $items = $this->searchOnElasticsearch($query);
        return $this->buildCollection($items);
    }

    private function searchOnElasticsearch(string $query = ''): array
    {
        $model = new Offer;

        return $this->elasticsearch->search([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'body' => [
                'query' => [
                    'multi_match' => [
                        'fields' => ['name', 'company', 'description'],
                        'query' => $query,
                    ],
                ],
            ],
        ]);
    }
    private function buildCollection(array $items): Collection
    {
        $ids = Arr::pluck($items['hits']['hits'], '_id');

        return Offer::findMany($ids)
            ->sortBy(function ($offer) use ($ids) {
                return array_search($offer->getKey(), $ids);
            });
    }
}
