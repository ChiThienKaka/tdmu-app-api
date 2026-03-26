<?php
namespace App\Features\Domain\RecruiterDashboard\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Features\Domain\JobPostings\Models\JobPostModel;
use App\Features\Domain\JobApplication\Models\JobApplicationModel;
use App\Features\Domain\Recruitment\Subscriptions\Models\RecruiterSubscriptionModel;
use App\Models\User;
class JobApplicationSeeder extends Seeder
{
    public function run(): void
    {
       
       $job_posts = JobPostModel::query()->get();
       $users = User::where('role_id', 2)->get();
    //    //lây từ RecruiterSubscriptionModel
    //    $users = RecruiterSubscriptionModel::with([
    //         'recruiter:user_id,full_name,email'
    //   ])->get();
       foreach ($job_posts as $job) {
            // Lấy ra một danh sách gồm 5 user ngẫu nhiên
            $randomUsers = $users->random(5);
            foreach ($randomUsers as $user) {
                // Xử lý với từng user trong nhóm 5 người này
                JobApplicationModel::create([
                    'job_id'           => $job->job_id, // Giả sử khóa chính là id
                    'user_id'          => $user->user_id,
                    'full_name'        => $user->full_name,
                    'email'            => $user->email,
                    'phone'            => $user->phone ?? '0123456789',
                    'cv_url'           => 'https://tuyensinh.tdmu.edu.vn/img/ckeditor/files/GIAODUCHOC.pdf',
                    'applied_at'       => now(),
                    'updated_at'       => now(),
                    // Các trường khác bạn có thể để null hoặc gán giá trị mặc định
                ]);
            }
       }
    }
}
