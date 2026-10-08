<?php

namespace App\Services;

use App\DTOs\Auth\AuthResultData;
use App\DTOs\Auth\LoginData;
use App\DTOs\Auth\RegisterData;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function __construct(private UserRepository $userRepository) {}

    public function register(RegisterData $data): AuthResultData
    {
        $user = $this->userRepository->create($data->toArray());

        return new AuthResultData($user, $this->issueToken($user));
    }

    /**
     * @throws AuthenticationException
     */
    public function login(LoginData $data): AuthResultData
    {
        $user = $this->userRepository->findByUsername($data->username);

        if (! $user || ! Hash::check($data->password, $user->password)) {
            throw new AuthenticationException('Invalid credentials');
        }

        return new AuthResultData($user, $this->issueToken($user));
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }

    private function issueToken(User $user): string
    {
        return $user->createToken('api')->plainTextToken;
    }
}
