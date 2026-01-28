<?php

namespace App\Features\Domain\PostContext\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StorePostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->post_id,
            'content'    => $this->content,
            'type'       => $this->post_type,
            'visibility' => $this->visibility,
            'status'     => $this->status,
            'views'      => $this->view_count,
            'created_at' => $this->created_at?->toIso8601String(),

            'author' => $this->whenLoaded('user', fn () => [
                'id'     => $this->user->user_id,
                'email'  => $this->user->email,
                'name'   => $this->user->full_name,
                'avatar' => $this->user->avatar_url,
            ]),

            'media' => MediaPostResource::collection(
                $this->media
            ),
        ];
    }
}
