<?php

namespace App\Features\Domain\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class RegisterRecruiterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email:rfc,dns', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Tên là bắt buộc',
            'name.string' => 'Tên phải là chuỗi ký tự',
            'name.max' => 'Tên không được vượt quá 255 ký tự',
            'email.required' => 'Email là bắt buộc',
            'email.email' => 'Email không hợp lệ',
            'email.unique' => 'Email đã tồn tại trong hệ thống',
            'password.required' => 'Mật khẩu là bắt buộc',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
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
