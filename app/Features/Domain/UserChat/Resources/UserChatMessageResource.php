<?php

namespace App\Features\Domain\UserChat\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserChatMessageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sender' => [
                'user_id' => $this->sender?->user_id,
                'full_name' => $this->sender?->full_name,
                'avatar_url' => $this->sender?->avatar_url,
            ],
            'receiver' => [
                'user_id' => $this->receiver?->user_id,
                'full_name' => $this->receiver?->full_name,
                'avatar_url' => $this->receiver?->avatar_url,
            ],
            'content' => $this->content,
            'is_read' => $this->is_read,
            'created_at' => $this->created_at->toIso8601String(),
            'medias' => MessageMediaResource::collection($this->medias),
        ];
    }
}
