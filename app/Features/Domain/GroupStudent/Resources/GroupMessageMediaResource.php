<?php
namespace App\Features\Domain\GroupStudent\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupMessageMediaResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'url'  => $this->media_url,
            'type' => $this->media_type,
            'name' => $this->file_name,
            'size' => $this->file_size,
        ];
    }
}
