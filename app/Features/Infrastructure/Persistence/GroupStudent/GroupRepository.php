<?php
namespace App\Features\Infrastructure\Persistence\GroupStudent;
use App\Models\Group;

class GroupRepository
{
    // Repository methods will be implemented here
    
    public function __construct(private Group $group)
    {
    }

    public function findById(int $id): ?Group
    {
        return $this->group->find($id);
    }
    public function create(array $data): Group
    {
        return $this->group->create($data);
    }
    public function update(Group $group, array $data): Group
    {
        $group->update($data);
        return $group;
    }
    public function delete(Group $group): void
    {
        $group->delete();
    }
}