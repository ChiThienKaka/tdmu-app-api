<?php
namespace App\Features\Domain\CommentPost\Events;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\Channel;
use App\Models\Comment;


class CreateCommentEvent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;
    public Comment $comment;
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }
    // Define the channel the event should broadcast on
    public function broadcastOn(): Channel
    {
        //post.5.comments tên kênh
        return new Channel('post.' . $this->comment->post_id . '.comments');
    }
    // Define the name of the event when broadcasted
    public function broadcastAs(): string
    {
        // tên cho socket event
        return 'comment.created';
    }
    // Define the data to broadcast with the event
    public function broadcastWith(): array
    {
        return [
            'id'        => $this->comment->id,
            'content'   => $this->comment->content,
            'user'      => [
                'id'   => $this->comment->user->id,
                'name' => $this->comment->user->name,
            ],
            'created_at' => $this->comment->created_at->toDateTimeString(),
        ];
    }

}