<?php

namespace App\Features\Domain\RecruiterDashboard\Controllers;

use App\Features\Domain\RecruiterDashboard\Services\RecruiterDashboardService;

class RecruiterDashboardController
{
    public function __construct(
        protected RecruiterDashboardService $dashboardService
    ) {}

    /**
     * GET /api/recruiter/dashboard/overview
     * Thống kê tổng quan của nhà tuyển dụng
     */
    public function overview()
    {
        $user = auth('api')->user();

        $data = $this->dashboardService->getOverview($user->user_id);

        return response()->json(['data' => $data], 200);
    }
}
