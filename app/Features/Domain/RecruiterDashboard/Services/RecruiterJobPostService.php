<?php

namespace App\Features\Domain\RecruiterDashboard\Services;

use App\Features\Domain\JobPostings\Models\JobPostModel;
use Illuminate\Support\Str;

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
        $data['user_id'] = $userId;
        $data['status'] = 'pending'; // chờ admin duyệt
        $data['slug'] = $data['slug'] ?? Str::slug($data['job_title']) . '-' . time();

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
