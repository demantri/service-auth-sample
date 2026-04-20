<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function login($credentials)
    {
        if (!$token = Auth::attempt($credentials)) {
            return null;
        }

        return [
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => JWTAuth::factory()->getTTL() * 60,
            'user'         => JWTAuth::user(),
        ];
    }

    public function me()
    {
        return JWTAuth::user();
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return true;
    }
}
