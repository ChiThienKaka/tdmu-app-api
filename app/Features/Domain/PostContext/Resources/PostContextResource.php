<?php
namespace App\Features\Domain\PostContext\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostContextResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'post_id' => $this->post_id,
            'content' => $this->content,
            'major_id'=> $this->major_id,
            'faculty_id'=> $this->faculty_id,
            'user_id' => $this->user_id,
            // 'created_at' => $this->created_at?->toDateTimeString(),
            'media' => MediaPostResource::collection($this->media)//whenLoaded('media') mặc định phải có key media
        ];
    }
}