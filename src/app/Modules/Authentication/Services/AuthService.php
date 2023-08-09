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

    public function user_logout(): void
    {
        auth()->user()->currentAccessToken()->delete();
    }

    public function user_login(array $credentials): bool
    {
        return Auth::attempt($credentials);
    }

    public function generate_token(User $user): string
    {
        return $user->createToken($user->email)->plainTextToken;
    }

    public function user_profile(): User
    {
        return Auth::user();
    }

}
