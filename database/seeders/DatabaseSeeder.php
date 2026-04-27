<?php

namespace Database\Seeders;

use App\Models\GroupMember;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Features\Domain\Recruitment\Packages\Database\Seeders\RecruiterPackageSeeder;
use App\Features\Domain\JobPostings\Database\Seeders\JobCategorySeeder;
use App\Features\Domain\Recruitment\Companies\Database\Seeders\CompanySeeder;
use App\Features\Domain\Recruitment\Subscriptions\Database\Seeders\RecruiterSubscriptionSeeder;
use App\Features\Domain\JobPostings\Database\Seeders\JobPostSeeder;
use App\Features\Domain\ChatBox\Database\Seeders\ChatBoxSeeder;
use App\Features\Domain\ChatBox\Database\Seeders\EmbeddingDataSeeder;
use App\Features\Domain\RecruiterDashboard\Database\Seeders\JobApplicationSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(FacultySeeder::class);
        $this->call(MajorSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PostSeeder::class);
        $this->call(GroupSeeder::class);
        $this->call(GroupMemberSeeder::class);
        $this->call(GroupMessageSeeder::class);
        
        //Recruiter Package Seeder
        $this->call(RecruiterPackageSeeder::class);
        $this->call(JobCategorySeeder::class);
        $this->call(CompanySeeder::class);
        //Tạo các gói đăng ký
         $this->call(RecruiterSubscriptionSeeder::class);
         // Tạo thông tin bài post
         $this->call(JobPostSeeder::class);

        //  chatbox ai
         $this->call(ChatBoxSeeder::class);
         $this->call(EmbeddingDataSeeder::class);


        //Data mẫu user upload cv 
        $this->call(JobApplicationSeeder::class);
    }
}
