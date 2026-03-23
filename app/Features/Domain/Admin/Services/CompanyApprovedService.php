<?php
namespace App\Features\Domain\Admin\Services;
use App\Features\Domain\Recruitment\Companies\Models\RecruiterCompanyModel;

class CompanyApprovedService
{
    public function __construct()
    {
        //
    }
    // lấy danh sách công ty theo trạng thái xác thực
    public function ListRecruiterCompany(string $verification_status = 'pending', int $perPage = 20)
    {
        $company = RecruiterCompanyModel::with('user')
        ->where('verification_status', $verification_status)
        ->paginate($perPage);
        return $company;
    }

    // cập nhật trạng thái xác thực của công ty
    public function UpdateVerificationStatus(int $company_id, string $verification_status)
    {
        $company = RecruiterCompanyModel::find($company_id);
        if (!$company) {
            return null; // hoặc ném ngoại lệ nếu muốn
        }
        $company->verification_status = $verification_status;
        $company->save();
        return $company;
    }
}