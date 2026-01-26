<?php
namespace App\Features\Infrastructure\Persistence\Comment;
use App\Models\Comment;

class CommentRepository
{
    // Repository methods will be implemented here
    
    public function __construct(private Comment $comment)
    {
    }

    public function findById(int $id): ?Comment
    {
        return $this->comment->find($id);
    }
    public function create(array $data): Comment
    {
        return $this->comment->create($data);
    }
    public function update(Comment $comment, array $data): Comment
    {
        $comment->update($data);
        return $comment;
    }
    public function delete(Comment $comment): void
    {
        $comment->delete();
    }
}