<?php

namespace App\Features\Domain\Recruitment\Companies\DTOs;


class RecruiterCompanyDTO
{
    public function __construct(
        public string $company_name,
        public string $company_tax_code,
        public string $company_address,
        public string $company_phone,
        public string $company_email,
        public ?string $company_website,
        public ?string $company_size,
        public ?string $company_industry,
        public ?string $company_description,
    ) {}

    public function toArray(): array
    {
        return [
            'company_name' => $this->company_name,
            'company_tax_code' => $this->company_tax_code,
            'company_address' => $this->company_address,
            'company_phone' => $this->company_phone,
            'company_email' => $this->company_email,
            'company_website' => $this->company_website,
            'company_size' => $this->company_size,
            'company_industry' => $this->company_industry,
            'company_description' => $this->company_description,
        ];
    }
    public static function fromArray(array $data): self
    {
        return new self(
            company_name: $data['company_name'],
            company_tax_code: $data['company_tax_code'],
            company_address: $data['company_address'],
            company_phone: $data['company_phone'],
            company_email: $data['company_email'],
            company_website: $data['company_website'] ?? null,
            company_size: $data['company_size'] ?? null,
            company_industry: $data['company_industry'] ?? null,
            company_description: $data['company_description'] ?? null,
        );
    }
}
