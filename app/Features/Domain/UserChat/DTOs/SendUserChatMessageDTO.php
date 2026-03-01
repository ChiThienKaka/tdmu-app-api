<?php

namespace App\Features\Domain\UserChat\DTOs;

class SendUserChatMessageDTO
{
    public function __construct(
        public readonly int $receiver_id,
        public readonly ?string $content = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            receiver_id: $data['receiver_id'],
            content: $data['content'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'receiver_id' => $this->receiver_id,
            'content' => $this->content,
        ];
    }
}
