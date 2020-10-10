<?php

namespace App\Services;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    private $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function login(array $fields)
    {
        $user = $this->model->where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user->createToken(User::TOKEN_NAME)->plainTextToken;
    }

    public function register(array $fields)
    {
        $this->model->email = $fields['email'];
        $this->model->name = $fields['name'];
        $this->model->type = $fields['type'];
        $this->model->password = Hash::make($fields['password']);
        $this->model->save();

        return $this->model;
    }
}
