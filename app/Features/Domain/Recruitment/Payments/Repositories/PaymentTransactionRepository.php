<?php

namespace App\Features\Domain\Recruitment\Payments\Repositories;

use App\Features\Domain\Recruitment\Payments\Models\PaymentTransactionModel;

class PaymentTransactionRepository
{
    public function getBySubscription(int $subscriptionId)
    {
        return PaymentTransactionModel::where('subscription_id', $subscriptionId)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
