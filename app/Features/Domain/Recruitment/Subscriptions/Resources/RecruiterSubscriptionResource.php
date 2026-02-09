<?php

namespace App\Features\Domain\Recruitment\Subscriptions\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RecruiterSubscriptionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'subscription_id' => $this->subscription_id,
            'user_id' => $this->user_id,
            'package_id' => $this->package_id,
            'start_date' => $this->start_date?->toDateString(),
            'end_date' => $this->end_date?->toDateString(),
            'status' => $this->status,
        ];
    }
}
