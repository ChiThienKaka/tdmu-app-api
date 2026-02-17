<?php

namespace App\Features\Domain\JobPostings\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobCategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'category_id' => $this->category_id,
            'category_name' => $this->category_name,
            'category_slug' => $this->category_slug,
            'icon' => $this->icon,
            'display_order' => $this->display_order
            // 'active' => $this->is_active,
        ];
    }
}
