<?php

namespace App\Features\Domain\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GoogleLoginRequest extends FormRequest
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
}
