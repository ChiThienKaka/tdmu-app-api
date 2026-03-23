<?php

namespace App\Features\Domain\Admin\Services;

use App\Models\User;

class AdminUserService
{
    public function __construct() {}

    // Danh sách người dùng (filter theo role_id và tìm kiếm tên/email)
    public function listUsers(int $role_id = null, int $perPage = 20, string $keyword = null)
    {
        $query = User::with('role')->orderByDesc('created_at');

        if ($role_id) {
            $query->where('role_id', $role_id);
        }

        if ($keyword) {
            $query->where(function (\Illuminate\Database\Eloquent\Builder $q) use ($keyword) {
                $q->where('full_name', 'like', "%{$keyword}%")
                  ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        return $query->paginate($perPage);
    }

    // Chi tiết người dùng
    public function getDetail(int $user_id)
    {
        return User::with(['role', 'company', 'studentProfile'])->find($user_id);
    }

    // Khóa / mở khóa tài khoản
    public function toggleBan(int $user_id)
    {
        $user = User::find($user_id, ['*']);
        if (! $user) {
            return null;
        }

        // Giả sử có field 'status' hoặc 'is_active'. 
        // Trong User.php có 'status'. Giả sử 'active' và 'banned'.
        $user->status = ($user->status === 'banned') ? 'active' : 'banned';
        $user->save();

        return $user;
    }

    // Xóa tài khoản
    public function deleteUser(int $user_id): bool
    {
        $user = User::find($user_id, ['*']);

        if (! $user) {
            return false;
        }
        $user->delete();
        return true;
    }
}
