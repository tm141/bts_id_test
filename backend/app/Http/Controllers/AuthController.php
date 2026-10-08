<?php

namespace App\Http\Controllers;

use App\DTOs\Auth\LoginData;
use App\DTOs\Auth\RegisterData;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}

    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authService->register(RegisterData::fromRequest($request));

        return response()->json($result->toArray(), 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authService->login(LoginData::fromRequest($request));

        return response()->json($result->toArray(), 200);
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());

        return response()->json(['message' => 'Logged out'], 200);
    }

    public function getUser(Request $request): JsonResponse
    {
        return response()->json($request->user(), 200);
    }
}
