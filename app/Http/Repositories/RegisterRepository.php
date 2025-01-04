<?php

namespace App\Http\Repositories;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterRepository
{
    /**
     * Register a new user.
     *
     * @param array $data
     * @return User
     */
    public function register(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone'=> $data['phone'],
        ]);
        return $user;
    }
}
