<?php

namespace App\Features\Domain\Admin\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminJobPostResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'job_id'              => $this->job_id,
            'job_title'           => $this->job_title,
            'job_type'            => $this->job_type,
            'experience_level'    => $this->experience_level,
            'work_mode'           => $this->work_mode,
            'salary_min'          => $this->salary_min,
            'salary_max'          => $this->salary_max,
            'salary_type'         => $this->salary_type,
            'location_province'   => $this->location_province,
            'location_district'   => $this->location_district,
            'application_deadline'=> $this->application_deadline,
            'status'              => $this->status,
            'rejection_reason'    => $this->rejection_reason,
            'moderated_at'        => $this->moderated_at,
            'created_at'          => $this->created_at,
            'published_at'        => $this->published_at,
            'company'             => $this->whenLoaded('company', fn() => [
                'company_id'   => $this->company?->company_id,
                'company_name' => $this->company?->company_name,
                'company_url'  => $this->company?->company_url,
            ]),
            'recruiter'           => $this->whenLoaded('user', fn() => [
                'user_id' => $this->user?->user_id,
                'name'    => $this->user?->name,
                'email'   => $this->user?->email,
            ]),
        ];
    }
}
