<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OffersController;
use App\Models\Insurer;
use App\Models\Offer;
use App\Providers\RouteServiceProvider;
use App\Services\Interfaces\SearchServiceInterface;
use Illuminate\Support\Facades\Auth;
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
Route::get(RouteServiceProvider::HOME, function () {
    return view('index',[
        'insurers_count' => Insurer::count(),
        'offers_count' => Offer::count(),
    ]);
});

Route::get(RouteServiceProvider::OFFERS, function (SearchServiceInterface $service) {
    $query = request('q') ?? '';
    $offers = $service->search($query);

    return view('offers', [
        'offers' => $offers,
    ]);
});

Route::group(['middleware' => ['guest']], function() {
    Route::get(RouteServiceProvider::LOGIN, [AuthController::class, 'showLogin'])->name('login.show');
    Route::post(RouteServiceProvider::LOGIN, [AuthController::class, 'login'])->name('login');
    Route::get(RouteServiceProvider::VERIFY_LOGIN . '/{token}', [AuthController::class, 'verifyLogin'])->name('verify-login');

    Route::get(RouteServiceProvider::GETTING_STARTED, function () {
        return view('auth.getting-started');
    })->name('getting-started');
});

Route::get(RouteServiceProvider::LOGOUT, [AuthController::class, 'logout'])->name('logout');

/* Only visible for logged-in users */
Route::get(RouteServiceProvider::INSURER, function () {
   $user = Auth::user();

   return view('insurer', [
       'email' => $user->email,
       'insurer' => $user->insurer()->get()->first(),
   ]);
})->middleware('auth');
