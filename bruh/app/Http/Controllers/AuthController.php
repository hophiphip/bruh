<?php

namespace App\Http\Controllers;

use App\Events\UserLogIn;
use App\Events\UserSignUp;
use App\Http\Requests\PostLogInRequest;
use App\Http\Requests\PostSignUpRequest;
use App\Models\LoginToken;
use App\Models\Role;
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

    public function login(PostLogInRequest $request): RedirectResponse
    {
        $submit = $request->validated();

        UserLogIn::dispatch(User::whereEmail($submit['email'])->firstOrFail());

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

    public function signUp(PostSignUpRequest $request): Redirector|Application|RedirectResponse
    {
        $submit = $request->validated();

        $user = User::createNew($submit['email']);

        $user->roles()->sync([ Role::insurerRoleId() ]);

        $user->insurer()->create([
            'first_name'   => $submit['first_name'],
            'last_name'    => $submit['last_name'],
            'company_name' => $submit['company_name'],
        ]);

        UserSignUp::dispatch($user);

        session()->flash('success', true);

        return redirect(RouteServiceProvider::SIGN_UP);
    }

    public function logout(): Redirector|Application|RedirectResponse
    {
        Auth::logout();

        return redirect(RouteServiceProvider::LOGIN);
    }
}
