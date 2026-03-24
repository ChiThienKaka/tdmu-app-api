<?php

namespace App\Features\Domain\RecruiterDashboard\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RecruiterCompanyResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'company_id'          => $this->company_id,
            'company_name'        => $this->company_name,
            'company_tax_code'    => $this->company_tax_code,
            'company_address'     => $this->company_address,
            'company_phone'       => $this->company_phone,
            'company_email'       => $this->company_email,
            'company_size'        => $this->company_size,
            'company_industry'    => $this->company_industry,
            'company_url'         => $this->company_url,
            'verification_status' => $this->verification_status,
            'created_at'          => $this->created_at,
            'updated_at'          => $this->updated_at,
        ];
    }
}
