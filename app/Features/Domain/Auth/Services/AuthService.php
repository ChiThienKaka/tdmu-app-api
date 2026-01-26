<?php

namespace App\Features\Domain\Auth\Services;

use App\Features\Domain\Auth\DTOs\GoogleLoginDTO;
use App\Features\Domain\Auth\DTOs\LoginDTO;
use App\Features\Domain\Auth\Repositories\AuthRepository;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use App\Features\Domain\Auth\Services\RegisterService;
use App\Features\Domain\Auth\DTOs\RegisterDTO;

class AuthService
{
    public function __construct(private AuthRepository $authRepository, private RegisterService $registerService)
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
        // 1. Tìm theo google_id
        $user = $this->authRepository->findByGoogleId($dto->google_id);
        // 2. Nếu chưa có -> tìm theo email
        if (!$user) {
            $user = $this->authRepository->findByEmail($dto->email);
            if ($user) {
                // 2a. Email tồn tại (user đăng ký thường) -> gán google_id
                $this->authRepository->update($user, [
                    'google_id' => $dto->google_id,
                ]);
            }else{
                // 3. Chưa có gì -> tạo user mới
                $registerLogin = new RegisterDTO(
                    full_name : $dto->name,
                    email : $dto->email,
                    password : bin2hex(random_bytes(32)),// 64 ký tự random,
                    google_id : $dto->google_id,
                    picture : $dto->picture,
                );
                $this->registerService->createStudentProfile($registerLogin);
            }
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
    public function me():array
    {
       $user = auth('api')->user();
        // check role là sinh viên
        if($user->role_id === 2){
            $user->load('majors.faculty');
            return [$user];
        };
        return [$user];
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
