<?php
namespace App\Features\Domain\GroupStudent\Repositories;

use App\Models\User;
use App\Models\GroupMember;
use App\Models\Group;

class GroupStudentRepository
{
    // Code for GroupStudentRepository
    public function __construct()
    {
        // Constructor code here
    }
    public function getGroupStudentsByUser(User $user){
        $group_member = $user->groupMembers()->with('group')->get();
        return $group_member;
    }
    public function getUsersByGroup($group_id){
        $members = GroupMember::with('user')->where('group_id', $group_id)->get();
        return $members;
    }

    /**
     * Tạo nhóm mới
     */
    public function createGroup($data, User $creator): Group
    {
        $data['created_by'] = $creator->user_id;
        
        $group = Group::create($data);

        // Tự động thêm người tạo vào nhóm với role "admin"
        GroupMember::create([
            'group_id' => $group->group_id,
            'user_id' => $creator->user_id,
            'member_role' => 'admin',
        ]);

        return $group;
    }

    /**
     * Thêm thành viên vào nhóm
     */
    public function addMembersToGroup($group_id, array $user_ids, $member_role = 'member'): array
    {
        $group = Group::find($group_id);
        
        if (!$group) {
            throw new \Exception('Group not found');
        }

        $addedMembers = [];
        
        foreach ($user_ids as $user_id) {
            // Kiểm tra user đã tồn tại trong nhóm chưa
            $existingMember = GroupMember::where('group_id', $group_id)
                ->where('user_id', $user_id)
                ->first();

            if (!$existingMember) {
                $member = GroupMember::create([
                    'group_id' => $group_id,
                    'user_id' => $user_id,
                    'member_role' => $member_role,
                ]);
                $addedMembers[] = $member;
            }
        }

        return $addedMembers;
    }

    /**
     * Xóa thành viên khỏi nhóm
     */
    public function removeMemberFromGroup($group_id, $user_id): bool
    {
        return (bool) GroupMember::where('group_id', $group_id)
            ->where('user_id', $user_id)
            ->delete();
    }
}