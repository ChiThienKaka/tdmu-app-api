<?php

namespace App\Features\Domain\Recruitment\Packages\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RecruiterPackageResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'package_id' => $this->package_id,
            'package_name' => $this->package_name,
            'price' => (float) $this->price,
            'duration_days' => $this->duration_days,
            'post_limit' => $this->post_limit,
            'featured_posts_limit' => $this->featured_posts_limit,
            'refresh_limit' => $this->refresh_limit,
            'support_priority' => $this->support_priority,
            'features' => $this->features,
            'is_active' => (bool) $this->is_active,
            'display_order' => $this->display_order,
        ];
    }
}
