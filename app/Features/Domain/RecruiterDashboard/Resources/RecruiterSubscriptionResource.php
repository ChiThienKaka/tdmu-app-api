<?php

namespace App\Features\Domain\RecruiterDashboard\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RecruiterSubscriptionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'subscription_id' => $this->subscription_id,
            'status'          => $this->status,
            'start_date'      => $this->start_date,
            'end_date'        => $this->end_date,
            'created_at'      => $this->created_at,
            'updated_at'      => $this->updated_at,
            'package'         => $this->whenLoaded('package', fn() => [
                'package_id'           => $this->package->package_id ?? null,
                'package_name'         => $this->package->package_name ?? null,
                'price'                => $this->package->price ?? null,
                'duration_days'        => $this->package->duration_days ?? null,
                'post_limit'           => $this->package->post_limit ?? null,
                'featured_posts_limit' => $this->package->featured_posts_limit ?? null,
                'refresh_limit'        => $this->package->refresh_limit ?? null,
                'support_priority'     => $this->package->support_priority ?? null,
                'features'             => $this->package->features ?? null,
            ]),
        ];
    }
}
