<?php
namespace App\Features\Domain\JobApplication\Repositories;
use App\Features\Domain\JobApplication\Models\JobApplicationModel;
use App\Features\Domain\JobApplication\Models\ApplicationTimelineModel;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class ApplicationTimelineRepository {
    public function __construct()
    {
    }
    public function updateStatusApplicationTimeline($application_id, $newStatus, $user)
    {
        return DB::transaction(function () use ($application_id, $newStatus, $user) {

            $application = JobApplicationModel::findOrFail($application_id);
            $old_status = $application->status;
            if ($old_status === $newStatus) {
                throw ValidationException::withMessages([
                    'message' => 'Tình trạng không thay đổi.'
                ]);
            }
            $application->update([
                'status' => $newStatus
            ]);

           $application->timelines()->create([
                'changed_by' => $user->user_id,
                'old_status' => $old_status,
                'new_status' => $newStatus,
            ]);
            
            return $application->fresh();
        });
    }

}