<?php
namespace App\Features\Domain\CommentPost\DTOs;

class CreateCommentDTO
{
    public int $post_id;
    public string $content;
    public ?int $parent_comment_id;

    public function __construct(int $post_id, string $content, ?int $parent_comment_id = null)
    {
        $this->post_id = $post_id;
        $this->content = $content;
        $this->parent_comment_id = $parent_comment_id;
    }
    public static function fromArray(array $data): self
    {
        return new self(
            post_id: $data['post_id'],
            content: $data['content'],
            parent_comment_id: $data['parent_comment_id'] ?? null,
        );
    }
}   