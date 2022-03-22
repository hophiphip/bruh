<?php

namespace App\Http\Controllers\Api;

use App\Models\ClientLocation;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class ClientLocationController extends Controller
{
    public function index(): Collection|JsonResponse
    {
        return ClientLocation::all()->pluck('location');
    }
}
