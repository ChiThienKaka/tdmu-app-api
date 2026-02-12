<?php
namespace App\Features\Domain\CommentPost\Repositories;
use App\Models\Comment;

class CommentPostRepository
{
    public function __construct(private Comment $comment)
    {
    }
    //get comment parent
    public function getParent(int $postId, int $perPage = 10)
    {
        $comments = $this->comment->where('post_id', $postId) 
        ->whereNull('parent_comment_id') 
        ->with(['user','replies.user']) 
        ->withCount('replies')
        ->orderBy('created_at', 'desc') 
        ->paginate($perPage);
        return $comments;
    }
    //get reply comment parent
    public function getReplyComment(int $comment_id, int $perPage = 5)
    {
        $replies = $this->comment->where('parent_comment_id', $comment_id)
        ->with('user')
        ->orderBy('created_at', 'asc')
        ->paginate($perPage);
        return $replies;
    }
}