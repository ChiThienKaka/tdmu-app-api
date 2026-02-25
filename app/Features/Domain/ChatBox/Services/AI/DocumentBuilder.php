<?php

namespace App\Features\Domain\ChatBox\Services\AI;

use App\Features\Domain\JobPostings\Models\JobPostModel;

class DocumentBuilder
{
    public function buildJob(JobPostModel $job): string
    {
        return trim("
            Mã bài tuyển dụng: {$job->job_id}
            Tên công việc: {$job->job_title}
            Mô tả công việc: {$job->job_description}
            Yêu cầu ứng viên: {$job->requirements}
            Quyền lợi, đãi ngộ: {$job->benefits}
            Lương tối thiểu: {$job->salary_min}
            Lương tối đa: {$job->salary_max}
            Loại hình làm việc: {$job->job_type}
            Cấp bậc kinh nghiệm: {$job->experience_level}
            Chế độ làm việc: {$job->work_mode}
            Tỉnh / Thành phố: {$job->location_province}
            Quận / Huyện: {$job->location_district}
            Hạn nộp hồ sơ: {$job->application_deadline}
            Địa chỉ chi tiết: {$job->location_address}
            Tên công ty: {$job->company_name}
            Link hình ảnh công ty: {$job->company_url}
        ");
    }
}