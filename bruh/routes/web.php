<?php

use App\Http\Controllers\OffersController;
use App\Models\Insurer;
use App\Models\Offer;
use App\Services\Interfaces\SearchServiceInterface;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/* TODO: Add caching */
Route::get('/', function () {
    return view('index',[
        'insurers_count' => Insurer::count(),
        'offers_count' => Offer::count(),
    ]);
});

Route::get('offers', function (SearchServiceInterface $service) {
    $query = request('q') ?? '';
    $offers = $service->search($query);

    return view('offers', [
        'offers' => $offers,
    ]);
});
