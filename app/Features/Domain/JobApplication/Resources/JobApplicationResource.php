<?php

namespace App\Features\Domain\JobApplication\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Features\Domain\JobApplication\Resources\ApplicantUserResource;

class JobApplicationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'application_id' => $this->application_id,
            'job_id' => $this->job_id,
            // 'user_id' => $this->user_id,

            // 'reviewed_by' => $this->reviewed_by,

            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone' => $this->phone,

            'cv_url' => $this->cv_url,
            'cover_letter' => $this->cover_letter,

            'status' => $this->status,

            'note' => $this->note,
            'rating' => $this->rating,
            'rejection_reason' => $this->rejection_reason,

            'interview_schedule' => $this->interview_schedule,
            'interview_location' => $this->interview_location,
            'interview_status' => $this->interview_status,

            'reviewed_at' => $this->reviewed_at,

            'applied_at' => $this->applied_at,
            'updated_at' => $this->updated_at,
            'applicant' => ApplicantUserResource::make($this->applicant),
        ];
    }
}
