<?php

namespace App\DTOs\Auth;

use App\Http\Requests\RegisterRequest;

final readonly class RegisterData
{
    public function __construct(
        public string $username,
        public string $password,
    ) {}

    public static function fromRequest(RegisterRequest $request): self
    {
        $data = $request->validated();

        return new self(
            username: $data['username'],
            password: $data['password'],
        );
    }

    /**
     * @return array<string, string>
     */
    public function toArray(): array
    {
        return [
            'username' => $this->username,
            'password' => $this->password,
        ];
    }
}
