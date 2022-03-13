<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostLogInRequest;
use App\Http\Requests\PostSignUpRequest;
use App\Models\LoginToken;
use App\Models\Role;
use App\Providers\RouteServiceProvider;
use App\Services\Interfaces\AuthServiceInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;


class AuthController extends Controller
{
    public function showLogin(): Factory|View|Application
    {
        return view('auth.login');
    }

    public function login(AuthServiceInterface $service, PostLogInRequest $request): RedirectResponse
    {
        $submit = $request->validated();

        $service->logIn($submit['email']);

        session()->flash('success', true);

        return redirect(RouteServiceProvider::LOGIN);
    }

    public function verifyLogin(AuthServiceInterface $service, Request $request, $token): Redirector|Application|RedirectResponse
    {
        $token = LoginToken::whereToken(hash('sha256', $token))->firstOrFail();

        abort_unless($request->hasValidSignature(), 403, "Provided link is invalid");
        abort_unless($token->isValid(), 401, "Provided link has expired");

        $service->logInVerify($token);

        return redirect(RouteServiceProvider::INSURER);
    }

    public function showSignUp(): Factory|View|Application
    {
        return view('auth.sign-up');
    }

    public function signUp(AuthServiceInterface $service, PostSignUpRequest $request): Redirector|Application|RedirectResponse
    {
        $submit = $request->validated();

        $service->signUp($submit, [ Role::insurerRoleId() ]);

        session()->flash('success', true);

        return redirect(RouteServiceProvider::SIGN_UP);
    }

    public function logout(AuthServiceInterface $service): Redirector|Application|RedirectResponse
    {
        $service->logOut();

        return redirect(RouteServiceProvider::LOGIN);
    }
}
