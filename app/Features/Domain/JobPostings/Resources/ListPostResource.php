<?php

namespace App\Features\Domain\JobPostings\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ListPostResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "job_id" => $this->job_id ,
            "job_title"=> $this->job_title ,
            "job_description"=> $this->job_description ,
            "requirements"=> $this->requirements ,
            "benefits"=> $this->benefits ,
            "salary_min"=> $this->salary_min ,
            "salary_max"=> $this->salary_max ,
            "job_type"=> $this->job_type ,
            "experience_level"=> $this->experience_level ,
            "work_mode"=> $this->work_mode ,
            "location_province"=> $this->location_province ,
            "location_district"=> $this->location_district ,
            "location_address"=> $this->location_address ,
            "application_deadline"=> $this->application_deadline ,
            "contact_email"=> $this->contact_email ,
            "contact_phone"=> $this->contact_phone ,
            "contact_person"=> $this->contact_person ,
            "published_at"=> $this->published_at ,
            "created_at"=> $this->created_at ,
            "company_name"=> $this->whenNotNull($this->company_name),
            "company_url"=> $this->whenNotNull($this->company_url),
        ];
    }
}