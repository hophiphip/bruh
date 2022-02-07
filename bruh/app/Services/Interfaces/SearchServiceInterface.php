<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface SearchServiceInterface
{
    public function search(string $query = ''): Collection;
}
