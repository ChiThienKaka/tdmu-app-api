<?php

namespace App\Features\Domain\Auth\Controllers;

use App\Features\Domain\Auth\DTOs\GoogleLoginDTO;
use App\Features\Domain\Auth\DTOs\LoginDTO;
use App\Features\Domain\Auth\DTOs\RegisterDTO;
use App\Features\Domain\Auth\Requests\GoogleLoginRequest;
use App\Features\Domain\Auth\Requests\LoginRequest;
use App\Features\Domain\Auth\Requests\RegisterRequest;
use App\Features\Domain\Auth\Resources\AuthResource;
use App\Features\Domain\Auth\Resources\TokenResource;
use App\Features\Domain\Auth\Services\AuthService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Features\Domain\Auth\Services\RegisterService;
use App\Features\Domain\Auth\Resources\UserInfoResource;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService, private RegisterService $registerService)
    {
    }
    /**
     * Đăng nhập
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $dto = LoginDTO::fromArray($request->validated());
        $result = $this->authService->login($dto);

        if (!$result) {
            return response()->json([
                'message' => 'Email hoặc mật khẩu không chính xác',
            ], 401);
        }

        return response()->json(
            new TokenResource($result),
            200
        );
    }

    /**
     * Đăng nhập bằng Google
     */
    public function loginWithGoogle(GoogleLoginRequest $request): JsonResponse
    {
        $dto = GoogleLoginDTO::fromArray($request->validated());
        $result = $this->authService->loginWithGoogle($dto);

        return response()->json(
            new TokenResource($result),
            200
        );
    }

    /**
     * Đăng ký
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $dto = RegisterDTO::fromArray($request->validated());
        $result = $this->registerService->createStudentProfile($dto);

        if (!$result) {
            return response()->json([
                'message' => 'Đăng ký thất bại',
            ], 400);
        }
        return response()->json([
                'message' => 'Đăng ký thành công',
            ], 201);
    }
    /**
     * Lấy thông tin người dùng hiện tại
     */
    public function me(): JsonResponse
    {
        $user = $this->authService->me();

        if (!$user) {
            return response()->json([
                'message' => 'Không tìm thấy người dùng',
            ], 404);
        }

        return response()->json(
            new UserInfoResource($user),
            200
        );
    }

    /**
     * Đăng xuất
     */
    public function logout(): JsonResponse
    {
        $this->authService->logout();

        return response()->json([
            'message' => 'Đăng xuất thành công',
        ], 200);
    }

    /**
     * Làm mới token
     */
    public function refreshToken(): JsonResponse
    {
        $result = $this->authService->refreshToken();

        if (!$result) {
            return response()->json([
                'message' => 'Làm mới token thất bại',
            ], 401);
        }
        
        return response()->json($result, 200);
    }
}
