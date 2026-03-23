<?php
namespace App\Features\Domain\Admin\Controllers;
use App\Features\Domain\Admin\Services\CompanyApprovedService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;

class CompanyApprovedController
{
    protected $companyApprovedService;

    public function __construct(CompanyApprovedService $companyApprovedService)
    {
        $this->companyApprovedService = $companyApprovedService;
    }

    // lấy danh sách công ty theo trạng thái xác thực
    public function ListRecruiterCompany(FormRequest $request)
    {
        $validated = $request->validate([
            'verification_status' => [
                'sometimes',
                Rule::in(['pending', 'verified', 'rejected'])
            ],
        ]);
        $result = $this->companyApprovedService->ListRecruiterCompany($validated['verification_status']??'pending');
        return response()->json([
            'data' => $result
        ],200);
    }

    // cập nhật trạng thái xác thực của công ty
    public function UpdateVerificationStatus(int $company_id, string $verification_status)
    {
        $updatedCompany = $this->companyApprovedService->UpdateVerificationStatus($company_id, $verification_status);
        if ($updatedCompany) {
            return response()->json($updatedCompany);
        } else {
            return response()->json(['message' => 'Company not found'], 404);
        }
    }
}