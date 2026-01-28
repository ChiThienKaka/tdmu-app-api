<?php

namespace App\Features\Domain\PostContext\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaPostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'media_id' => $this->media_id,
            'media_type' => $this->media_type,
            'media_url' => $this->url, // bạn đã custom sẵn rồi 👍
            'media_order' => $this->media_order,
        ];
    }
}
