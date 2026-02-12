<?php

namespace App\Features\Domain\CommentPost\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentParentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'comment_id' => $this->comment_id,
            'content' => $this->content,
            'parent_comment_id' => $this->parent_comment_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            // không có sẽ không xuất hiện
            'replies_count' => $this->when(
                isset($this->replies_count),
                $this->replies_count
            ),
            'user' => $this->whenLoaded('user', function () {
                return [
                    'user_id' => $this->user->user_id,
                    'full_name' => $this->user->full_name,
                    'avatar_url' => $this->user->avatar_url,
                    'email'=> $this->user->email,
                ];
            }),
            'replies' => CommentParentResource::collection(
                $this->whenLoaded('replies')
            ),
        ];
    }
}
