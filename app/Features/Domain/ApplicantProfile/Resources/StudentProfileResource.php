<?php

namespace App\Features\Domain\ApplicantProfile\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->user_id,

            'student_code' => $this->student_code,
            'university' => $this->university,
            'major' => $this->major,
            'graduation_year' => $this->graduation_year,
            'gpa' => $this->gpa,

            'cv_default_url' => $this->cv_default_url,
            'linkedin_url' => $this->linkedin_url,
            'github_url' => $this->github_url,
            'portfolio_url' => $this->portfolio_url,

            'bio' => $this->bio,
            'career_goals' => $this->career_goals,

            'expected_salary_min' => $this->expected_salary_min,
            'expected_salary_max' => $this->expected_salary_max,

            'preferred_job_type' => $this->preferred_job_type,
            'preferred_location' => $this->preferred_location,

            // 'is_public' => $this->is_public,

            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
        ];
    }
}
