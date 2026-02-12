<?php
namespace App\Features\Domain\JobPostings\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Features\Domain\JobPostings\Models\JobCategoryModel;
use App\Features\Domain\JobPostings\Models\JobSkillModel;

class JobCategorySeeder extends Seeder
{
    public function run(): void
    {
        $datas = collect( require app_path(
            'Features/Domain/JobPostings/Database/Seeders/data/category_fake/datafake.php'
        ));
        $datajobskill = collect( require app_path(
            'Features/Domain/JobPostings/Database/Seeders/data/category_fake/datajobkill.php'
        ));
        foreach ($datajobskill as $skill) {
            JobSkillModel::create([
                'skill_name'     => $skill['skill_name'],
                'skill_category' => $skill['skill_category'],
                'is_active'      => true,
            ]);
        }

        foreach($datas as $data){
            $jobcategory = JobCategoryModel::create([
                'category_name' => $data['category_name'],
                'category_slug' => $data['category_slug'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            foreach($data['children'] as $children){
                JobCategoryModel::create([
                    'category_name' => $children['name'],
                    'category_slug' => $children['slug'],
                    'parent_id' => $jobcategory->category_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
