<?php
namespace App\Features\Domain\Admin\Services;
use App\Features\Domain\Recruitment\Companies\Models\RecruiterCompanyModel;

class CompanyApprovedService
{
    public function __construct()
    {
        //
    }

    // Lấy danh sách công ty theo trạng thái xác thực và tìm kiếm tên
    public function ListRecruiterCompany(string $verification_status = 'pending', int $perPage = 20, string $keyword = null)
    {
        $query = RecruiterCompanyModel::with('user')
            ->where('verification_status', $verification_status)
            ->orderBy('created_at', 'desc');

        if ($keyword) {
            $query->where('company_name', 'like', "%{$keyword}%");
        }

        return $query->paginate($perPage);
    }

    // Cập nhật trạng thái xác thực của công ty
    public function UpdateVerificationStatus(int $company_id, string $verification_status)
    {
        $company = RecruiterCompanyModel::find($company_id);
        if (!$company) {
            return null;
        }
        $company->verification_status = $verification_status;
        $company->save();
        return $company;
    }

    // Lấy chi tiết một công ty
    public function getDetail(int $company_id)
    {
        return RecruiterCompanyModel::with('user')->find($company_id);
    }

    // Xóa công ty
    public function deleteCompany(int $company_id): bool
    {
        $company = RecruiterCompanyModel::find($company_id);
        if (!$company) {
            return false;
        }
        $company->delete();
        return true;
    }
}