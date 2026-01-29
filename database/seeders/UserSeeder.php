<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Major;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //lấy 5 sinh viên cho mỗi chuyên ngành
        $studentsPerMajor = 1;
        // Load dữ liệu mẫu
        $people = collect(require database_path('seeders\seed-data\user\names.php'));
        $avatars = collect(require database_path('seeders\seed-data\user\avatars.php'));
        // lấy bảng Mã ngành để tạo mẫu email sinh viên
        $majors = Major::select('major_id', 'major_code')->get();

        foreach ($majors as $major) {
            for ($i = 1; $i <= $studentsPerMajor; $i++) {
                $person = $people->random();
                $avatar = $avatars->random();
                $studentCode = substr($major->major_code, 1);

                 $user = User::create([
                    'email'         => "206{$studentCode}000{$i}@student.tdmu.edu.vn",
                    'password'      => Hash::make('123456'),
                    'full_name'     => $person['name'],
                    'role_id'       => 2,
                    'student_code'  => $studentCode,
                    'is_verified'   => true,
                    'status'        => 'active',
                    'gender'        => $person['gender'] == 1 ? 'male' : 'female',
                    'avatar_url'    => $avatar,
                ]);

                //tạo record pivot user_majors
                $user->majors()->attach($major->major_id, [
                    'academic_year' => '2021-2026',
                     'created_at' => now(),
                     'updated_at' => now(),
                ]);
            }
        }
    }
}
