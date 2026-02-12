<?php

namespace App\Features\Domain\Auth\Controllers;

use App\Features\Domain\Auth\Requests\RegisterRecruiterRequest;
use App\Http\Controllers\Controller;
use App\Features\Domain\Auth\Services\RegisterRecruiterService;
use App\Features\Domain\Auth\DTOs\RegisterDTO;
use App\Features\Domain\Auth\Services\AuthRecruiterService;
use App\Features\Domain\Auth\Requests\GoogleLoginRecruiterRequest;
use App\Features\Domain\Auth\DTOs\GoogleLoginDTO;
use Illuminate\Http\JsonResponse;
use App\Features\Domain\Auth\Resources\TokenResource;

class AuthRecruiterController extends Controller
{
    public function __construct(private RegisterRecruiterService $registerService,
    private AuthRecruiterService $auth_recruiter_service)
    {

    }
    public function registerRecruiter(RegisterRecruiterRequest $request){
        $dto = RegisterDTO::fromArray($request->validated());
        $result = $this->registerService->createRecruiter($dto);
         if (!$result) {
            return response()->json([
                'message' => 'Đăng ký thất bại',
            ], 400);
        }
        return response()->json([
                'message' => 'Đăng ký thành công',
            ], 200);
    }

    public function loginWithGoogle(GoogleLoginRecruiterRequest $request): JsonResponse
    {
        $dto = GoogleLoginDTO::fromArray($request->validated());
        $result = $this->auth_recruiter_service->loginWithGoogle($dto);

        return response()->json(
            new TokenResource($result),
            200
        );
    }
}