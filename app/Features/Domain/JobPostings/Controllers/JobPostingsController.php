<?php
namespace App\Features\Domain\JobPostings\Controllers;
use App\Http\Controllers\Controller;
use App\Features\Domain\JobPostings\Services\JobPostingsSerivce;
use App\Features\Domain\JobPostings\Resources\ListPostResource;
use Illuminate\Foundation\Http\FormRequest;
use App\Features\Domain\JobPostings\Resources\ListPostDetailResource;

class JobPostingsController extends Controller
{
    public function __construct(
        private JobPostingsSerivce $job_postings_serivce
    )
    {
    }
    //Lấy thông tin bài post tuyển dụng theo user tuyển dụng
    public function getStoreJobPostByUser(){
        $user = auth('api')->user();
        $result = $this->job_postings_serivce->getStoreJobPostByUser($user);
        return response()->json([
            'data' => ListPostResource::collection($result),
            'current_page' => $result->currentPage(),
            'total_pages' => $result->lastPage(),
            'total' => $result->total(),
        ],200);
    }
    //get list post
    public function getStoreJobPost(){
        $user = auth('api')->user(); // hoặc $request->user()
        $result = $this->job_postings_serivce->getStoreJobPost();
        return response()->json([
                'data' => ListPostResource::collection($result),
                'current_page' => $result->currentPage(),
                'total_pages' => $result->lastPage(),
                'total' => $result->total(),
            ], 200);
    }
    // get list post detail, đã check ở trên
    public function getStoreJobPostDetail(FormRequest $request){
        $user = auth('api')->user(); // hoặc $request->user()
        $jobId = $request->job_id;
        $result = $this->job_postings_serivce->getListDetailJobPost($jobId);
        return response()->json(
            new ListPostDetailResource($result)
            , 200);
    }
}