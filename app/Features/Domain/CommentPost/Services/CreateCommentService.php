<?php
namespace App\Features\Domain\CommentPost\Services;
use App\Features\Infrastructure\Persistence\Comment\CommentRepository;
use App\Features\Domain\CommentPost\Events\CreateCommentEvent;
use App\Features\Domain\CommentPost\DTOs\CreateCommentDTO;
use App\Models\Comment;
use App\Models\User;

class CreateCommentService
{
    private CommentRepository $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }
    public function create(CreateCommentDTO $dto, User $user): Comment
    {
        $comment = $this->commentRepository->create([
            'post_id'=>$dto->post_id,
            'user_id'=>$user->user_id,
            'content'=>$dto->content,
            'parent_comment_id'=>$dto->parent_comment_id,
        ]);
        // Fire the event to broadcast the new comment
        broadcast(new CreateCommentEvent($comment));//->toOthers();
        return $comment;
    }
}