<?php

namespace App\Features\Domain\Admin\Controllers;

use App\Features\Domain\Admin\Services\AdminPackageService;
use App\Features\Domain\Admin\Resources\AdminPackageResource;
use Illuminate\Foundation\Http\FormRequest;

class AdminPackageController
{
    public function __construct(protected AdminPackageService $packageService) {}

    // Danh sách tất cả gói dịch vụ
    public function index(FormRequest $request)
    {
        $validated = $request->validate([
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
        ]);
        $result = $this->packageService->listPackages($validated['per_page'] ?? 20);
        return response()->json([
            'data'         => AdminPackageResource::collection($result),
            'current_page' => $result->currentPage(),
            'total_pages'  => $result->lastPage(),
            'total'        => $result->total(),
        ], 200);
    }

    // Chi tiết gói dịch vụ
    public function show(int $package_id)
    {
        $package = $this->packageService->getDetail($package_id);
        if (! $package) {
            return response()->json(['message' => 'Package not found'], 404);
        }
        return response()->json(['data' => new AdminPackageResource($package)], 200);
    }

    // Tạo gói dịch vụ mới
    public function store(FormRequest $request)
    {
        $validated = $request->validate([
            'package_name'         => ['required', 'string', 'max:255'],
            'price'                => ['required', 'numeric', 'min:0'],
            'duration_days'        => ['required', 'integer', 'min:1'],
            'post_limit'           => ['required', 'integer', 'min:0'],
            'featured_posts_limit' => ['sometimes', 'integer', 'min:0'],
            'refresh_limit'        => ['sometimes', 'integer', 'min:0'],
            'support_priority'     => ['sometimes', 'string', 'max:50'],
            'features'             => ['sometimes', 'array'],
            'is_active'            => ['sometimes', 'boolean'],
            'display_order'        => ['sometimes', 'integer', 'min:0'],
        ]);
        $package = $this->packageService->createPackage($validated);
        return response()->json([
            'message' => 'Tạo gói dịch vụ thành công',
            'data'    => new AdminPackageResource($package),
        ], 201);
    }

    // Cập nhật gói dịch vụ
    public function update(FormRequest $request, int $package_id)
    {
        $validated = $request->validate([
            'package_name'         => ['sometimes', 'string', 'max:255'],
            'price'                => ['sometimes', 'numeric', 'min:0'],
            'duration_days'        => ['sometimes', 'integer', 'min:1'],
            'post_limit'           => ['sometimes', 'integer', 'min:0'],
            'featured_posts_limit' => ['sometimes', 'integer', 'min:0'],
            'refresh_limit'        => ['sometimes', 'integer', 'min:0'],
            'support_priority'     => ['sometimes', 'string', 'max:50'],
            'features'             => ['sometimes', 'array'],
            'display_order'        => ['sometimes', 'integer', 'min:0'],
        ]);
        $package = $this->packageService->updatePackage($package_id, $validated);
        if (! $package) {
            return response()->json(['message' => 'Package not found'], 404);
        }
        return response()->json([
            'message' => 'Cập nhật gói dịch vụ thành công',
            'data'    => new AdminPackageResource($package),
        ], 200);
    }

    // Bật / tắt gói dịch vụ
    public function toggle(int $package_id)
    {
        $package = $this->packageService->togglePackage($package_id);
        if (! $package) {
            return response()->json(['message' => 'Package not found'], 404);
        }
        return response()->json([
            'message' => $package->is_active ? 'Đã kích hoạt gói dịch vụ' : 'Đã tắt gói dịch vụ',
            'data'    => new AdminPackageResource($package),
        ], 200);
    }

    // Xóa gói dịch vụ
    public function destroy(int $package_id)
    {
        $deleted = $this->packageService->deletePackage($package_id);
        if (! $deleted) {
            return response()->json(['message' => 'Package not found'], 404);
        }
        return response()->json(['message' => 'Xóa gói dịch vụ thành công'], 200);
    }
}
