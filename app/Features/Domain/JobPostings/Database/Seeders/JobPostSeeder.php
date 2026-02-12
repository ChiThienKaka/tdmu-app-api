<?php
namespace App\Features\Domain\JobPostings\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Features\Domain\JobPostings\Models\JobCategoryModel;
use App\Features\Domain\JobPostings\Models\JobPostModel;
use App\Features\Domain\JobPostings\Models\JobSkillModel;
use App\Features\Domain\Recruitment\Subscriptions\Models\RecruiterSubscriptionModel;
use App\Features\Domain\JobPostings\Models\JobPostSkillModel;
use App\Features\Domain\JobPostings\Models\JobPostViewModel;
use App\Models\User;
use Illuminate\Support\Arr;


class JobPostSeeder extends Seeder
{
    public function run(): void
    {
        $datas = collect( require app_path(
            'Features/Domain/JobPostings/Database/Seeders/data/post_fake/datapost.php'
        ));
        $levels = [
            'beginner',
            'intermediate',
            'advanced',
            'expert'
        ];
        $users = User::whereIn('role_id', [2, 3])->get();
        $jobSkills = JobSkillModel::pluck('skill_id');
        $categoryParent = JobCategoryModel::where('parent_id',null)->get();
        $subscription_recruiters = RecruiterSubscriptionModel::get();
        // tạo post theo categroy
        foreach($categoryParent as $category){
            foreach($datas[$category->category_slug] as $post){
                $subscription = $subscription_recruiters->random();
                $jobpost = JobPostModel::create([
                    'subscription_id' => $subscription->subscription_id,
                    'user_id' => $subscription->user_id,
                    'company_id'=>$subscription->company_id,
                    'category_id' => $category->category_id,
                    'job_title' => $post['job_title'],
                    'slug' => $post['slug'],
                    'job_description' => $post['job_description'],
                    'requirements' => $post['requirements'],
                    'benefits' => $post['benefits'],
                    'salary_min' => $post['salary_min'],
                    'salary_max' => $post['salary_max'],
                    'location_province' => $post['location_province'],
                    'location_district' => $post['location_district'],
                    'location_address' => $post['location_address'],
                    'application_deadline' => $post['application_deadline'],
                    'contact_email' => $post['contact_email'],
                    'contact_phone' => $post['contact_phone'],
                    'contact_person' => $post['contact_person'],
                    'status' => 'approved',
                ]);
                // radom 5 kỹ năng theo post 
                $jobskills_random = $jobSkills->random(5);
                foreach($jobskills_random as $job_skill){
                    JobPostSkillModel::create([
                        'job_id' => $jobpost->job_id,
                        'skill_id' => $job_skill,
                        'proficiency_level' => Arr::random($levels)
                    ]);
                }
                //// tạo view user, mỗi user có 1 lần xem post này
                foreach($users as $user){
                    JobPostViewModel::create([
                        'job_id' => $jobpost->job_id,
                        'user_id' => $user->user_id,
                    ]);
                };
            };
        };
    }
}
