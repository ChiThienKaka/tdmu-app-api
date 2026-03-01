<?php

namespace App\Features\Domain\UserChat\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageMediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'message_id' => $this->message_id,
            'url'        => $this->media_url,
            'type'       => $this->media_type,
            'name'       => $this->file_name,
            'size'       => $this->file_size,
            'created_at' => $this->created_at,
        ];
    }
}