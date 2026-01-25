<?php
namespace App\Features\Infrastructure\Persistence\Auth;
use App\Models\Major;

class MajorRepository
{
    public function __construct(private Major $major)
    {
    }

    public function findByCode(string $majorCode): ?Major
    {
        return $this->major->where('major_code', $majorCode)->first();
    }

    public function findById(int $id): ?Major
    {
        return $this->major->find($id);
    }

    public function create(array $data): Major
    {
        return $this->major->create($data);
    }

    public function update(Major $major, array $data): Major
    {
        $major->update($data);
        return $major;
    }
}