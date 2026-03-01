<?php

namespace App\Features\Domain\UserChat\Repositories;

use App\Features\Domain\UserChat\Models\UserChatMessage;
use App\Models\User;

class UserChatRepository
{
    /**
     * Gửi tin nhắn 1-on-1
     */
    public function sendMessage(User $sender, int $receiver_id, string $content): UserChatMessage
    {
        return UserChatMessage::create([
            'sender_id' => $sender->user_id,
            'receiver_id' => $receiver_id,
            'content' => $content,
            'is_read' => false,
        ]);
    }

    /**
     * Lấy danh sách tin nhắn giữa 2 user (phân trang)
     */
    public function getConversation(int $user_id, int $other_user_id, $per_page = 20)
    {
        return UserChatMessage::where(function ($query) use ($user_id, $other_user_id) {
            $query->where('sender_id', $user_id)
                ->where('receiver_id', $other_user_id);
        })->orWhere(function ($query) use ($user_id, $other_user_id) {
            $query->where('sender_id', $other_user_id)
                ->where('receiver_id', $user_id);
        })
        ->with(['sender', 'receiver'])
        ->orderBy('created_at', 'desc')
        ->paginate($per_page);
    }

    /**
     * Lấy danh sách cuộc hội thoại gần đây của user
     */
    public function getRecentConversations(int $user_id, $limit = 20)
    {
        $messages = UserChatMessage::where(function ($query) use ($user_id) {
                $query->where('sender_id', $user_id)
                    ->orWhere('receiver_id', $user_id);
            })
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->get();

        return $messages
            ->groupBy(function ($message) use ($user_id) {
                return $message->sender_id == $user_id
                    ? $message->receiver_id
                    : $message->sender_id;
            })
            ->map(function ($group) {
                return $group->first(); // 👈 lấy message mới nhất
            })
            ->values()
            ->take($limit);
    }

    /**
     * Đánh dấu tin nhắn đã đọc
     */
    public function markAsRead(int $sender_id, int $receiver_id): int
    {
        return UserChatMessage::where('sender_id', $sender_id)
            ->where('receiver_id', $receiver_id)
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }

    /**
     * Xóa tin nhắn
     */
    public function deleteMessage(int $message_id, int $user_id): bool
    {
        $message = UserChatMessage::find($message_id);
        
        if (!$message) {
            return false;
        }

        // Chỉ cho phép người gửi hoặc người nhận xóa
        if ($message->sender_id !== $user_id && $message->receiver_id !== $user_id) {
            return false;
        }

        return (bool) $message->delete();
    }
}
