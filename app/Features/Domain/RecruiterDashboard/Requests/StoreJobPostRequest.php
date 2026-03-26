<?php

namespace App\Features\Domain\RecruiterDashboard\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['sometimes', 'integer'],
            'job_title' => ['required', 'string', 'max:255'],
            'job_description' => ['required', 'string'],
            'requirements' => ['sometimes', 'string'],
            'benefits' => ['sometimes', 'string'],
            'salary_min' => ['sometimes', 'numeric', 'min:0'],
            'salary_max' => ['sometimes', 'numeric', 'min:0', 'gte:salary_min'],
            'salary_type' => ['sometimes', 'string', 'in:fixed,negotiable,range'],
            'job_type' => ['string', 'in:full_time,part_time,contract,internship,freelance'],
            'experience_level' => ['sometimes', 'string'],
            'education_level' => ['sometimes', 'string'],
            'number_of_positions' => ['sometimes', 'integer', 'min:1'],
            'work_mode' => ['sometimes', 'string', 'in:onsite,remote,hybrid'],
            'gender_requirement' => ['sometimes', 'string', 'in:any,male,female'],
            'location_province' => ['required', 'string', 'max:100'],
            'location_district' => ['sometimes', 'string', 'max:100'],
            'location_address' => ['sometimes', 'string', 'max:255'],
            'application_deadline' => ['required', 'date', 'after:today'],
            'contact_email' => ['required', 'email', 'max:255'],
            'contact_phone' => ['sometimes', 'string', 'max:20'],
            'contact_person' => ['sometimes', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'job_title.required' => 'Tiêu đề bài đăng là bắt buộc.',
            'job_description.required' => 'Mô tả công việc là bắt buộc.',
            'job_type.required' => 'Loại công việc là bắt buộc.',
            'location_province.required' => 'Tỉnh/thành phố là bắt buộc.',
            'application_deadline.required' => 'Hạn nộp hồ sơ là bắt buộc.',
            'application_deadline.after' => 'Hạn nộp hồ sơ phải sau ngày hôm nay.',
            'contact_email.required' => 'Email liên hệ là bắt buộc.',
            'salary_max.gte' => 'Lương tối đa phải lớn hơn hoặc bằng lương tối thiểu.',
        ];
    }
}
