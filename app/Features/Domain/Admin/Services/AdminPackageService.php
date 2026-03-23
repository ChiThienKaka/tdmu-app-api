<?php

namespace App\Features\Domain\Admin\Services;

use App\Features\Domain\Recruitment\Packages\Models\RecruiterPackageModel;

class AdminPackageService
{
    public function __construct() {}

    // Lấy danh sách tất cả gói dịch vụ
    public function listPackages(int $perPage = 20)
    {
        return RecruiterPackageModel::orderBy('display_order')->paginate($perPage);
    }

    // Lấy chi tiết gói dịch vụ
    public function getDetail(int $package_id)
    {
        return RecruiterPackageModel::find($package_id);
    }

    // Tạo gói dịch vụ mới
    public function createPackage(array $data): RecruiterPackageModel
    {
        return RecruiterPackageModel::create($data);
    }

    // Cập nhật gói dịch vụ
    public function updatePackage(int $package_id, array $data)
    {
        $package = RecruiterPackageModel::find($package_id);
        if (!$package) {
            return null;
        }
        $package->update($data);
        return $package->fresh();
    }

    // Bật / tắt gói dịch vụ
    public function togglePackage(int $package_id)
    {
        $package = RecruiterPackageModel::find($package_id);
        if (!$package) {
            return null;
        }
        $package->is_active = !$package->is_active;
        $package->save();
        return $package;
    }

    // Xóa gói dịch vụ
    public function deletePackage(int $package_id): bool
    {
        $package = RecruiterPackageModel::find($package_id);
        if (!$package) {
            return false;
        }
        $package->delete();
        return true;
    }
}
