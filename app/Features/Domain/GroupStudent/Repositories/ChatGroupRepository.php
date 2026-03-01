<?php
namespace App\Features\Domain\GroupStudent\Repositories;
use App\Models\GroupMessage;
use App\Models\User;
use App\Models\GroupMember;
use Illuminate\Validation\ValidationException;
class ChatGroupRepository
{
    // Code for ChatGroupRepository
    public function __construct()
    {
        // Constructor code here
    }
    // Get list message GroupMessage
    public function GetListGroupMessage(User $user, int $group_id, int $perPage = 20){
        if (!$user->groupMembers()->where('group_id', $group_id)->exists()) {
            throw ValidationException::withMessages([
                'support' => 'user không tồn tại trong group này!'
            ]); 
        }
        $message = GroupMessage::with(['medias','user'])
        ->where('group_id', $group_id)
        ->orderBy('created_at', 'desc') // chat thường lấy mới nhất trước
        ->paginate($perPage);;
        return $message;

    }  
    public function createGroupMessage(User $user, int $group_id, string $message_content): GroupMessage
    {
        $isMember = GroupMember::where('user_id', $user->user_id)
                ->where('group_id', $group_id)
                ->exists();
        if (!$isMember) {
            throw new \Exception('User is not a member of the group.');
        }
        $message =  GroupMessage::create([
            'group_id' => $group_id,
            'user_id' => $user->user_id,
            'message_content' => $message_content,
        ]);
        return $message;
    }
}