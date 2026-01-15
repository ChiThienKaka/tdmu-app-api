<?php

namespace App\Features\Auth\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AuthRepository
{
    public function __construct(private User $user)
    {
    }

    public function findByEmail(string $email): ?User
    {
        return $this->user->where('email', $email)->first();
    }

    public function findByGoogleId(string $googleId): ?User
    {
        return $this->user->where('google_id', $googleId)->first();
    }

    public function create(array $data): User
    {
        return $this->user->create($data);
    }

    public function update(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }

    public function findById(int $id): ?User
    {
        return $this->user->find($id);
    }
}
