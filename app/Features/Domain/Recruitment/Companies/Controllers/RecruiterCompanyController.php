<?php

namespace App\Features\Domain\Recruitment\Companies\Controllers;

use App\Features\Domain\Recruitment\Companies\Services\RecruiterCompanyService;
use App\Features\Domain\Recruitment\Companies\Resources\RecruiterCompanyResource;
use App\Features\Domain\Recruitment\Companies\Repositories\RecruiterCompanyRepository;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;
use App\Features\Domain\Recruitment\Companies\Requests\RecruiterCompanyRequest;
use App\Features\Domain\Recruitment\Companies\DTOs\RecruiterCompanyDTO;

class RecruiterCompanyController extends Controller
{
    public function __construct(
        protected RecruiterCompanyService $recruiter_company_service,
        protected RecruiterCompanyRepository $repository
    ) {
    }
    //update thông tin công ty
    public function updateRecruiterCompany(RecruiterCompanyRequest $request){
        $user = auth('api')->user();
        $dto = RecruiterCompanyDTO::fromArray($request->validated());
        $media = $request->file('company_image');
        $result = $this->recruiter_company_service->updateRecruiterCompany($user, $dto->toArray(), $media);
        return response()->json([
            $result
        ],200);
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
