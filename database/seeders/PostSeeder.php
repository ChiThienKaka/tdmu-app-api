<?php

namespace Database\Seeders;

use App\Models\Major;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use App\Models\UserMajor;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contents = collect(require database_path('seeders\seed-data\post\content.php'));
        $content_images = collect(require database_path('seeders\seed-data\post\content_image.php'));
        $comment_post = collect(require database_path('seeders\seed-data\post\comment.php'));
        $users = User::with('majors')->get();

        foreach ($users as $user) {

            // mỗi user lấy major đầu tiên (hoặc loop nếu nhiều)
            $major = $user->majors->first();

            if (!$major) {
                continue; // user chưa gắn ngành thì bỏ qua
            }
            for($i=0; $i<5; $i++){
                $image = $content_images->random();
                $post = Post::create([
                    'user_id'    => $user->user_id,
                    'major_id'   => $major->major_id,
                    'faculty_id' => $major->faculty_id,
                    'content'    => $contents[$major->major_id][$i],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $post->media()->create([
                    'media_type' => 'image',
                    'media_url' => $image,
                    'disk' => 'server',
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);
                // tạo comment cha
                foreach($comment_post as $comment){
                    $user_comment = $users->random();
                    $parentComment = $post->comment()->create([
                        'user_id' => $user_comment->user_id,
                        'content' => $comment['parent']
                    ]);
                    // Lấy id comment cha vừa tạo
                    $parentId = $parentComment->comment_id;

                    //Tạo comment con (reply)
                    foreach ($comment['children'] as $child) {
                        $user_child = $users->random();
                        $post->comment()->create([
                            'user_id' => $user_child->user_id,
                            'content' => $child,
                            'parent_comment_id' => $parentId, // gán cha
                        ]);
                    }
                }
            }
        }
    }
}
