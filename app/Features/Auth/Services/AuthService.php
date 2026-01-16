<?php

namespace App\Features\Auth\Services;

use App\Features\Auth\DTOs\GoogleLoginDTO;
use App\Features\Auth\DTOs\LoginDTO;
use App\Features\Auth\Repositories\AuthRepository;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function __construct(private AuthRepository $authRepository)
    {
    }

    /**
     * Đăng nhập với email và mật khẩu
     */
    public function login(LoginDTO $dto): ?array
    {
        $user = $this->authRepository->findByEmail($dto->email);

        if (!$user || !Hash::check($dto->password, $user->password)) {
            return null;
        }

        $token = JwtAuth::fromUser($user);

        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => $user,
        ];
    }

    /**
     * Đăng nhập với Google
     */
    public function loginWithGoogle(GoogleLoginDTO $dto): array
    {
        $user = $this->authRepository->findByGoogleId($dto->google_id);

        if (!$user) {
            // Tạo user mới nếu không tồn tại
            $user = $this->authRepository->create([
                'name' => $dto->name,
                'email' => $dto->email,
                'google_id' => $dto->google_id,
                'avatar' => $dto->picture,
                'email_verified_at' => now(),
                'password' => Hash::make(bin2hex(random_bytes(32))), // Random password
            ]);
        } else {
            // Cập nhật thông tin nếu đã tồn tại
            $this->authRepository->update($user, [
                'avatar' => $dto->picture,
            ]);
        }

        $token = JwtAuth::fromUser($user);

        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => $user,
        ];
    }

    /**
     * Lấy thông tin user từ token
     */
    public function me(): ?User
    {
        return auth('api')->user();
    }

    /**
     * Đăng xuất
     */
    public function logout(): bool
    {
        auth('api')->logout();
        return true;
    }

    /**
     * Refresh token
     */
    public function refreshToken(): ?array
    {
        try {
            $token = JwtAuth::refresh();

            return [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60,
            ];
        } catch (\Exception $e) {
            return null;
        }
    }
}
