<?php

namespace App\Features\Domain\Admin\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminSubscriptionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'subscription_id' => $this->subscription_id,
            'status'          => $this->status,
            'start_date'      => $this->start_date,
            'end_date'        => $this->end_date,
            'created_at'      => $this->created_at,
            'package'         => $this->whenLoaded('package', fn() => [
                'package_id'   => $this->package?->package_id,
                'package_name' => $this->package?->package_name,
                'price'        => $this->package?->price,
                'duration_days'=> $this->package?->duration_days,
            ]),
            'company'         => $this->whenLoaded('company', fn() => [
                'company_id'   => $this->company?->company_id,
                'company_name' => $this->company?->company_name,
            ]),
            'recruiter'       => $this->whenLoaded('user', fn() => [
                'user_id' => $this->user?->user_id,
                'name'    => $this->user?->full_name,
                'email'   => $this->user?->email,
            ]),
        ];
    }
}
