<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {
        $fields = $request->only(['email', 'password']);
        try {
            $token = $this->authService->login($fields);
        } catch (ValidationException $exception) {
            return response()->json(
                ['message' => 'Invalid username or password'],
                401
            );
        }

        return response()->json(['token' => $token]);
    }

    public function register(RegisterRequest $request)
    {
        $fields = $request->only(['email', 'name', 'type', 'password']);
        $user = $this->authService->register($fields);

        return response()->json($user,201);
    }

}
