<?php

namespace App\Services\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface SearchServiceInterface
{
    public function search(string $query = '', int $size = 1000, int $page = 0): LengthAwarePaginator;
}
