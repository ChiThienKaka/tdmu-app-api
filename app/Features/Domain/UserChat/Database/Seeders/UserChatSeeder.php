<?php
namespace App\Features\Domain\UserChat\Database\Seeders;
use App\Models\User;
use App\Features\Domain\UserChat\Models\UserChatMessage;
use Illuminate\Database\Seeder;

class UserChatSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role_id', [2, 3])->get();
        foreach ($users as $user) {
                $twoUsers = $users->random(2)->values();
                foreach($twoUsers as $u){
                    UserChatMessage::create([
                        'sender_id' => $user->user_id,
                        'receiver_id' => $u->user_id,
                        'content' => 'Xin chào ' . $u->name . '! Đây là tin nhắn từ ' . $user->name,
                        'is_read' => false,
                    ]);
                }
        }

    }
}
