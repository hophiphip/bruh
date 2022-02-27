<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\InsurerController;
use App\Http\Controllers\WebController;
use App\Providers\RouteServiceProvider;
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

Route::get(RouteServiceProvider::HOME, [WebController::class, 'home']);
Route::get(RouteServiceProvider::OFFERS, [WebController::class, 'offers'])->name('offers');

Route::group(['middleware' => ['guest']], function() {
    Route::get(RouteServiceProvider::GETTING_STARTED, [WebController::class, 'gettingStarted'])->name('getting-started');

    Route::get(RouteServiceProvider::LOGIN, [AuthController::class, 'showLogin'])->name('login.show');
    Route::get(RouteServiceProvider::VERIFY_LOGIN . '/{token}', [AuthController::class, 'verifyLogin'])->name('verify-login');

    Route::get(RouteServiceProvider::SIGN_UP, [AuthController::class, 'showSignUp'])->name('signUp.show');

    Route::group(['middleware' => ['xss.sanitize']], function () {
        Route::post(RouteServiceProvider::LOGIN, [AuthController::class, 'login'])->name('login');
        Route::post(RouteServiceProvider::SIGN_UP, [AuthController::class, 'signUp'])->name('signUp');
    });
});

Route::get(RouteServiceProvider::REFRESH_CAPTCHA, [CaptchaController::class, 'refreshCaptcha'])->name('refresh-captcha');

/* Only visible for logged-in users */
Route::get(RouteServiceProvider::LOGOUT, [AuthController::class, 'logout'])->name('logout');
Route::get(RouteServiceProvider::INSURER, [InsurerController::class, 'insurer'])->middleware('auth')->name('insurer');
