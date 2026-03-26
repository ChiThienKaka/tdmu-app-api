<?php

namespace App\Features\Domain\RecruiterDashboard\Controllers;

use App\Features\Domain\RecruiterDashboard\Services\RecruiterApplicationService;
use App\Features\Domain\RecruiterDashboard\Resources\RecruiterApplicationResource;
use App\Features\Domain\RecruiterDashboard\Requests\UpdateApplicationStatusRequest;
use Illuminate\Http\Request;

class RecruiterApplicationController
{
    public function __construct(
        protected RecruiterApplicationService $applicationService
    ) {}

    /**
     * GET /api/recruiter/application
     * Tất cả đơn ứng tuyển của nhà tuyển dụng
     */
    public function index(Request $request)
    {
        $user = auth('api')->user();

        $validated = $request->validate([
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
            'status'   => ['sometimes', 'string'],
            'job_id'   => ['sometimes', 'integer'],
        ]);

        $result = $this->applicationService->listByRecruiter(
            $user->user_id,
            $validated,
            $validated['per_page'] ?? 10
        );

        return response()->json([
            'data'         => RecruiterApplicationResource::collection($result),
            'current_page' => $result->currentPage(),
            'total_pages'  => $result->lastPage(),
            'total'        => $result->total(),
        ], 200);
    }

    /**
     * GET /api/recruiter/job-post/{job_id}/applications
     * Danh sách ứng viên theo bài đăng
     */
    public function byJobPost(Request $request, int $job_id)
    {
        $user = auth('api')->user();

        $perPage = $request->validate(['per_page' => ['sometimes', 'integer', 'min:1', 'max:100']])['per_page'] ?? 15;

        $result = $this->applicationService->listByJobPost($user->user_id, $job_id, $perPage);

        if (!$result) {
            return response()->json(['message' => 'Bài đăng không tồn tại hoặc không thuộc về bạn.'], 404);
        }

        return response()->json([
            'data'         => RecruiterApplicationResource::collection($result),
            'current_page' => $result->currentPage(),
            'total_pages'  => $result->lastPage(),
            'total'        => $result->total(),
        ], 200);
    }

    /**
     * GET /api/recruiter/application/{id}
     * Chi tiết đơn ứng tuyển
     */
    public function show(int $id)
    {
        $user = auth('api')->user();

        $application = $this->applicationService->getDetail($user->user_id, $id);

        if (!$application) {
            return response()->json(['message' => 'Đơn ứng tuyển không tồn tại hoặc không thuộc về bạn.'], 404);
        }

        return response()->json(['data' => new RecruiterApplicationResource($application)], 200);
    }

    /**
     * PATCH /api/recruiter/application/{id}/status
     * Cập nhật trạng thái ứng viên
     */
    public function updateStatus(UpdateApplicationStatusRequest $request, int $id)
    {
        $user      = auth('api')->user();
        $validated = $request->validated();

        $application = $this->applicationService->updateStatus(
            $user->user_id,
            $id,
            $validated['status'],
            array_filter([
                'note'             => $validated['note'] ?? null,
                'rejection_reason' => $validated['rejection_reason'] ?? null,
                'rating'           => $validated['rating'] ?? null,
                'reviewed_by'      => $user->user_id,
                'reviewed_at'      => now(),
            ])
        );

        if (!$application) {
            return response()->json(['message' => 'Đơn ứng tuyển không tồn tại hoặc không thuộc về bạn.'], 404);
        }

        return response()->json([
            'message' => 'Cập nhật trạng thái thành công.',
            'data'    => new RecruiterApplicationResource($application),
        ], 200);
    }

    /**
     * POST /api/recruiter/application/{id}/interview
     * Lên lịch phỏng vấn
     */
    public function scheduleInterview(Request $request, int $id)
    {
        $user = auth('api')->user();

        $validated = $request->validate([
            'interview_schedule' => ['required', 'date', 'after:now'],
            'interview_location' => ['required', 'string', 'max:255'],
        ]);

        $application = $this->applicationService->scheduleInterview(
            $user->user_id,
            $id,
            $validated['interview_schedule'],
            $validated['interview_location']
        );

        if (!$application) {
            return response()->json(['message' => 'Đơn ứng tuyển không tồn tại hoặc không thuộc về bạn.'], 404);
        }

        return response()->json([
            'message' => 'Lên lịch phỏng vấn thành công.',
            'data'    => new RecruiterApplicationResource($application),
        ], 200);
    }
}
