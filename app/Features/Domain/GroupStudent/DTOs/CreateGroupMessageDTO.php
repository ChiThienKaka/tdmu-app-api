<?php

namespace App\Features\Domain\GroupStudent\DTOs;

class CreateGroupMessageDTO
{
    public function __construct(
        public readonly int $groupId,
        public readonly string $content,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            groupId: $data['group_id'],
            content: $data['content'],
        );
    }

    public function toArray(): array
    {
        return [
            'group_id' => $this->groupId,
            'content' => $this->content,
        ];
    }
}
