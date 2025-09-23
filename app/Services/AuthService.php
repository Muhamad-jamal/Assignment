<?php

namespace App\Services;

use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    protected AuthRepository $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register(array $data)
    {
        $user = $this->authRepository->createUser([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->createToken('auth-token')->plainTextToken;

        return $user;
    }

    public function login(array $credentials): array|bool
    {
        if (!$this->authRepository->attemptLogin($credentials)) {

            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = $this->authRepository->findByEmail($credentials['email']);
        $token = $user->createToken('auth-token')->plainTextToken;

        return [
            'access_token' => $token,
        ];
    }


    public function logout($user): void
    {
        $user->currentAccessToken()->delete();
    }

    public function getUser($user): array
    {
        return ['user' => $user];
    }
}
