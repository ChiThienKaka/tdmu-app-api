<?php

namespace App\Features\Domain\RecruiterDashboard\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RecruiterJobPostResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'job_id'               => $this->job_id,
            'job_title'            => $this->job_title,
            'slug'                 => $this->slug,
            'job_description'      => $this->job_description,
            'requirements'         => $this->requirements,
            'benefits'             => $this->benefits,
            'salary_min'           => $this->salary_min,
            'salary_max'           => $this->salary_max,
            'salary_type'          => $this->salary_type,
            'job_type'             => $this->job_type,
            'experience_level'     => $this->experience_level,
            'education_level'      => $this->education_level,
            'number_of_positions'  => $this->number_of_positions,
            'work_mode'            => $this->work_mode,
            'gender_requirement'   => $this->gender_requirement,
            'location_province'    => $this->location_province,
            'location_district'    => $this->location_district,
            'location_address'     => $this->location_address,
            'application_deadline' => $this->application_deadline,
            'contact_email'        => $this->contact_email,
            'contact_phone'        => $this->contact_phone,
            'contact_person'       => $this->contact_person,
            'is_featured'          => $this->is_featured,
            'status'               => $this->status,
            'rejection_reason'     => $this->rejection_reason,
            'view_count'           => $this->view_count,
            'application_count'    => $this->application_count,
            'last_refreshed_at'    => $this->last_refreshed_at,
            'published_at'         => $this->published_at,
            'created_at'           => $this->created_at,
            'updated_at'           => $this->updated_at,
            'category'             => $this->whenLoaded('category', fn() => [
                'category_id'   => $this->category->category_id ?? null,
                'category_name' => $this->category->category_name ?? null,
            ]),
        ];
    }
}
