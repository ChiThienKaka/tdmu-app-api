<?php

namespace App\Features\Domain\RecruiterDashboard\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_name'     => ['sometimes', 'string', 'max:255'],
            'company_address'  => ['sometimes', 'string', 'max:500'],
            'company_phone'    => ['sometimes', 'string', 'max:20'],
            'company_email'    => ['sometimes', 'email', 'max:255'],
            'company_size'     => ['sometimes', 'string', 'max:50'],
            'company_industry' => ['sometimes', 'string', 'max:100'],
            'company_url'      => ['sometimes', 'nullable', 'url', 'max:255'],
            // Không cho phép thay đổi: company_tax_code, verification_status, user_id
        ];
    }

    public function messages(): array
    {
        return [
            'company_email.email' => 'Email công ty không đúng định dạng.',
            'company_url.url'     => 'Địa chỉ website không đúng định dạng URL.',
        ];
    }
}
