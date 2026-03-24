<?php

namespace App\Features\Domain\RecruiterDashboard\Services;

use App\Features\Domain\JobPostings\Models\JobPostModel;
use App\Features\Domain\JobApplication\Models\JobApplicationModel;

class RecruiterDashboardService
{
    /**
     * Thống kê tổng quan của nhà tuyển dụng
     */
    public function getOverview(int $userId): array
    {
        $totalPosts = JobPostModel::where('user_id', $userId)->count();

        $postsByStatus = JobPostModel::where('user_id', $userId)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $totalApplications = JobApplicationModel::whereHas('jobpost', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->count();

        $pendingApplications = JobApplicationModel::whereHas('jobpost', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->where('status', 'pending')->count();

        $expiringPosts = JobPostModel::where('user_id', $userId)
            ->where('status', 'approved')
            ->whereBetween('application_deadline', [now(), now()->addDays(7)])
            ->count();

        return [
            'total_job_posts'       => $totalPosts,
            'posts_by_status'       => $postsByStatus,
            'total_applications'    => $totalApplications,
            'pending_applications'  => $pendingApplications,
            'expiring_soon_posts'   => $expiringPosts,
        ];
    }
}
