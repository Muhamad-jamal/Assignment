<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthRepository
{
    public function createUser(array $data): User
    {
        return User::create($data);
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function attemptLogin(array $credentials): bool
    {
        return Auth::attempt($credentials);
    }
}
