<?php

namespace App\Services\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface SearchServiceInterface
{
    public function search(string $query = '', int $size = 10, int $page = 1): LengthAwarePaginator;
}
