<?php

namespace Database\Seeders;
use App\Models\Group;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GroupMessage;
use App\Models\GroupMessageMedia;

class GroupMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $comment_post = collect(require database_path('seeders\seed-data\post\comment.php'));
        $comment_image = collect(require database_path('seeders\seed-data\post\content_image.php'));
        $groups = Group::with('members')->get();
        foreach($groups as $group){
            foreach($group->members as $member){
                $comment = $comment_post->random();
                $groupMessage = GroupMessage::create([
                    "group_id"=>$group->group_id,
                    "user_id"=>$member->user_id,
                    "message_content"=>$comment['parent'],
                ]);
                $image_url = $comment_image->random();
                // tạo media cho message
                GroupMessageMedia::create([
                    "message_id"=>$groupMessage->message_id,
                    "media_url"=>$image_url,
                    "media_type"=>"image",
                    "file_name"=>"example.jpg",
                    "file_size"=>1234,
                    "disk"=>"public",
                    "created_at"=>now(),
                    "updated_at"=>now(),
                ]);
            }
        }
    }
}
