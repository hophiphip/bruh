<?php

namespace App\Repositories;

use App\Models\Offer;
use App\Repositories\Interfaces\SearchRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class OffersSearchRepository implements SearchRepositoryInterface
{
    public function search(string $query = ''): Collection
    {
        return Offer::query()
            ->where('name', 'LIKE', "%{$query}%")
            ->orWhere('company', 'LIKE', "%{$query}%")
            ->get();
    }
}
