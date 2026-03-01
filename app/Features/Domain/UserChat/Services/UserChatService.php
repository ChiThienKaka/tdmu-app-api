<?php

namespace App\Features\Domain\UserChat\Services;

use App\Features\Domain\UserChat\Repositories\UserChatRepository;
use App\Models\User;

class UserChatService
{
    public function __construct(private UserChatRepository $userChatRepository)
    {
    }

    /**
     * Gửi tin nhắn 1-on-1
     */
    public function sendMessage(User $sender, int $receiver_id, string $content)
    {
        // Kiểm tra receiver tồn tại
        $receiver = User::where('user_id', $receiver_id)->first();
        if (!$receiver) {
            throw new \Exception('User receiver not found');
        }

        return $this->userChatRepository->sendMessage($sender, $receiver_id, $content);
    }

    /**
     * Lấy danh sách tin nhắn giữa 2 user
     */
    public function getConversation(int $user_id, int $other_user_id, $per_page = 20)
    {
        return $this->userChatRepository->getConversation($user_id, $other_user_id, $per_page);
    }

    /**
     * Lấy danh sách cuộc hội thoại gần đây
     */
    public function getRecentConversations(int $user_id, $limit = 20)
    {
        return $this->userChatRepository->getRecentConversations($user_id, $limit);
    }

    /**
     * Đánh dấu tin nhắn đã đọc
     */
    public function markAsRead(int $sender_id, int $receiver_id)
    {
        return $this->userChatRepository->markAsRead($sender_id, $receiver_id);
    }

    /**
     * Xóa tin nhắn
     */
    public function deleteMessage(int $message_id, int $user_id)
    {
        return $this->userChatRepository->deleteMessage($message_id, $user_id);
    }
}
