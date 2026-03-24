<?php

namespace App\Features\Domain\RecruiterDashboard\Controllers;

use App\Features\Domain\RecruiterDashboard\Services\RecruiterSubscriptionService;
use App\Features\Domain\RecruiterDashboard\Resources\RecruiterSubscriptionResource;

class RecruiterSubscriptionController
{
    public function __construct(
        protected RecruiterSubscriptionService $subscriptionService
    ) {}

    /**
     * GET /api/recruiter/subscription
     * Subscription đang active
     */
    public function current()
    {
        $user = auth('api')->user();

        $subscription = $this->subscriptionService->getCurrent($user->user_id);

        if (!$subscription) {
            return response()->json([
                'message' => 'Bạn hiện không có gói đăng ký nào đang hoạt động.',
                'data'    => null,
            ], 200);
        }

        return response()->json(['data' => new RecruiterSubscriptionResource($subscription)], 200);
    }

    /**
     * GET /api/recruiter/subscription/history
     * Lịch sử tất cả subscription
     */
    public function history()
    {
        $user = auth('api')->user();

        $result = $this->subscriptionService->getHistory($user->user_id);

        return response()->json([
            'data'         => RecruiterSubscriptionResource::collection($result),
            'current_page' => $result->currentPage(),
            'total_pages'  => $result->lastPage(),
            'total'        => $result->total(),
        ], 200);
    }
}
