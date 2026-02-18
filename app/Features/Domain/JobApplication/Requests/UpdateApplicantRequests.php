<?php
namespace App\Features\Domain\JobApplication\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateApplicantRequests extends FormRequest{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'application_id' => ['required', 'integer', 'exists:job_applications,application_id'],
            'status' => [
                'required',
                'string',
                Rule::in([
                    'pending',
                    'reviewed',
                    'shortlisted',
                    'interviewed',
                    'offered',
                    'accepted',
                    'rejected',
                    'withdrawn',
                ]),
            ],
        ];
    }

   public function messages(): array
    {
        return [
            // application_id
            'application_id.required' => 'Bạn phải cung cấp application_id.',
            'application_id.integer'  => 'application_id phải là số nguyên.',
            'application_id.exists'   => 'Application không tồn tại.',

            // status
            'status.required' => 'Bạn phải cung cấp trạng thái.',
            'status.string'   => 'Trạng thái phải là chuỗi.',
            'status.in'       => 'Trạng thái không hợp lệ. Các trạng thái cho phép: pending, reviewed, shortlisted, interviewed, offered, accepted, rejected, withdrawn.',
        ];
    }
}