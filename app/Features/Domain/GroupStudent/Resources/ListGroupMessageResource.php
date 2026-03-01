<?php

namespace App\Features\Domain\GroupStudent\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListGroupMessageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'message_id' => $this->message_id,
            'content' => $this->message_content,
            'reply_to' => $this->reply_to_message_id,
            'is_pinned' => $this->is_pinned,
            'created_at' => $this->created_at,

            'user' => [
                'user_id' => $this->user?->user_id,
                'full_name' => $this->user?->full_name,
                'avatar_url' => $this->user?->avatar_url,
            ],
            'medias' => GroupMessageMediaResource::collection(
                $this->medias//$this->whenLoaded('medias')
            ),
        ];
    }
}