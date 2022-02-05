<?php

use App\Http\Controllers\OffersController;
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

Route::get('/', OffersController::class . '@index')->name('index');
Route::get('new', OffersController::class . '@create')->name('new');

Route::get('index', function () {
   return view('index');
});

Route::get('clients', function () {
    return view('clients');
});
