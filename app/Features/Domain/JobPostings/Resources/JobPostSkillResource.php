<?php

namespace App\Features\Domain\JobPostings\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobPostSkillResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "skill_id" => $this->skill_id,
            "is_required" => $this->is_required,
            "proficiency_level"=> $this->proficiency_level,
            "skill_name"=> $this->skill->skill_name,
            "skill_category"=> $this->skill->skill_category,
        ];
    }
}