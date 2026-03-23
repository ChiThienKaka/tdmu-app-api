<?php
namespace App\Features\Domain\Admin\Controllers;
use App\Features\Domain\Admin\Services\CompanyApprovedService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyApprovedController
{
    protected $companyApprovedService;

    public function __construct(CompanyApprovedService $companyApprovedService)
    {
        $this->companyApprovedService = $companyApprovedService;
    }

    // Lấy danh sách công ty theo trạng thái xác thực
    public function ListRecruiterCompany(FormRequest $request)
    {
        $validated = $request->validate([
            'verification_status' => [
                'sometimes',
                Rule::in(['pending', 'verified', 'rejected']),
            ],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
            'keyword'  => ['sometimes', 'string', 'max:255'],
        ]);
        $result = $this->companyApprovedService->ListRecruiterCompany(
            $validated['verification_status'] ?? 'pending',
            $validated['per_page'] ?? 20,
            $validated['keyword'] ?? null
        );
        return response()->json([
            'data'         => $result->items(),
            'current_page' => $result->currentPage(),
            'total_pages'  => $result->lastPage(),
            'total'        => $result->total(),
        ], 200);
    }

    // Cập nhật trạng thái xác thực của công ty
    public function UpdateVerificationStatus(int $company_id, string $verification_status)
    {
        $updatedCompany = $this->companyApprovedService->UpdateVerificationStatus($company_id, $verification_status);
        if ($updatedCompany) {
            return response()->json($updatedCompany);
        } else {
            return response()->json(['message' => 'Company not found'], 404);
        }
    }

    // Duyệt / từ chối công ty qua body
    public function verify(FormRequest $request, int $company_id)
    {
        $validated = $request->validate([
            'verification_status' => ['required', Rule::in(['verified', 'rejected'])],
        ]);
        $company = $this->companyApprovedService->UpdateVerificationStatus(
            $company_id,
            $validated['verification_status']
        );
        if (! $company) {
            return response()->json(['message' => 'Company not found'], 404);
        }
        return response()->json([
            'message' => 'Cập nhật trạng thái công ty thành công',
            'data'    => $company,
        ], 200);
    }

    // Chi tiết một công ty
    public function show(int $company_id)
    {
        $company = $this->companyApprovedService->getDetail($company_id);
        if (! $company) {
            return response()->json(['message' => 'Company not found'], 404);
        }
        return response()->json(['data' => $company], 200);
    }

    // Xóa công ty
    public function destroy(int $company_id)
    {
        $deleted = $this->companyApprovedService->deleteCompany($company_id);
        if (! $deleted) {
            return response()->json(['message' => 'Company not found'], 404);
        }
        return response()->json(['message' => 'Xóa công ty thành công'], 200);
    }
}