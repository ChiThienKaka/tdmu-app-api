<?php

namespace App\Features\Domain\RecruiterDashboard\Services;

use App\Features\Domain\Recruitment\Companies\Models\RecruiterCompanyModel;

class RecruiterCompanyService
{
    /**
     * Lấy thông tin công ty của nhà tuyển dụng
     */
    public function getByUser(int $userId): ?RecruiterCompanyModel
    {
        return RecruiterCompanyModel::with('user')
            ->where('user_id', $userId)
            ->first();
    }

    /**
     * Cập nhật thông tin công ty (không cho phép thay đổi verification_status)
     */
    public function update(int $userId, array $data): ?RecruiterCompanyModel
    {
        $company = RecruiterCompanyModel::where('user_id', $userId)->first();
        if (!$company) {
            return null;
        }

        // Loại bỏ các trường không được phép sửa từ phía NTD
        unset($data['verification_status'], $data['user_id']);

        $company->update($data);
        return $company->fresh();
    }
}
