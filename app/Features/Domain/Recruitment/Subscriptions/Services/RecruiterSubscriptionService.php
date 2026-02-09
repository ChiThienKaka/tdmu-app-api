<?php
namespace App\Features\Domain\Recruitment\Subscriptions\Services;
use App\Features\Domain\Recruitment\Subscriptions\Models\RecruiterSubscriptionModel;


class RecruiterSubscriptionService {
    public function getPendingPackages(int $userId)
    {
        $subscription = RecruiterSubscriptionModel::where('user_id', $userId)
            ->where('status', 'pending')
            ->orderByDesc('subscription_id')
            ->first();
        if ($subscription) {
            $subscription->load('package');
        }
        return $subscription;
    }
}