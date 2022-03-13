<?php

namespace App\Services;

use App\Models\Offer;
use App\Services\Interfaces\SearchServiceInterface;
use Elasticsearch\Client;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

// TODO: Mb. use ScoutElastic ?

class ElasticsearchSearchService implements SearchServiceInterface
{
    /**
     * @var Client
     */
    private Client $elasticsearch;

    public function __construct(Client $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    // TODO: This is slow, need to figure out `scroll` feature to fix it.
    public function search(string $query = '', int $size = 10, int $page = 1): LengthAwarePaginator
    {
        $items = $this->searchWithElasticsearch($query);
        $collection = $this->buildCollection($items);

        return new LengthAwarePaginator(
            $collection,
            $collection->count(),
            $size,
            $page
        );
    }

    private function searchWithElasticsearch(string $query = ''): array
    {
        $model = new Offer;

        return $this->elasticsearch->search([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),

            // TODO: Hardcoded size limit, but for pagination `scroll` feature must be used.
            'size' => 1000,

            'body' => [

                //
                // TODO: should/must/bool/e.t.c and other cool stuff is not parsing correctly for elastic ver. >= 7.7.0
                //      Might be related: https://github.com/nextcloud/fulltextsearch_elasticsearch/issues/106
                //

                'query' => [
                    'multi_match' => [
                        'fields' => ['case_name^2', 'description', 'insurer_company_name'],
                        'fuzziness' => 'AUTO',
                        'query' => $query,
                    ]
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
