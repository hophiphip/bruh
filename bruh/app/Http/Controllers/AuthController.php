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
use Illuminate\Support\Facades\Auth;


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
        abort_unless($request->hasValidSignature() && $token->isValid(), 401);

        $token->consume();

        Auth::login($token->user);

        return redirect(RouteServiceProvider::INSURER);
    }

    public function logout(): Redirector|Application|RedirectResponse
    {
        Auth::logout();

        return redirect(RouteServiceProvider::LOGIN);
    }
}
