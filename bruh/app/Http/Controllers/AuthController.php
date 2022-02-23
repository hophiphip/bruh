<?php

namespace App\Http\Controllers;

use App\Models\LoginToken;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;


class AuthController extends Controller
{
    public function showLogin(): Factory|View|Application
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $submit = $request->validate([
            'email' => [ 'required', 'email', 'exists:users,email'],
        ]);

        User::whereEmail($submit['email'])->first()->sendLoginLink();

        session()->flash('success', true);

        return redirect(RouteServiceProvider::LOGIN);
    }

    public function verifyLogin(Request $request, $token): Redirector|Application|RedirectResponse
    {
        $token = LoginToken::whereToken(hash('sha256', $token))->firstOrFail();

        // TODO: Remove later
        Log::channel('stderr')->info(URL::hasValidSignature($request));
        Log::channel('stderr')->info($request->hasValidSignature());
        Log::channel('stderr')->info($token->isValid());
        Log::channel('stderr')->info($request->url());
        Log::channel('stderr')->info($request->fullUrl());
        Log::channel('stderr')->info($request->path());
        Log::channel('stderr')->info($request->header());
        $url = $request->url();
        $original = rtrim($url.'?'.Arr::query(Arr::except($request->query(), 'signature')), '?');
        Log::channel('stderr')->info($original);

        // TODO: Fails when behind a proxy
        abort_unless($request->hasValidSignature(), 403, "Provided link is invalid");
        abort_unless($token->isValid(), 401, "Provided link has expired");

        $token->consume();

        Auth::login($token->user);

        return redirect(RouteServiceProvider::INSURER);
    }

    /* TODO: Look at Vercel routes + 3D globe like in GitHub */
    public function showSignUp()
    {
        // ...
    }

    public function signUp(Request $request)
    {
        $submit = $request->validate([
            'email' => [ 'required', 'email', 'exists:users,email'],
            'company_name' => [ 'required' ],
            'first_name' => [ 'required' ],
            'last_name' => [ 'required' ],
        ]);

        // ...
    }

    public function logout(): Redirector|Application|RedirectResponse
    {
        Auth::logout();

        return redirect(RouteServiceProvider::LOGIN);
    }
}
