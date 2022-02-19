<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * The path for search query page for the application.
     *
     * @var string
     */
    public const OFFERS = '/offers';

    /**
     * The path for login verification route for the application.
     *
     * @var string
     */
    public const VERIFY_LOGIN = '/verify-login';

    /**
     * The path for the "login" route for the application.
     *
     * @var string
     */
    public const LOGIN = '/login';

    /**
     * The path for the "logout" route for the application.
     *
     * @var string
     */
    public const LOGOUT = "/logout";

    /**
     * The path for insurer personal panel for the application.
     *
     * @var string
     */
    public const INSURER = '/insurer';

    /**
     * The path for sign up page.
     *
     * @var string
     */
    public const SIGN_UP = '/sign-up';

    /**
     * The path for sign in / sign up page.
     *
     * @var string
     */
    public const GETTING_STARTED = '/getting-started';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
