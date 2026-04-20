<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);
        
        $credentials = $request->only('email', 'password');

        $result = $this->authService->login($credentials);

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Email / Password salah'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'data' => $result
        ]);
    }

    public function me()
    {
        return response()->json([
            'success' => true,
            'data' => $this->authService->me()
        ]);
    }

    public function logout()
    {
        $this->authService->logout();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil'
        ]);
    }
}
