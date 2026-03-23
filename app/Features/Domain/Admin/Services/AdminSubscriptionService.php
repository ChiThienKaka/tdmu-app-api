<?php

namespace App\Features\Domain\Admin\Services;

use App\Features\Domain\Recruitment\Subscriptions\Models\RecruiterSubscriptionModel;

class AdminSubscriptionService
{
    public function __construct() {}

    // Lấy danh sách subscription (filter theo status)
    public function listSubscriptions(string $status = null, int $perPage = 20)
    {
        $query = RecruiterSubscriptionModel::with(['package', 'company', 'user'])
            ->orderByDesc('created_at');

        if ($status) {
            $query->where('status', $status);
        }

        return $query->paginate($perPage);
    }

    // Chi tiết một subscription
    public function getDetail(int $subscription_id)
    {
        return RecruiterSubscriptionModel::with(['package', 'company', 'user'])
            ->find($subscription_id);
    }

    // Kích hoạt subscription (sau khi xác nhận thanh toán)
    public function activateSubscription(int $subscription_id)
    {
        $sub = RecruiterSubscriptionModel::find($subscription_id);
        if (! $sub) {
            return null;
        }
        $sub->status     = 'active';
        $sub->start_date = now()->toDateString();
        $sub->end_date   = now()->addDays($sub->package?->duration_days ?? 30)->toDateString();
        $sub->save();
        return $sub->load(['package', 'company', 'user']);
    }
}
