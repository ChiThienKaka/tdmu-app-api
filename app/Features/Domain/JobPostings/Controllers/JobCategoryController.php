<?php
namespace App\Features\Domain\JobPostings\Controllers;
use App\Features\Domain\JobPostings\Repositories\JobCategoryRepository;
use App\Http\Controllers\Controller;
use App\Features\Domain\JobPostings\Resources\JobCategoryResource;

class JobCategoryController extends Controller
{
    public function __construct(
        private JobCategoryRepository $job_category_repository
    )
    {
    }
    //get list category jobpost
    public function listJobCategoryParent(){
        auth('api')->user();
        $result = $this->job_category_repository->listAllJobCategory();
        return response()->json([
            JobCategoryResource::collection($result)
        ],200);
    }
}