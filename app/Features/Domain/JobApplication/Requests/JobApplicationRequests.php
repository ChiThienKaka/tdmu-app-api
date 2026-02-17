<?php
namespace App\Features\Domain\JobApplication\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobApplicationRequests extends FormRequest{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:255'],
            'job_id' => ['required', 'integer','exists:job_posts,job_id'],
            'phone' => ['required', 'string', 'max:10'],
            'media_cv' => [
                'required',
                'file',
                'mimes:pdf,doc,docx',
                'max:5120'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            //kiểm tra job_id
            'job_id.required' => 'Vui lòng chọn vị trí ứng tuyển.',
            'job_id.integer'  => 'Mã tin tuyển dụng không hợp lệ.',
            'job_id.exists'   => 'Tin tuyển dụng không tồn tại hoặc đã bị xóa.',
            // ===== Email =====
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'email.max' => 'Email không được vượt quá 255 ký tự.',

            // ===== Phone =====
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.string' => 'Số điện thoại không hợp lệ.',
            'phone.max' => 'Số điện thoại không được vượt quá 10 ký tự.',

            // ===== CV =====
            'media_cv.required' => 'Vui lòng tải lên CV.',
            'media_cv.file' => 'CV phải là một tệp hợp lệ.',
            'media_cv.mimes' => 'CV chỉ chấp nhận định dạng PDF, DOC hoặc DOCX.',
            'media_cv.max' => 'Dung lượng CV không được vượt quá 5MB.',
        ];
    }

}