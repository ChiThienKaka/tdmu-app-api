<?php

namespace App\Features\Domain\RecruiterDashboard\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApplicationStatusRequest extends FormRequest
{
    public const VALID_STATUSES = [
        'reviewed',
        'shortlisted',
        'interviewed',
        'offered',
        'accepted',
        'rejected',
        'withdrawn',
    ];

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status'           => ['required', 'string', 'in:' . implode(',', self::VALID_STATUSES)],
            'note'             => ['sometimes', 'nullable', 'string', 'max:1000'],
            'rejection_reason' => ['required_if:status,rejected', 'nullable', 'string', 'max:1000'],
            'rating'           => ['sometimes', 'nullable', 'integer', 'min:1', 'max:5'],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required'              => 'Trạng thái là bắt buộc.',
            'status.in'                    => 'Trạng thái không hợp lệ. Chấp nhận: ' . implode(', ', self::VALID_STATUSES),
            'rejection_reason.required_if' => 'Lý do từ chối là bắt buộc khi trạng thái là "rejected".',
        ];
    }
}
