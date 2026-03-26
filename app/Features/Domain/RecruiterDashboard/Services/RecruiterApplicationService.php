<?php

namespace App\Features\Domain\RecruiterDashboard\Services;

use App\Features\Domain\JobApplication\Models\JobApplicationModel;
use App\Features\Domain\JobApplication\Models\ApplicationTimelineModel;
use App\Features\Domain\JobPostings\Models\JobPostModel;

class RecruiterApplicationService
{
    /**
     * Lấy tất cả ứng viên của nhà tuyển dụng (qua các bài đăng)
     */
    public function listByRecruiter(int $userId, array $filters = [], int $perPage = 10)
    {
        $query = JobApplicationModel::whereHas('jobpost', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->with(['jobpost:job_id,job_title', 'applicant:user_id,full_name,email'])
            ->orderByDesc('applied_at');

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['job_id'])) {
            $query->where('job_id', $filters['job_id']);
        }

        return $query->paginate($perPage);
    }

    /**
     * Ứng viên theo bài đăng cụ thể (phải thuộc về NTD)
     */
    public function listByJobPost(int $userId, int $job_id, int $perPage = 15)
    {
        // Xác nhận bài đăng thuộc NTD
        $job = JobPostModel::where('user_id', $userId)->find($job_id);
        if (!$job) {
            return null;
        }

        return JobApplicationModel::where('job_id', $job_id)
            ->with(['applicant:user_id,full_name,email', 'timelines'])
            ->orderByDesc('applied_at')
            ->paginate($perPage);
    }

    /**
     * Chi tiết đơn ứng tuyển
     */
    public function getDetail(int $userId, int $applicationId): ?JobApplicationModel
    {
        return JobApplicationModel::whereHas('jobpost', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->with(['jobpost:job_id,job_title', 'applicant:user_id,full_name,email', 'timelines'])
            ->find($applicationId);
    }

    /**
     * Cập nhật trạng thái ứng viên + ghi timeline
     */
   public function updateStatus(int $userId, int $applicationId, string $newStatus, array $extra = []): ?JobApplicationModel
    {
        $application = $this->getDetail($userId, $applicationId);
        if (!$application) {
            return null;
        }

        // ✅ Lấy trạng thái cũ TRƯỚC khi update
        $oldStatus = $application->status;

        // ✅ Update status mới
        $updateData = array_merge(['status' => $newStatus], $extra);
        $application->update($updateData);

        // ✅ Ghi timeline
        if (class_exists(ApplicationTimelineModel::class)) {
            ApplicationTimelineModel::create([
                'application_id' => $applicationId,
                'old_status'     => $oldStatus,     // chuẩn
                'new_status'     => $newStatus,     // chuẩn
                'note'           => $extra['note'] ?? null,
                'changed_by'     => $userId,
                'changed_at'     => now(),
            ]);
        }

        return $application->fresh(['timelines']);
    }

    /**
     * Lên lịch phỏng vấn
     */
    public function scheduleInterview(int $userId, int $applicationId, string $datetime, string $location): ?JobApplicationModel
    {
        $application = $this->getDetail($userId, $applicationId);
        if (!$application) {
            return null;
        }

        $application->scheduleInterview($datetime, $location);

        // Ghi timeline
        if (class_exists(ApplicationTimelineModel::class)) {
            ApplicationTimelineModel::create([
                'application_id' => $applicationId,
                'status'         => 'interviewed',
                'note'           => "Lịch: {$datetime} – Địa điểm: {$location}",
                'changed_by'     => $userId,
                'changed_at'     => now(),
            ]);
        }

        return $application->fresh(['timelines']);
    }
}
