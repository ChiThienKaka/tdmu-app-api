<?php

namespace App\Features\Domain\RecruiterDashboard\Services;

use App\Features\Domain\Recruitment\Subscriptions\Models\RecruiterSubscriptionModel;

class RecruiterSubscriptionService
{
    /**
     * Subscription đang active của nhà tuyển dụng
     */
    public function getCurrent(int $userId): ?RecruiterSubscriptionModel
    {
        return RecruiterSubscriptionModel::where('user_id', $userId)
            ->where('status', 'active')
            ->with('package')
            ->orderByDesc('start_date')
            ->first();
    }

    /**
     * Lịch sử tất cả subscription
     */
    public function getHistory(int $userId, int $perPage = 10)
    {
        return RecruiterSubscriptionModel::where('user_id', $userId)
            ->with('package')
            ->orderByDesc('start_date')
            ->paginate($perPage);
    }
}
