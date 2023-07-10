<?php

namespace App\Modules\Authentication\Services;

use Illuminate\Support\Facades\Auth;
use App\Modules\Authentication\Models\User;

class AuthService
{

    public function logout(): void
    {
        Auth::logout();
    }

    public function login(array $credentials): bool
    {
        return Auth::attempt($credentials);
    }

    public function authenticated_user(): User
    {
        return Auth::user();
    }

}
