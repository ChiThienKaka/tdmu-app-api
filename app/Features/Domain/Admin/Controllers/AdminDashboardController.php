<?php

namespace App\Features\Domain\Admin\Controllers;

use App\Features\Domain\Admin\Services\AdminDashboardService;
use Illuminate\Http\Request;

class AdminDashboardController
{
    public function __construct(protected AdminDashboardService $dashboardService) {}

    // Overview stats
    public function overview()
    {
        return response()->json([
            'data' => $this->dashboardService->getOverview(),
        ], 200);
    }

    // Revenue stats
    public function revenue(Request $request)
    {
        $period = $request->query('period', 'month');
        return response()->json([
            'data' => $this->dashboardService->getRevenue($period),
        ], 200);
    }

    // Job post trend
    public function trend()
    {
        return response()->json([
            'data' => $this->dashboardService->getJobPostTrend(),
        ], 200);
    }
}
