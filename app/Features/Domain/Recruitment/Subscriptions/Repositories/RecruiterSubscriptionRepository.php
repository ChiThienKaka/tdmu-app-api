<?php

namespace App\Features\Domain\Recruitment\Subscriptions\Repositories;

use App\Features\Domain\Recruitment\Subscriptions\Models\RecruiterSubscriptionModel;
use Illuminate\Support\Carbon;

class RecruiterSubscriptionRepository
{
    public function getActiveByUser(int $userId)
    {
        $today = now()->toDateString();
        return RecruiterSubscriptionModel::where('user_id', $userId)
            ->where('status', 'active')
            ->whereDate('end_date', '>=', $today)
            ->orderBy('start_date', 'desc')
            ->get();
    }
    public function create(array $data): RecruiterSubscriptionModel
    {
        return RecruiterSubscriptionModel::create($data);
    }
}
