<?php

return [

/*
|--------------------------------------------------------------------------
| JOB SEARCH DOMAIN
|--------------------------------------------------------------------------
*/

[
    'intent' => 'search_remote_job',
    'domain' => 'job_search',
    'question' => 'Tôi tìm việc IT remote như thế nào?',
    'table' => 'job_posts',
    'examples' => [
        'tìm job IT remote',
        'việc IT làm từ xa',
        'job backend remote',
        'việc online IT'
    ]
],

[
    'intent' => 'internship_jobs',
    'domain' => 'job_search',
    'question' => 'Có công việc thực tập nào cho sinh viên không?',
    'table' => 'job_posts',
    'examples' => [
        'job thực tập',
        'việc cho sinh viên',
        'thực tập IT',
        'intern IT'
    ]
],

[
    'intent' => 'job_requirements',
    'domain' => 'job_search',
    'question' => 'Công việc này yêu cầu kỹ năng gì?',
    'table' => 'job_posts',
    'examples' => [
        'job cần kỹ năng gì',
        'yêu cầu công việc',
        'skill cần có'
    ]
],

/*
|--------------------------------------------------------------------------
| APPLICATION DOMAIN
|--------------------------------------------------------------------------
*/

[
    'intent' => 'my_applications',
    'domain' => 'application',
    'question' => 'Tôi đã nộp hồ sơ vào những công việc nào?',
    'table' => 'job_applications',
    'examples' => [
        'tôi apply job nào rồi',
        'danh sách hồ sơ đã gửi',
        'các job đã ứng tuyển'
    ]
],

[
    'intent' => 'application_status',
    'domain' => 'application',
    'question' => 'Hồ sơ của tôi đang ở trạng thái nào?',
    'table' => 'application_timeline',
    'examples' => [
        'trạng thái hồ sơ',
        'apply tới đâu rồi',
        'hồ sơ đang xử lý thế nào'
    ]
],

[
    'intent' => 'withdraw_application',
    'domain' => 'application',
    'question' => 'Tôi có thể hủy hồ sơ ứng tuyển không?',
    'table' => 'job_applications',
    'examples' => [
        'hủy hồ sơ',
        'rút đơn ứng tuyển',
        'cancel apply'
    ]
],

/*
|--------------------------------------------------------------------------
| PROFILE DOMAIN
|--------------------------------------------------------------------------
*/

[
    'intent' => 'view_profile',
    'domain' => 'profile',
    'question' => 'Tôi xem hồ sơ cá nhân ở đâu?',
    'table' => 'student_profiles',
    'examples' => [
        'xem profile',
        'hồ sơ của tôi',
        'thông tin cá nhân'
    ]
],

[
    'intent' => 'update_skills',
    'domain' => 'profile',
    'question' => 'Tôi có thể cập nhật kỹ năng không?',
    'table' => 'student_skills',
    'examples' => [
        'thêm kỹ năng',
        'update skill',
        'chỉnh sửa kỹ năng'
    ]
],

/*
|--------------------------------------------------------------------------
| SAVED JOBS DOMAIN
|--------------------------------------------------------------------------
*/

[
    'intent' => 'saved_jobs',
    'domain' => 'interaction',
    'question' => 'Tôi đã lưu những công việc nào?',
    'table' => 'saved_jobs',
    'examples' => [
        'job đã lưu',
        'danh sách việc lưu',
        'việc yêu thích'
    ]
],

/*
|--------------------------------------------------------------------------
| COMPANY DOMAIN
|--------------------------------------------------------------------------
*/

[
    'intent' => 'company_reviews',
    'domain' => 'company',
    'question' => 'Công ty này được đánh giá thế nào?',
    'table' => 'company_reviews',
    'examples' => [
        'review công ty',
        'đánh giá doanh nghiệp',
        'công ty có tốt không'
    ]
],

[
    'intent' => 'company_info',
    'domain' => 'company',
    'question' => 'Thông tin công ty này là gì?',
    'table' => 'recruiter_companies',
    'examples' => [
        'giới thiệu công ty',
        'thông tin doanh nghiệp',
        'company profile'
    ]
],

/*
|--------------------------------------------------------------------------
| NOTIFICATION DOMAIN
|--------------------------------------------------------------------------
*/

[
    'intent' => 'interview_notification',
    'domain' => 'notification',
    'question' => 'Tôi có lịch phỏng vấn chưa?',
    'table' => 'student_notifications',
    'examples' => [
        'lịch phỏng vấn',
        'có thông báo gì không',
        'interview schedule'
    ]
],

[
    'intent' => 'general_notifications',
    'domain' => 'notification',
    'question' => 'Tôi có thông báo mới không?',
    'table' => 'student_notifications',
    'examples' => [
        'có thông báo gì',
        'notification mới',
        'tin nhắn hệ thống'
    ]
],
/*
|--------------------------------------------------------------------------
| JOB SEARCH EXPANDED
|--------------------------------------------------------------------------
*/

[
'intent' => 'job_match',
'domain' => 'job_search',
'question' => 'Công việc này có phù hợp với tôi không?',
'table' => 'job_posts',
'examples' => [
    'job này hợp tôi không',
    'có nên apply job này',
    'việc này phù hợp không'
]
],

[
'intent' => 'job_salary',
'domain' => 'job_search',
'question' => 'Mức lương của công việc này là bao nhiêu?',
'table' => 'job_posts',
'examples' => [
    'job lương bao nhiêu',
    'salary job này',
    'thu nhập công việc'
]
],

[
'intent' => 'job_expired',
'domain' => 'job_search',
'question' => 'Công việc này còn tuyển không?',
'table' => 'job_posts',
'examples' => [
    'job còn hạn không',
    'việc còn tuyển không',
    'deadline apply'
]
],

/*
|--------------------------------------------------------------------------
| APPLICATION EXPANDED
|--------------------------------------------------------------------------
*/

[
'intent' => 'application_rejected',
'domain' => 'application',
'question' => 'Nếu hồ sơ bị từ chối thì sao?',
'table' => 'job_applications',
'examples' => [
    'hồ sơ bị reject',
    'trượt tuyển dụng',
    'không được nhận thì sao'
]
],

[
'intent' => 'edit_application',
'domain' => 'application',
'question' => 'Tôi có thể sửa hồ sơ sau khi nộp không?',
'table' => 'job_applications',
'examples' => [
    'sửa hồ sơ apply',
    'update đơn ứng tuyển',
    'chỉnh CV đã gửi'
]
],

[
'intent' => 'duplicate_application',
'domain' => 'application',
'question' => 'Tôi có thể nộp hồ sơ nhiều lần không?',
'table' => 'job_applications',
'examples' => [
    'apply lại job',
    'nộp nhiều lần được không',
    'submit lại hồ sơ'
]
],

/*
|--------------------------------------------------------------------------
| PROFILE EXPANDED
|--------------------------------------------------------------------------
*/

[
'intent' => 'profile_completion',
'domain' => 'profile',
'question' => 'Hồ sơ của tôi đã đầy đủ chưa?',
'table' => 'student_profiles',
'examples' => [
    'profile đủ chưa',
    'thiếu thông tin gì',
    'hồ sơ hoàn chỉnh chưa'
]
],

[
'intent' => 'cv_visibility',
'domain' => 'profile',
'question' => 'Nhà tuyển dụng có xem được CV của tôi không?',
'table' => 'student_profiles',
'examples' => [
    'recruiter thấy CV không',
    'CV có public không',
    'ai xem hồ sơ tôi'
]
],

/*
|--------------------------------------------------------------------------
| SAVED / TRACKING
|--------------------------------------------------------------------------
*/

[
'intent' => 'saved_job_status',
'domain' => 'interaction',
'question' => 'Công việc tôi lưu còn tuyển không?',
'table' => 'saved_jobs',
'examples' => [
    'job lưu còn hạn không',
    'việc saved còn tuyển',
    'saved job expired'
]
],

/*
|--------------------------------------------------------------------------
| COMPANY EXPANDED
|--------------------------------------------------------------------------
*/

[
'intent' => 'company_legit',
'domain' => 'company',
'question' => 'Công ty này có uy tín không?',
'table' => 'company_reviews',
'examples' => [
    'công ty có scam không',
    'doanh nghiệp uy tín',
    'review công ty'
]
],

/*
|--------------------------------------------------------------------------
| NOTIFICATION / STATUS
|--------------------------------------------------------------------------
*/

[
'intent' => 'response_wait_time',
'domain' => 'notification',
'question' => 'Bao lâu thì tôi nhận được phản hồi?',
'table' => 'student_notifications',
'examples' => [
    'khi nào có kết quả',
    'đợi phản hồi bao lâu',
    'apply bao lâu có tin'
]
],

];