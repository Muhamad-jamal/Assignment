<?php

namespace App\Actions\Auth;

use App\Services\AuthService;

class RegisterAction
{
    public function __construct(private AuthService $authService) {}

    public function handle(array $data)
    {
        return $this->authService->register($data);
    }
}
