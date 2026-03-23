<?php

namespace App\Features\Domain\Admin\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminPackageResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'package_id'           => $this->package_id,
            'package_name'         => $this->package_name,
            'price'                => $this->price,
            'duration_days'        => $this->duration_days,
            'post_limit'           => $this->post_limit,
            'featured_posts_limit' => $this->featured_posts_limit,
            'refresh_limit'        => $this->refresh_limit,
            'support_priority'     => $this->support_priority,
            'features'             => $this->features,
            'is_active'            => $this->is_active,
            'display_order'        => $this->display_order,
            'created_at'           => $this->created_at,
            'updated_at'           => $this->updated_at,
        ];
    }
}
