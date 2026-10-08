<?php

namespace App\DTOs\Auth;

use App\Http\Requests\LoginRequest;

final readonly class LoginData
{
    public function __construct(
        public string $username,
        public string $password,
    ) {}

    public static function fromRequest(LoginRequest $request): self
    {
        $data = $request->validated();

        return new self(
            username: $data['username'],
            password: $data['password'],
        );
    }
}
