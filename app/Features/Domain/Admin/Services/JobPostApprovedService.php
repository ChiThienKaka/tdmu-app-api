<?php
namespace App\Features\Domain\Admin\Services;

use App\Features\Domain\JobPostings\Models\JobPostModel;
use Illuminate\Support\Facades\Auth;

class JobPostApprovedService
{
    public function __construct()
    {
        //
    }

    // Lấy danh sách bài post tuyển dụng theo trạng thái duyệt và tìm kiếm tiêu đề
    public function listPendingJobPosts(string $status = 'pending', int $perPage = 20, string $keyword = null)
    {
        $query = JobPostModel::with(['company', 'user'])
            ->where('status', $status)
            ->orderBy('created_at', 'desc');

        if ($keyword) {
            $query->where('job_title', 'like', "%{$keyword}%");
        }

        return $query->paginate($perPage);
    }

    // Cập nhật trạng thái duyệt của bài post tuyển dụng
    public function updateJobPostStatus(int $job_id, string $status, ?string $rejection_reason, int $moderated_by)
    {
        $jobPost = JobPostModel::find($job_id);
        if (!$jobPost) {
            return null;
        }

        $jobPost->status           = $status;
        $jobPost->moderated_by     = $moderated_by;
        $jobPost->moderated_at     = now();
        $jobPost->rejection_reason = $status === 'rejected' ? $rejection_reason : null;

        if ($status === 'approved' && is_null($jobPost->published_at)) {
            $jobPost->published_at = now();
        }

        $jobPost->save();
        return $jobPost;
    }

    // Lấy chi tiết một bài đăng
    public function getDetail(int $job_id)
    {
        return JobPostModel::with(['company', 'user', 'category', 'moderator'])->find($job_id);
    }

    // Xóa bài đăng vi phạm
    public function deleteJobPost(int $job_id): bool
    {
        $jobPost = JobPostModel::find($job_id);
        if (!$jobPost) {
            return false;
        }
        $jobPost->delete();
        return true;
    }

    // Thống kê số lượng bài đăng theo từng trạng thái
    public function getStats(): array
    {
        $statuses = ['draft', 'pending', 'approved', 'rejected', 'expired', 'closed'];
        $stats = [];
        foreach ($statuses as $status) {
            $stats[$status] = JobPostModel::where('status', $status)->count();
        }
        $stats['total'] = JobPostModel::count();
        return $stats;
    }
}