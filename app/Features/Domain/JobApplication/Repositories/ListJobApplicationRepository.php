<?php
namespace App\Features\Domain\JobApplication\Repositories;
use App\Features\Domain\JobApplication\Models\JobApplicationModel;
use App\Features\Domain\JobPostings\Models\JobPostModel;
use Illuminate\Validation\ValidationException;
use App\Features\Domain\JobApplication\Repositories\ApplicationTimelineRepository;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ListJobApplicationRepository {
    public function __construct(private ApplicationTimelineRepository $applicationTimeline)
    {

    }
    public function listApplicant(int $job_id, int $perPage = 10){
        JobPostModel::findOrFail($job_id);
        return JobApplicationModel::with('applicant')
            ->where('job_id', $job_id)
            ->paginate($perPage);
    }
    // cập nhật trạng thái của các bài ứng tuyển của ứng viên 
    public function updateApplicant(int $application_id, string $new_status, User $user){
        $application = JobApplicationModel::find($application_id);
        if (!$application) {
            throw ValidationException::withMessages([
                    'message' => 'application này không tồn tại.'
            ]);
        }
        DB::transaction(function () use ($application, $new_status, $user, $application_id) {
            $this->applicationTimeline
                ->updateStatusApplicationTimeline(
                    $application_id,
                    $new_status,
                    $user
                );
            if (!$application->update([
                'status' => $new_status
            ])) {
                throw ValidationException::withMessages([
                    'message' => 'update không thành công.'
                ]);
            }
        });
        return $application;
    }
}