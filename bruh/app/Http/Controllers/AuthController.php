<?php

namespace App\Http\Controllers;

use App\Models\Insurer;
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

        abort_unless($request->hasValidSignature(), 403, "Provided link is invalid");
        abort_unless($token->isValid(), 401, "Provided link has expired");

        $token->consume();

        $token->user->verify();

        Auth::login($token->user);

        return redirect(RouteServiceProvider::INSURER);
    }

    public function showSignUp(): Factory|View|Application
    {
        return view('auth.sign-up');
    }

    public function signUp(Request $request): Redirector|Application|RedirectResponse
    {
        $submit = $request->validate([
            'email' => [ 'required', 'email', 'unique:'. app(User::class)->getTable() . ',email'],
            'company_name' => [ 'required', 'max:255', 'unique:' . app(Insurer::class)->getTable() . ',company_name' ],

            'first_name' => [ 'required', 'max:255' ],
            'last_name' => [ 'required', 'max:255' ],
        ]);

        session()->flash('success', true);

        return redirect(RouteServiceProvider::SIGN_UP);
    }

    public function logout(): Redirector|Application|RedirectResponse
    {
        Auth::logout();

        return redirect(RouteServiceProvider::LOGIN);
    }
}
