<?php

namespace App\Features\Domain\Admin\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminPaymentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'payment_id'             => $this->payment_id,
            'payment_status'         => $this->payment_status,
            'payment_method'         => $this->payment_method,
            'payment_amount'         => $this->payment_amount,
            'payment_transaction_id' => $this->payment_transaction_id,
            'paid_at'                => $this->paid_at,
            'created_at'             => $this->created_at,
            'subscription'           => [
                'subscription_id' => $this->subscription?->subscription_id,
                'package_name'    => $this->subscription?->package?->package_name,
                'user_name'       => $this->subscription?->user?->full_name,
            ],
        ];
    }
}
