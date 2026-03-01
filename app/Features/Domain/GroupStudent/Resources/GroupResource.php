<?php

namespace App\Features\Domain\GroupStudent\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'group_id' => $this->group_id,
            'group_name' => $this->group_name,
            'group_type' => $this->group_type,
            'description' => $this->description,
            'avatar_url' => $this->avatar_url,
            'cover_image' => $this->cover_image,
            'privacy' => $this->privacy,
            'is_auto_join' => $this->is_auto_join,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at->toIso8601String(),
        ];
    }
}
