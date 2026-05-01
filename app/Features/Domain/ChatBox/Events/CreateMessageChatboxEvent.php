<?php

namespace App\Features\Domain\ChatBox\Events;

use App\Features\Domain\ChatBox\Models\MessageChatboxModel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class CreateMessageChatboxEvent implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels;

    public MessageChatboxModel $message;

    public function __construct(MessageChatboxModel $message)
    {
        $this->message = $message;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('user.' . $this->message->user_id . '.chatbox');
    }

    public function broadcastAs(): string
    {
        return 'chatbox.message.created';
    }

    public function broadcastWith(): array
    {
        return [
            'id'         => $this->message->id,
            'role'       => $this->message->role,
            'content'    => $this->message->content,
            'created_at' => $this->message->created_at?->toDateTimeString(),
        ];
    }
}
