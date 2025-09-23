<?php

namespace App\Actions\Auth;

use App\Services\AuthService;

class LogoutAction
{
    public function __construct(private AuthService $authService) {}

    public function handle($user): void
    {
        $this->authService->logout($user);
    }
}
