<?php

namespace App\Features\Domain\Admin\Services;

use App\Models\User;
use App\Features\Domain\Recruitment\Companies\Models\RecruiterCompanyModel;
use App\Features\Domain\JobPostings\Models\JobPostModel;
use App\Features\Domain\JobApplication\Models\JobApplicationModel;
use App\Features\Domain\Recruitment\Payments\Models\RecruiterPaymentModel;
use Illuminate\Support\Facades\DB;

class AdminDashboardService
{
    public function __construct() {}

    // Thống kê tổng quan
    public function getOverview()
    {
        return [
            'total_users'        => User::count('*'),
            'total_companies'    => RecruiterCompanyModel::count('*'),
            'total_job_posts'    => JobPostModel::count('*'),
            'total_applications' => JobApplicationModel::count('*'),
            'pending_companies'  => RecruiterCompanyModel::where('verification_status', 'pending')->count('*'),
            'pending_job_posts'  => JobPostModel::where('status', 'pending')->count('*'),
        ];
    }


    // Thống kê doanh thu (giả sử theo paid_at)
    public function getRevenue(string $period = 'month')
    {
        $query = RecruiterPaymentModel::where('payment_status', 'completed');

        if ($period === 'month') {
            return $query->select(
                DB::raw('SUM(payment_amount) as total_revenue'),
                DB::raw("TO_CHAR(paid_at, 'YYYY-MM') as label")
            )
            ->groupBy('label')
            ->orderBy('label')
            ->get();
        }

        return $query->sum('payment_amount');
    }

    // Xu hướng bài đăng
    public function getJobPostTrend()
    {
        return JobPostModel::select(
            DB::raw('COUNT(*) as total'),
            DB::raw("TO_CHAR(created_at, 'YYYY-MM-DD') as date")
        )->where('created_at', '>=', now()->subDays(30))
         ->groupBy('date')
         ->orderBy('date')
         ->get();
    }

}
