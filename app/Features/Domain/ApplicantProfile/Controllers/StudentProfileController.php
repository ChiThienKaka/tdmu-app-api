<?php
namespace App\Features\Domain\ApplicantProfile\Controllers;
use App\Http\Controllers\Controller;
use App\Features\Domain\ApplicantProfile\Repositories\StudentProfileRepository;
use App\Features\Domain\ApplicantProfile\Resources\StudentProfileResource;
use App\Features\Domain\ApplicantProfile\Requests\StudentProfileRequest;
use App\Features\Domain\ApplicantProfile\DTOs\StudentProfileDTO;

class StudentProfileController extends Controller {
    public function __construct(private StudentProfileRepository $repositoryStudentProfile)
    {
    }
    public function getStudentProfile(){
        $user = auth('api')->user();
        $result = $this->repositoryStudentProfile->findStudentProfileByUser($user);
        return response()->json([
            new StudentProfileResource($result)
        ],200);
    }
    public function updateStudentProfile(StudentProfileRequest $request){
        $user = auth('api')->user();
        $dto = StudentProfileDTO::fromArray($request->validated());
        $media = $request->file('media');
        $result = $this->repositoryStudentProfile->updateStudentProfileByUser($user,$dto->toArray(),$media);
        return  response()->json([
            $result
        ],200);
    }
}