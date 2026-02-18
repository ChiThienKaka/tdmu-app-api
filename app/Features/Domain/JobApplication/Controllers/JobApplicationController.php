<?php
namespace App\Features\Domain\JobApplication\Controllers;
use App\Http\Controllers\Controller;
use App\Features\Domain\JobApplication\Repositories\JobApplicationRepository;
use App\Features\Domain\JobApplication\Requests\JobApplicationRequests;
use App\Features\Domain\JobApplication\Repositories\ListJobApplicationRepository;
use Illuminate\Foundation\Http\FormRequest;
use App\Features\Domain\JobApplication\Resources\JobApplicationResource;
use App\Features\Domain\JobApplication\Requests\UpdateApplicantRequests;

class JobApplicationController extends Controller
{
    public function __construct(
        private JobApplicationRepository $job_application_repository,
        private ListJobApplicationRepository $list_job_application_repository
    ){}
    //Nhà tuyển dụng cập nhật hồ sơ của ứng viên
    public function updateApplicantByRecruiter(UpdateApplicantRequests $request){
        $user = auth('api')->user();
        $data = $request->validated();
        $result = $this->list_job_application_repository->updateApplicant($data['application_id'], $data['status'],$user);
        return response()->json([
            $result
        ], 200);
    }
    //thông tinh dánh sách ứng viên và của bài post dựa trên nhà tuyển dụng 
    //(lấy id bài post từ nhà tuyển dụng từ api khác rồi không phải check lại dữ liệu)
    public function getApplicantbyPostid(FormRequest $request){
        $user = auth('api')->user();
        $job_id = $request->job_id;
        $result = $this->list_job_application_repository->listApplicant($job_id);
        return response()->json([
            JobApplicationResource::collection($result)
        ],200);
    }

    //get create application form profile
    public function createJobApplicationProfileCV(FormRequest $request){
        $user = auth('api')->user();
        $job_id = $request->job_id;
        $result = $this->job_application_repository->applyWithDefaultCV($user, $job_id);
        return response()->json([
            $result
        ],200);
    }
    //get create application form upload cv
    public function createJobApplicationFormCV(JobApplicationRequests $request){
        $user = auth('api')->user();
        $validate = $request->validated();
        $media = $request->file('media_cv');
        $data = [
            "job_id"=>$validate['job_id'],
            "email"=>$validate['email'],
            "phone" =>$validate['phone'],
        ];
        $result = $this->job_application_repository->applyWithUploadedCV($user, $data, $media);
        return response()->json([
            $result
        ],200);
    }
}