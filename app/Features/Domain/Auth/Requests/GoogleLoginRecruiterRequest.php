<?php

namespace App\Features\Domain\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GoogleLoginRecruiterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'google_id' => ['required', 'string'],
            'email' => ['required', 'email:rfc,dns'],
            'name' => ['required', 'string', 'max:255'],
            'picture' => ['nullable', 'string', 'url'],
        ];
    }

    public function messages(): array
    {
        return [
            'google_id.required' => 'Google ID là bắt buộc',
            'email.required' => 'Email là bắt buộc',
            'email.email' => 'Email không hợp lệ',
            'name.required' => 'Tên là bắt buộc',
            'picture.url' => 'Hình ảnh phải là URL hợp lệ',
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $blockedDomains = [
                'edu.vn',
                'student.tdmu.edu.vn',
                'student.hust.edu.vn',
                'sv.uit.edu.vn',
            ];

            $email = $this->input('email');
            $domain = substr(strrchr($email, '@'), 1);

            if (in_array($domain, $blockedDomains)) {
                $validator->errors()->add(
                    'email',
                    'Email trường học không được dùng để đăng ký tài khoản tuyển dụng'
                );
            }
        });
    }
}
