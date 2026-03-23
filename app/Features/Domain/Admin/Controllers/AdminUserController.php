<?php

namespace App\Features\Domain\Admin\Controllers;

use App\Features\Domain\Admin\Services\AdminUserService;
use App\Features\Domain\Admin\Resources\AdminUserResource;
use Illuminate\Foundation\Http\FormRequest;

class AdminUserController
{
    public function __construct(protected AdminUserService $userService) {}

    // Danh sách người dùng
    public function index(FormRequest $request)
    {
        $validated = $request->validate([
            'role_id'  => ['sometimes', 'integer'],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
            'keyword'  => ['sometimes', 'string', 'max:255'],
        ]);

        $result = $this->userService->listUsers(
            $validated['role_id'] ?? null,
            $validated['per_page'] ?? 20,
            $validated['keyword'] ?? null
        );

        return response()->json([
            'data'         => AdminUserResource::collection($result),
            'current_page' => $result->currentPage(),
            'total_pages'  => $result->lastPage(),
            'total'        => $result->total(),
        ], 200);
    }

    // Chi tiết người dùng
    public function show(int $user_id)
    {
        $user = $this->userService->getDetail($user_id);
        if (! $user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json(['data' => new AdminUserResource($user)], 200);
    }

    // Khóa / mở khóa tài khoản
    public function toggleBan(int $user_id)
    {
        $user = $this->userService->toggleBan($user_id);
        if (! $user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json([
            'message' => ($user->status === 'banned') ? 'Đã khóa tài khoản' : 'Đã mở khóa tài khoản',
            'data'    => new AdminUserResource($user),
        ], 200);
    }

    // Xóa tài khoản
    public function destroy(int $user_id)
    {
        $deleted = $this->userService->deleteUser($user_id);
        if (! $deleted) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json(['message' => 'Người dùng đã bị xóa'], 200);
    }
}
