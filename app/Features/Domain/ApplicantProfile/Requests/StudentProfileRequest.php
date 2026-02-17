<?php

namespace App\Features\Domain\ApplicantProfile\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_code' => 'nullable|string|max:50',
            'university' => 'nullable|string|max:255',
            'major' => 'nullable|string|max:100',
            'graduation_year' => 'nullable|integer|min:2000|max:2100',
            'gpa' => 'nullable|numeric|min:0|max:4',

            // 'cv_default_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'portfolio_url' => 'nullable|url',

            'bio' => 'nullable|string',
            'career_goals' => 'nullable|string',

            'expected_salary_min' => 'nullable|numeric|min:0',
            'expected_salary_max' => 'nullable|numeric|min:0',

            'preferred_job_type' => 'nullable|array',
            'preferred_location' => 'nullable|array',

            // 'is_public' => 'boolean',
            // nhận file
            'media' =>  [
                'nullable',
                function ($attr, $value, $fail) {
                    if (is_array($value)) {
                        $fail('Chỉ được upload 1 file PDF.');
                    }
                },
                'file',
                'mimetypes:application/pdf',
            ],

        ];
    }
    public function messages(): array
    {
        return [

            // Academic info
            'student_code.string' => 'Mã sinh viên phải là chuỗi ký tự.',
            'student_code.max' => 'Mã sinh viên không được vượt quá 50 ký tự.',

            'university.string' => 'Tên trường phải là chuỗi ký tự.',
            'university.max' => 'Tên trường không được vượt quá 255 ký tự.',

            'major.string' => 'Chuyên ngành phải là chuỗi ký tự.',
            'major.max' => 'Chuyên ngành không được vượt quá 100 ký tự.',

            'graduation_year.integer' => 'Năm tốt nghiệp phải là số nguyên.',
            'graduation_year.min' => 'Năm tốt nghiệp không hợp lệ.',
            'graduation_year.max' => 'Năm tốt nghiệp không hợp lệ.',

            'gpa.numeric' => 'GPA phải là số.',
            'gpa.min' => 'GPA không được nhỏ hơn 0.',
            'gpa.max' => 'GPA không được lớn hơn 4.',

            // CV & links
            // 'cv_default_url.url' => 'Link CV không hợp lệ.',
            'linkedin_url.url' => 'Link LinkedIn không hợp lệ.',
            'github_url.url' => 'Link GitHub không hợp lệ.',
            'portfolio_url.url' => 'Link portfolio không hợp lệ.',

            // Profile content
            'bio.string' => 'Giới thiệu bản thân phải là chuỗi ký tự.',
            'career_goals.string' => 'Mục tiêu nghề nghiệp phải là chuỗi ký tự.',

            // Salary
            'expected_salary_min.numeric' => 'Mức lương tối thiểu phải là số.',
            'expected_salary_min.min' => 'Mức lương tối thiểu không hợp lệ.',

            'expected_salary_max.numeric' => 'Mức lương tối đa phải là số.',
            'expected_salary_max.min' => 'Mức lương tối đa không hợp lệ.',

            // Preferences
            'preferred_job_type.array' => 'Loại công việc mong muốn không hợp lệ.',
            'preferred_location.array' => 'Địa điểm mong muốn không hợp lệ.',

            // Visibility
            // 'is_public.boolean' => 'Trạng thái hiển thị không hợp lệ.',

            'media.file' => 'Media phải là file hợp lệ.',
            'media.mimes' => 'Chỉ được upload file PDF.',
            'media.max' => 'File PDF tối đa 5MB.',

        ];
    }
}
