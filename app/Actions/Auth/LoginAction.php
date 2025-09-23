<?php

namespace App\Actions\Auth;

use App\Services\AuthService;

class LoginAction
{
    public function __construct(private AuthService $authService) {}

    public function handle(array $data): array|bool
    {
        return $this->authService->login($data);
    }
}
