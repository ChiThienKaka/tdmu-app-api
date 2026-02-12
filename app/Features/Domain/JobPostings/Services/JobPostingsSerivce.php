<?php
namespace App\Features\Domain\JobPostings\Services;
use App\Features\Domain\JobPostings\Models\JobPostModel;
use App\Features\Domain\JobPostings\Models\JobPostSkillModel;

class JobPostingsSerivce
{

    public function __construct()
    {
    }
    // lấy thông tin bài post 
    public function getStoreJobPost(int $perPage = 10)
    {
        $jobs = JobPostModel::select('job_posts.*'
                    ,'rc.company_name', 'rc.company_url'
                )
                ->join('recruiter_subscriptions as rs', 'rs.subscription_id', '=', 'job_posts.subscription_id')
                ->join('recruiter_packages as rp', 'rp.package_id', '=', 'rs.package_id')
                ->join('recruiter_companies as rc', 'rc.company_id', '=', 'rs.company_id')
                ->where('job_posts.status', 'approved')
                ->where('rs.status', 'active')
                ->whereDate('rs.end_date', '>=', now()->startOfDay())// ép về ngày để dễ so sánh
                ->orderByRaw("
                    CASE 
                        WHEN rp.support_priority = 'vip' THEN 1
                        WHEN rp.support_priority = 'priority' THEN 2
                        ELSE 3
                    END
                ")
                ->orderByDesc('job_posts.priority_level')// bảng ưu tiên của từng bày post
                ->orderByDesc('job_posts.published_at') //ngày công khai tin tuyển dụng
                ->paginate($perPage);
                
        return $jobs;
    }
    // lấy thông tin chi tiết
    public function getListDetailJobPost(int $job_id){
        $jobpost = JobPostModel::with('company')->findOrFail($job_id);
        $jobskill = JobPostSkillModel::with('skill')->where('job_id',$job_id)->get();
        return [
            'jobpost' => $jobpost,
            'jobskill' => $jobskill
        ];
    }
}