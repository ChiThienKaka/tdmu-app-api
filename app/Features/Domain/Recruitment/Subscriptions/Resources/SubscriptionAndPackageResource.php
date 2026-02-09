<?php

namespace App\Features\Domain\Recruitment\Subscriptions\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionAndPackageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'subscription_id' => $this->subscription_id,
            'status' => $this->status,
            'start_date' => $this->start_date?->toDateString(),
            'end_date' => $this->end_date?->toDateString(),

            'package' => [
                'id' => $this->package->package_id,
                'name' => $this->package->package_name,
                'price' => (float) $this->package->price,
                'duration_days' => $this->package->duration_days,
                'post_limit' => $this->package->post_limit,
                'featured_posts_limit' => $this->package->featured_posts_limit,
                'support_priority' => $this->package->support_priority,

                // 'features' => [
                //     'logo_highlight' => $this->package->features['logo_highlight'] ?? false,
                //     'top_search' => $this->package->features['top_search'] ?? false,
                //     'analytics' => $this->package->features['analytics'] ?? 'none',
                // ],
            ],
        ];
    }
}
