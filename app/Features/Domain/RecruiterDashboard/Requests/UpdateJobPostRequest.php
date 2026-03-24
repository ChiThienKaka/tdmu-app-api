<?php

namespace App\Features\Domain\RecruiterDashboard\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id'          => ['sometimes', 'integer'],
            'job_title'            => ['sometimes', 'string', 'max:255'],
            'job_description'      => ['sometimes', 'string'],
            'requirements'         => ['sometimes', 'string'],
            'benefits'             => ['sometimes', 'string'],
            'salary_min'           => ['sometimes', 'numeric', 'min:0'],
            'salary_max'           => ['sometimes', 'numeric', 'min:0'],
            'salary_type'          => ['sometimes', 'string', 'in:fixed,negotiable,range'],
            'job_type'             => ['sometimes', 'string', 'in:full_time,part_time,contract,internship,freelance'],
            'experience_level'     => ['sometimes', 'string'],
            'education_level'      => ['sometimes', 'string'],
            'number_of_positions'  => ['sometimes', 'integer', 'min:1'],
            'work_mode'            => ['sometimes', 'string', 'in:onsite,remote,hybrid'],
            'gender_requirement'   => ['sometimes', 'string', 'in:any,male,female'],
            'location_province'    => ['sometimes', 'string', 'max:100'],
            'location_district'    => ['sometimes', 'string', 'max:100'],
            'location_address'     => ['sometimes', 'string', 'max:255'],
            'application_deadline' => ['sometimes', 'date', 'after:today'],
            'contact_email'        => ['sometimes', 'email', 'max:255'],
            'contact_phone'        => ['sometimes', 'string', 'max:20'],
            'contact_person'       => ['sometimes', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'application_deadline.after' => 'Hạn nộp hồ sơ phải sau ngày hôm nay.',
        ];
    }
}
