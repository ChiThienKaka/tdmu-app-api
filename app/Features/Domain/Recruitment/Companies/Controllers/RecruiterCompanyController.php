<?php

namespace App\Features\Domain\Recruitment\Companies\Controllers;

use App\Features\Domain\Recruitment\Companies\Repositories\RecruiterCompanyRepository;
use App\Features\Domain\Recruitment\Companies\Resources\RecruiterCompanyResource;
use App\Http\Controllers\Controller;

class RecruiterCompanyController extends Controller
{
    public function __construct(
        protected RecruiterCompanyRepository $repository
    ) {
    }

    public function getVerifiedCompanies()
    {
        $result = $this->repository->getVerified();
        return response()->json([
            'data' => RecruiterCompanyResource::collection($result),
        ], 200);
    }
}
