<?php

namespace App\Features\Domain\Recruitment\Companies\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RecruiterCompanyResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'company_id' => $this->company_id,
            'name' => $this->name,
            'logo' => $this->logo,
            'website' => $this->website,
            'address' => $this->address,
            'description' => $this->description,
            'is_verified' => (bool) $this->is_verified,
        ];
    }
}
