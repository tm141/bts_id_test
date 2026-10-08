<?php

namespace App\DTOs\Auth;

use App\Models\User;

final readonly class AuthResultData
{
    public function __construct(
        public User $user,
        public string $token,
    ) {}

    /**
     * @return array{user: User, token: string}
     */
    public function toArray(): array
    {
        return [
            'user' => $this->user,
            'token' => $this->token,
        ];
    }
}
