<?php
namespace App\Features\Infrastructure\Persistence\Auth;
use App\Models\UserMajor;

class UserMajorRepository
{
    public function __construct(private UserMajor $userMajor)
    {
    }

    public function findByCode(string $majorCode): ?UserMajor
    {
        return $this->userMajor->where('major_code', $majorCode)->first();
    }

    public function findById(int $id): ?UserMajor
    {
        return $this->userMajor->find($id);
    }

    public function create(array $data): UserMajor
    {
        return $this->userMajor->create($data);
    }

    public function update(UserMajor $userMajor, array $data): UserMajor
    {
        $userMajor->update($data);
        return $userMajor;
    }
}