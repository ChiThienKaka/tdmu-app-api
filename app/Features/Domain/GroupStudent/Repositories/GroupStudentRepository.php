<?php
namespace App\Features\Domain\GroupStudent\Repositories;

use App\Models\User;
use App\Models\GroupMember;
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
}