<?php

namespace App\Features\Domain\RecruiterDashboard\Controllers;

use App\Features\Domain\RecruiterDashboard\Services\RecruiterCompanyService;
use App\Features\Domain\RecruiterDashboard\Resources\RecruiterCompanyResource;
use App\Features\Domain\RecruiterDashboard\Requests\UpdateCompanyRequest;

class RecruiterCompanyController
{
    public function __construct(
        protected RecruiterCompanyService $companyService
    ) {}

    /**
     * GET /api/recruiter/company
     * Xem thông tin công ty của nhà tuyển dụng
     */
    public function show()
    {
        $user = auth('api')->user();

        $company = $this->companyService->getByUser($user->user_id);

        if (!$company) {
            return response()->json(['message' => 'Bạn chưa có thông tin công ty.'], 404);
        }

        return response()->json(['data' => new RecruiterCompanyResource($company)], 200);
    }

    /**
     * PUT /api/recruiter/company
     * Cập nhật thông tin công ty
     */
    public function update(UpdateCompanyRequest $request)
    {
        $user = auth('api')->user();

        $company = $this->companyService->update($user->user_id, $request->validated());

        if (!$company) {
            return response()->json(['message' => 'Bạn chưa có thông tin công ty để cập nhật.'], 404);
        }

        return response()->json([
            'message' => 'Cập nhật thông tin công ty thành công.',
            'data'    => new RecruiterCompanyResource($company),
        ], 200);
    }
}
