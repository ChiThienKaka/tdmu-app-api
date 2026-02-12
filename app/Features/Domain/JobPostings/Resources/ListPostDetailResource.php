<?php

namespace App\Features\Domain\JobPostings\Resources;
use App\Features\Domain\JobPostings\Resources\JobPostSkillResource;

use Illuminate\Http\Resources\Json\JsonResource;

class ListPostDetailResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "jobpost" => new JobPostResource($this['jobpost']),
            "jobskill" => JobPostSkillResource::collection($this['jobskill'])
        ];
    }
}