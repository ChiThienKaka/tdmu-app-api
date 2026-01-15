<?php
namespace App\Features\Infrastructure\Persistence\Eloquent;
use App\Models\User;

class UserRepository
{
    public function __construct(private User $user)
    {
    }

    public function findByEmail(string $email): ?User
    {
        return $this->user->where('email', $email)->first();
    }
    // kiểm tra tồn tại email
    public function existsByEmail(string $email): bool
    {
        return $this->user->where('email', $email)->exists();
    }
    public function findById(int $id): ?User
    {
        return $this->user->find($id);
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
}