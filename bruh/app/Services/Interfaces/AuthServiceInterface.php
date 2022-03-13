<?php

namespace App\Services\Interfaces;

use App\Models\LoginToken;

interface AuthServiceInterface
{
    public static function logIn(string $email): void;
    public static function logInVerify(LoginToken $token): void;
    public static function signUp(array $validatedRequest, array $roles): void;
    public static function logOut(): void;
}
