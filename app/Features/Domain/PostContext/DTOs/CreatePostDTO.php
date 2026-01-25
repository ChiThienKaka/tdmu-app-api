<?php

namespace App\Features\Domain\PostContext\DTOs;

class CreatePostDTO
{
    public function __construct(
        public readonly string $content,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            content: $data['content'],
        );
    }

    public function toArray(): array
    {
        return [
            'content' => $this->content,
        ];
    }
}
