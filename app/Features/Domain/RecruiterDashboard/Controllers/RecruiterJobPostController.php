<?php

namespace App\Features\Domain\RecruiterDashboard\Controllers;

use App\Features\Domain\RecruiterDashboard\Services\RecruiterJobPostService;
use App\Features\Domain\RecruiterDashboard\Resources\RecruiterJobPostResource;
use App\Features\Domain\RecruiterDashboard\Requests\StoreJobPostRequest;
use App\Features\Domain\RecruiterDashboard\Requests\UpdateJobPostRequest;
use Illuminate\Http\Request;

class RecruiterJobPostController
{
    public function __construct(protected
        RecruiterJobPostService $jobPostService
        )
    {
    }

    /**
     * GET /api/recruiter/job-post
     * Danh sách bài đăng của nhà tuyển dụng
     */
    public function index(Request $request)
    {
        $user = auth('api')->user();

        $validated = $request->validate([
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
            'status' => ['sometimes', 'string', 'in:draft,pending,approved,rejected'],
            'keyword' => ['sometimes', 'string', 'max:255'],
        ]);

        $result = $this->jobPostService->listByRecruiter(
            $user->user_id,
            $validated,
            $validated['per_page'] ?? 15
        );

        return response()->json([
            'data' => RecruiterJobPostResource::collection($result),
            'current_page' => $result->currentPage(),
            'total_pages' => $result->lastPage(),
            'total' => $result->total(),
        ], 200);
    }

    /**
     * GET /api/recruiter/job-post/{job_id}
     * Chi tiết bài đăng
     */
    public function show(int $job_id)
    {
        $user = auth('api')->user();

        $job = $this->jobPostService->getDetail($user->user_id, $job_id);

        if (!$job) {
            return response()->json(['message' => 'Bài đăng không tồn tại hoặc không thuộc về bạn.'], 404);
        }

        return response()->json(['data' => new RecruiterJobPostResource($job)], 200);
    }

    /**
     * POST /api/recruiter/job-post
     * Tạo bài đăng mới
     */
    public function store(StoreJobPostRequest $request)
    {
        $user = auth('api')->user();


        $job = $this->jobPostService->create($user->user_id, $request->validated());

        return response()->json([
            'message' => 'Tạo bài đăng thành công. Bài đang chờ admin duyệt.',
            'data' => new RecruiterJobPostResource($job),
        ], 201);
    }

    /**
     * PUT /api/recruiter/job-post/{job_id}
     * Cập nhật bài đăng
     */
    public function update(UpdateJobPostRequest $request, int $job_id)
    {
        $user = auth('api')->user();

        $job = $this->jobPostService->update($user->user_id, $job_id, $request->validated());

        if (!$job) {
            return response()->json([
                'message' => 'Bài đăng không tồn tại, không thuộc về bạn, hoặc đã được duyệt (không thể sửa).',
            ], 404);
        }

        return response()->json([
            'message' => 'Cập nhật bài đăng thành công.',
            'data' => new RecruiterJobPostResource($job),
        ], 200);
    }

    /**
     * DELETE /api/recruiter/job-post/{job_id}
     * Xóa bài đăng
     */
    public function destroy(int $job_id)
    {
        $user = auth('api')->user();

        $deleted = $this->jobPostService->delete($user->user_id, $job_id);

        if (!$deleted) {
            return response()->json(['message' => 'Bài đăng không tồn tại hoặc không thuộc về bạn.'], 404);
        }

        return response()->json(['message' => 'Xóa bài đăng thành công.'], 200);
    }

    /**
     * PATCH /api/recruiter/job-post/{job_id}/refresh
     * Làm mới bài đăng (cập nhật last_refreshed_at)
     */
    public function refresh(int $job_id)
    {
        $user = auth('api')->user();

        $job = $this->jobPostService->refresh($user->user_id, $job_id);

        if (!$job) {
            return response()->json([
                'message' => 'Không thể làm mới. Bài đăng không tồn tại, không phải của bạn, hoặc chưa được duyệt.',
            ], 404);
        }

        return response()->json([
            'message' => 'Làm mới bài đăng thành công.',
            'data' => new RecruiterJobPostResource($job),
        ], 200);
    }
}
