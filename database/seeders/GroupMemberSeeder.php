<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Features\Domain\Auth\Services\RegisterGroupService;


class GroupMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $service = app(RegisterGroupService::class);
        $users = User::with('majors.faculty')->get();
        foreach ($users as $user) {
            if($user->role_id !==2){
                 continue; // bỏ qua use không phải student
            }
            // lấy ngành đầu tiên
            $major = $user->majors->first();
            //fake data cho add group cho toàn bộ user mẫu
            $service->registerGroupFaculty($user,$major->faculty_id,$major->major_id);
        }
    }
}
