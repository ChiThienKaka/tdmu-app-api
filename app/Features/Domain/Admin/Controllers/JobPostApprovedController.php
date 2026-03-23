<?php

namespace App\Features\Domain\Admin\Controllers;

use App\Features\Domain\Admin\Resources\AdminJobPostResource;
use App\Features\Domain\Admin\Services\JobPostApprovedService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JobPostApprovedController
{
    protected $jobPostApprovedService;

    public function __construct(JobPostApprovedService $jobPostApprovedService)
    {
        $this->jobPostApprovedService = $jobPostApprovedService;
    }

    // Lấy danh sách bài post tuyển dụng theo trạng thái duyệt
    public function listJobPosts(FormRequest $request)
    {
        $validated = $request->validate([
            'status' => [
                'sometimes',
                Rule::in(['draft', 'pending', 'approved', 'rejected', 'expired', 'closed']),
            ],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
            'keyword'  => ['sometimes', 'string', 'max:255'],
        ]);

        $status = $validated['status'] ?? 'pending';
        $perPage = $validated['per_page'] ?? 20;
        $keyword = $validated['keyword'] ?? null;

        $result = $this->jobPostApprovedService->listPendingJobPosts($status, $perPage, $keyword);

        return response()->json([
            'data' => AdminJobPostResource::collection($result),
            'current_page' => $result->currentPage(),
            'total_pages' => $result->lastPage(),
            'total' => $result->total(),
        ], 200);
    }

    // Cập nhật trạng thái duyệt của bài post tuyển dụng
    public function updateJobPostStatus(FormRequest $request, int $job_id)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in([ 
                'draft',
                'pending',
                'approved',
                'rejected',
                'expired',
                'closed' ]),
            ],
            'rejection_reason' => [
                'required_if:status,rejected',
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $moderatedBy = auth('api')->id();

        $updatedPost = $this->jobPostApprovedService->updateJobPostStatus(
            $job_id,
            $validated['status'],
            $validated['rejection_reason'] ?? null,
            $moderatedBy
        );

        if (! $updatedPost) {
            return response()->json(['message' => 'Job post not found'], 404);
        }

        return response()->json([
            'message' => 'Cập nhật trạng thái bài đăng thành công',
            'data' => new AdminJobPostResource($updatedPost),
        ], 200);
    }

    // Chi tiết một bài đăng
    public function show(int $job_id)
    {
        $jobPost = $this->jobPostApprovedService->getDetail($job_id);
        if (! $jobPost) {
            return response()->json(['message' => 'Job post not found'], 404);
        }
        return response()->json(['data' => new AdminJobPostResource($jobPost)], 200);
    }

    // Xóa bài đăng vi phạm
    public function destroy(int $job_id)
    {
        $deleted = $this->jobPostApprovedService->deleteJobPost($job_id);
        if (! $deleted) {
            return response()->json(['message' => 'Job post not found'], 404);
        }
        return response()->json(['message' => 'Xóa bài đăng thành công'], 200);
    }

    // Thống kê số lượng bài đăng theo status
    public function stats()
    {
        $stats = $this->jobPostApprovedService->getStats();
        return response()->json(['data' => $stats], 200);
    }
}
