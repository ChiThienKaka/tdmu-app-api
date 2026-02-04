<?php
namespace App\Features\Domain\Recruitment\Packages\Controllers;
use App\Features\Domain\Recruitment\Packages\Repositories\RecruiterPackageRepository;
use App\Features\Domain\Recruitment\Packages\Resources\RecruiterPackageResource;
use App\Http\Controllers\Controller;

class RecruiterController extends Controller
{
    public function __construct(
        protected RecruiterPackageRepository $recruiterPackageRepository
    ) {
    }
    public function getRecruiterPackages_isActive()
    {
        $result = $this->recruiterPackageRepository->getActive();
        return response()->json([
            'data' => RecruiterPackageResource::collection($result),
        ],200);
    }
}