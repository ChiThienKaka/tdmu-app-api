<?php
namespace App\Features\Domain\GroupStudent\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Features\Domain\GroupStudent\Resources\GroupMessageMediaResource;
class GroupMessageResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'message_id' => $this->message_id,
            'group_id'  => $this->group_id,
            'user_id'   => $this->user_id,
            'content'   => $this->message_content,
            'created_at'=> $this->created_at?->toIso8601String(),

            'medias' => GroupMessageMediaResource::collection(
                $this->whenLoaded('medias')
            ),
        ];
    }
}
