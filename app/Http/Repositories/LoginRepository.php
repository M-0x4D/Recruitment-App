<?php

namespace App\Http\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginRepository
{
    /**
     * Attempt to login a user.
     *
     * @param array $credentials
     * @return User
     */
    public function attemptLogin(array $credentials)
    {
        if (filter_var($credentials['email'] ?? null, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $credentials['email'])->first();
        } elseif (isset($credentials['phone'])) {
            $user = User::where('phone', $credentials['phone'])->first();
        } elseif (isset($credentials['username'])) {
            $user = User::where('username', $credentials['username'])->first();
        }

    if (!$user || !Hash::check($credentials['password'], $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }
        return  $user;
    }

    /**
     * Logout the authenticated user.
     *
     * @return void
     */
    public function logout()
    {
        Auth::logout();
    }
}
