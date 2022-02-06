<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface SearchRepositoryInterface
{
    public function search(string $query = ''): Collection;
}
