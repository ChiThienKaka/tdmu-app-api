<?php

namespace App\Features\Domain\ChatBox\Repositories;

use App\Features\Domain\ChatBox\Models\MessageChatboxModel;
use App\Models\User;
use Illuminate\Support\Collection;

class MessageChatboxRepository
{
    /**
     * Lưu message mới
     */
    public function create(User $user, string $role, string $content): MessageChatboxModel
    {
        return $user->messageChatboxs()->create([
            'role'    => $role,
            'content' => $content,
        ]);
    }

    /**
     * Lấy N message gần nhất của user (dùng relation)
     */
    public function getRecentMessages(User $user, int $limit = 5): Collection
    {
        return $user->messageChatboxs()
            ->latest()
            ->take($limit)
            ->get()
            ->reverse()
            ->values();
    }
    /**
     * Format message về dạng OpenAI / Gemini chat format
     */
    public function formatForAI(Collection $messages): array
    {
        return $messages->map(function ($message) {
            return [
                'role'    => $message->role,
                'content' => $message->content,
            ];
        })->toArray();
    }

    /**
     * Xóa message cũ nếu vượt quá giới hạn
     */
    public function trimOldMessages(User $user, int $keep = 50): void
    {
        $idsToDelete = $user->messageChatboxs()
            ->latest()
            ->skip($keep)
            ->pluck('id');

        if ($idsToDelete->isNotEmpty()) {
            MessageChatboxModel::whereIn('id', $idsToDelete)->delete();
        }
    }
}