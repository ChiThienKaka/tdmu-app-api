<?php

namespace App\Features\Domain\Auth\Services;

use App\Features\Domain\Auth\DTOs\GoogleLoginDTO;
use App\Features\Domain\Auth\Repositories\AuthRepository;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use App\Features\Domain\Auth\Services\RegisterRecruiterService;
use App\Features\Domain\Auth\DTOs\RegisterDTO;

class AuthRecruiterService
{
    public function __construct(private AuthRepository $authRepository, private RegisterRecruiterService $registerService)
    {
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
                $user = $this->registerService->createRecruiter($registerLogin);
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
}
