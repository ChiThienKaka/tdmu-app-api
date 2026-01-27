<?php
namespace App\Features\Domain\CommentPost\Services;
use App\Features\Domain\CommentPost\Repositories\CommentPostRepository;

class StoreCommentService {
    public function __construct(private CommentPostRepository $commentRepostiory)
    {
    }
    public function getParents(int $post_id, int $perPage)
    {
        $comment = $this->commentRepostiory->getParent($post_id, $perPage);
        return $comment;
    }
    public function getReplyParent(int $comment_id)
    {
        $comment = $this->commentRepostiory->getReplyComment($comment_id);
        return $comment;
    }
}