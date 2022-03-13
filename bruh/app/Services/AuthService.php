<?php

namespace App\Services;

use App\Events\UserLogIn;
use App\Events\UserSignUp;
use App\Models\LoginToken;
use App\Models\User;
use App\Services\Interfaces\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;

class AuthService implements AuthServiceInterface
{
    public function __construct()
    {
        //
    }

    public static function logIn(string $email): void
    {
        UserLogIn::dispatch(User::whereEmail($email)->firstOrFail());
    }

    public static function logInVerify(LoginToken $token): void
    {
        $token->consume();
        $token->user->verify();

        Auth::login($token->user);
    }

    public static function signUp(array $validatedRequest, array $roles): void
    {
        $user = User::createNew($validatedRequest['email']);

        $user->roles()->sync($roles);

        $user->insurer()->create([
            'first_name'   => $validatedRequest['first_name'],
            'last_name'    => $validatedRequest['last_name'],
            'company_name' => $validatedRequest['company_name'],
        ]);

        UserSignUp::dispatch($user);
    }

    public static function logOut(): void
    {
        Auth::logout();
    }
}
