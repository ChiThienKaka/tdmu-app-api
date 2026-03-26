<?php

namespace App\Features\Domain\RecruiterDashboard\Services;

use App\Features\Domain\JobPostings\Models\JobPostModel;
use App\Features\Domain\Recruitment\Subscriptions\Models\RecruiterSubscriptionModel;
use Illuminate\Support\Str;
use App\Features\Domain\Recruitment\Companies\Models\RecruiterCompanyModel;

class RecruiterJobPostService
{
    /**
     * Danh sách bài đăng của nhà tuyển dụng hiện tại
     */
    public function listByRecruiter(int $userId, array $filters = [], int $perPage = 15)
    {
        $query = JobPostModel::where('user_id', $userId)
            ->orderByDesc('created_at');

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['keyword'])) {
            $query->where('job_title', 'like', '%' . $filters['keyword'] . '%');
        }

        return $query->paginate($perPage);
    }

    /**
     * Chi tiết bài đăng – phải thuộc về nhà tuyển dụng
     */
    public function getDetail(int $userId, int $jobId)
    {
        return JobPostModel::where('user_id', $userId)
            ->with(['category', 'applications'])
            ->find($jobId);
    }

    /**
     * Tạo bài đăng mới
     */
    public function create(int $userId, array $data): JobPostModel
    {
        //Cái này dính bug khá nhiều chưa mới chỉ chặn active chưa chặn quyền đăng tối đa
        // check subscription
        $subscription = RecruiterSubscriptionModel::where('user_id', $userId)
            ->where('status', 'active')
            ->whereDate('end_date', '>=', now())
            ->first();

        if (!$subscription) {
            throw new \RuntimeException('Bạn không có gói đăng tin đang hoạt động.');
        }

        // ✅ lấy company
        $company = RecruiterCompanyModel::where('user_id', $userId)->first();

        if (!$company) {
            throw new \RuntimeException('Bạn chưa tạo công ty.');
        }

        $data['user_id'] = $userId;
        $data['company_id'] = $company->company_id; // ✅ FIX CHÍNH
        $data['subscription_id'] = $subscription->subscription_id;

        $data['status'] = 'pending';
        $data['slug'] = $data['slug'] ?? Str::slug($data['job_title']) . '-' . time();
        // dd($data);
        return JobPostModel::create($data);
    }

    /**
     * Cập nhật bài đăng (chỉ khi draft/pending/rejected)
     */
    public function update(int $userId, int $jobId, array $data): ?JobPostModel
    {
        $job = JobPostModel::where('user_id', $userId)->find($jobId);
        if (!$job) {
            return null;
        }

        // Không cho phép cập nhật khi bài đã được duyệt
        if ($job->status === 'approved') {
            return null;
        }

        $job->update($data);
        return $job->fresh();
    }

    /**
     * Xóa bài đăng
     */
    public function delete(int $userId, int $jobId): bool
    {
        $job = JobPostModel::where('user_id', $userId)->find($jobId);
        if (!$job) {
            return false;
        }
        $job->delete();
        return true;
    }

    /**
     * Làm mới (refresh) bài đăng – cập nhật last_refreshed_at
     */
    public function refresh(int $userId, int $jobId): ?JobPostModel
    {
        $job = JobPostModel::where('user_id', $userId)
            ->where('status', 'approved')
            ->find($jobId);

        if (!$job) {
            return null;
        }

        $job->update(['last_refreshed_at' => now()]);
        return $job->fresh();
    }
}
