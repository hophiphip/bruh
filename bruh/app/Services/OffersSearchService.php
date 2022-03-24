<?php

namespace App\Services;

use App\Models\Offer;
use App\Services\Interfaces\SearchServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class OffersSearchService implements SearchServiceInterface
{
    public function search(string $query = '', int $size = 1000, int $page = 0): LengthAwarePaginator
    {
        return Offer::query()
            ->where('description', 'LIKE', "%{$query}%")
            ->paginate($size, ['*'], 'page', $page);
    }
}
