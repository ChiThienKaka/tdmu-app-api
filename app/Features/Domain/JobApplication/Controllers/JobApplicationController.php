<?php
namespace App\Features\Domain\JobApplication\Controllers;
use App\Http\Controllers\Controller;
use App\Features\Domain\JobApplication\Repositories\JobApplicationRepository;
use App\Features\Domain\JobApplication\Requests\JobApplicationRequests;
use Illuminate\Foundation\Http\FormRequest;

class JobApplicationController extends Controller
{
    public function __construct(
        private JobApplicationRepository $job_application_repository
    ){}
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