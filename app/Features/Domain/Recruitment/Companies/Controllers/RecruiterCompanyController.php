<?php

namespace App\Features\Domain\Recruitment\Companies\Controllers;

use App\Features\Domain\Recruitment\Companies\Repositories\RecruiterCompanyRepository;
use App\Features\Domain\Recruitment\Companies\Resources\RecruiterCompanyResource;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;

class RecruiterCompanyController extends Controller
{
    public function __construct(
        protected RecruiterCompanyRepository $repository
    ) {
    }
    //các công ty đã xác minh
    public function getVerifiedCompanies()
    {
        $result = $this->repository->getVerified();
        return response()->json([
            'data' => RecruiterCompanyResource::collection($result),
        ], 200);
    }
    // lấy thông tin công ty của nhà tuyển dụng 
    public function getInfoComapanyUser(){
        $user = auth('api')->user();
        $result = $this->repository->getInfoCompanyUser($user);
        return response()->json([
            new RecruiterCompanyResource($result)
        ],200);
    }
}
