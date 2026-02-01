<?php
namespace App\Features\Infrastructure\Persistence\GroupStudent;
use App\Models\GroupMember;

class GroupMemberRepository
{
    // Repository methods will be implemented here
    
    public function __construct(private GroupMember $group_member)
    {
    }

    public function findById(int $id): ?GroupMember
    {
        return $this->group_member->find($id);
    }
    public function create(array $data): GroupMember
    {
        return $this->group_member->create($data);
    }
    public function update(GroupMember $group_member, array $data): GroupMember
    {
        $group_member->update($data);
        return $group_member;
    }
    public function delete(GroupMember $group_member): void
    {
        $group_member->delete();
    }
}