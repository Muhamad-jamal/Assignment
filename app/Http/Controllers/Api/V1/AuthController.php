<?php

namespace App\Http\Controllers\Api\V1;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Actions\Auth\LoginAction;
use App\Actions\Auth\LogoutAction;
use App\Actions\Auth\RegisterAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\Api\V1\RegisterRequest;

class AuthController extends Controller
{
    use ApiResponse;

    public function register(RegisterRequest $request, RegisterAction $action)
    {
        $user = $action->handle($request->all());
        return $this->storeResponse(
            new UserResource($user),
            'User registered successfully',
        );
    }

    public function login(Request $request, LoginAction $action)
    {
        $data = $action->handle($request->only('email', 'password'));

        return $this->showResponse('Login successful', $data);
    }

    public function logout(Request $request, LogoutAction $action)
    {
        $action->handle($request->user());

        return $this->showResponse('Logged out successfully');
    }
}
