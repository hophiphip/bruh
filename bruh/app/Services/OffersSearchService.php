<?php

namespace App\Services;

use App\Models\Offer;
use App\Services\Interfaces\SearchServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class OffersSearchService implements SearchServiceInterface
{
    public function search(string $query = ''): Collection
    {
        return Offer::query()
            ->where('description', 'LIKE', "%{$query}%")
            ->get();
    }
}
