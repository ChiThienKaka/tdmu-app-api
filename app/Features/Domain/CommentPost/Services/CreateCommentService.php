<?php
namespace App\Features\Domain\CommentPost\Services;
use App\Features\Infrastructure\Persistence\Comment\CommentRepository;
use App\Features\Domain\CommentPost\Events\CreateCommentEvent;
use App\Models\Comment;

class CreateCommentService
{
    private CommentRepository $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }
    public function create(array $data): Comment
    {
        $comment = $this->commentRepository->create($data);
        // Fire the event to broadcast the new comment
        broadcast(new CreateCommentEvent($comment))->toOthers();
        return $comment;
    }
}