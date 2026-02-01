<?php

namespace Database\Seeders;
use App\Models\Group;
use App\Models\Major;
use App\Models\Faculty;
use App\Models\User;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $content_images = collect(require database_path('seeders\seed-data\post\content_image.php'));
        $user_admin = User::where('role_id', 1)->first();
        $faculties = Faculty::select('faculty_id','faculty_name')->get();
        $majors = Major::select('major_id', 'faculty_id', 'major_name')->get();
        //group khoa viện 
        foreach($faculties as $faculty){
            $image = $content_images->random();
            Group::create([
                'group_name' => "Nhóm Viện/Khoa $faculty->faculty_name",
                'group_type' => "faculty",
                'faculty_id' => $faculty->faculty_id,
                'created_by' => $user_admin->user_id,
                'cover_image'=> $image,
            ]);
        };
        //group Ngành
        foreach($majors as $major){
            Group::create([
                'group_name' => "Nhóm Ngành $major->major_name",
                'group_type' => "major",
                'faculty_id' => $major->faculty_id,
                'major_id' => $major->major_id,
                'created_by' => $user_admin->user_id,
            ]);
        }
        $arrCLB = [
           [
             "clb_name" => "CLB trực thuộc Đoàn - Hội trường",
             "clb_description" => "CLB Kỹ năng, Đội Công tác xã hội, Đội Tình nguyện, Câu lạc bộ Truyền thông."
           ],
           [
             "clb_name" => "CLB học thuật và kỹ năng",
             "clb_description" => "CLB Những nhà sáng lập (TFC), các CLB tiếng Anh, CLB Tin học, CLB Nghiên cứu khoa học."
           ],
           [
             "clb_name" => "CLB Văn nghệ - Thể thao",
             "clb_description" => "Các CLB hát, múa, guitar, các đội bóng đá, bóng chuyền, võ thuật. "
           ]
        ];
        //Câu lạc bộ tự do
        foreach($arrCLB as $clb){
            Group::create([
                'group_name' => $clb["clb_name"],
                'group_type' => "club",
                'description' => $clb["clb_description"],
                'created_by' => $user_admin->user_id,
            ]);
        }
    }
}
