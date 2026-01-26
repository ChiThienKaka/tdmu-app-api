<?php
namespace App\Features\Domain\PostContext\Services;
use App\Features\Infrastructure\Persistence\PostContext\PostRepository;
use App\Features\Infrastructure\Persistence\PostContext\PostMediaRepository;
use App\Features\Domain\PostContext\Services\ImageStorageService;
use App\Features\Domain\PostContext\DTOs\CreatePostDTO;
use App\Models\User;

class CreatePostService
{
    protected PostRepository $postRepository;
    protected PostMediaRepository $postMediaRepository;
    protected ImageStorageService $imageStorageService;
    public function __construct(
        PostRepository $postRepository,
        PostMediaRepository $postMediaRepository,
        ImageStorageService $imageStorageService
    ) {
        $this->postRepository = $postRepository;
        $this->postMediaRepository = $postMediaRepository;
        $this->imageStorageService = $imageStorageService;
    }
    public function createPost(CreatePostDTO $dto, array $medias , User $user): array
    {
        if ($user === null) {
            throw new \Exception('User must be authenticated to create a post.');
        }
        //load lại thông tin user kèm major sử dụng realtions
        if($user->role_id === 2){
            $user->load('majors.faculty');
            $major = $user->majors->first();
            $faculty = $major->faculty;
        }else{
            $major = null;
            $faculty = null;
        }
       
        // Tạo bài đăng
        $post = $this->postRepository->create([
            'user_id' => $user->user_id,
            'major_id' => $major?->major_id,
            'faculty_id' => $faculty?->faculty_id,
            'content' => $dto->content,
        ]);
        if(empty($medias)) {
            return ['post' => $post];
        }
        $mediaRecords = [];
        // Tạo media cho bài đăng
        foreach (array_values($medias) as $index => $media) {
            $path = $this->imageStorageService->storePostImage($media);
            $mediaRecords[] = $this->postMediaRepository->create([
                'post_id' => $post->post_id,
                // 'media_type' => $media->getClientMimeType(),
                'media_type' => $this->imageStorageService->detectMediaType($media),
                'media_url'=> $path,
                'disk'=>'public',
                'media_order'=> $index,
            ]);
        }
        return [
            'post' => $post,
            'media' => $mediaRecords,
        ];
    }
}