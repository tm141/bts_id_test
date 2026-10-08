<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function findByUsername(string $username): ?User
    {
        return User::where('username', $username)->first();
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): User
    {
        return User::create($data);
    }
}
