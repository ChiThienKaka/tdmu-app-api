<?php
namespace App\Features\Domain\PostContext\Services;
use App\Features\Infrastructure\Persistence\PostContext\PostMediaRepository;
use App\Features\Infrastructure\Persistence\PostContext\PostRepository;
use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class GetPostService
{ 
    protected PostRepository $postRepository;
    protected PostMediaRepository $postMediaRepository;
    public function __construct(PostRepository $postRepository, PostMediaRepository $postMediaRepository)
    {
        $this->postRepository = $postRepository;
        $this->postMediaRepository = $postMediaRepository;
    }
    public function getPosts(
        User $user,
        $perPage = 10,
    ) {
        $user->load('majors.faculty');
        $major = $user->majors->first();
        $majorId = $major?->major_id;
        $facultyId = $major?->faculty?->faculty_id;
        return Post::with([
                'user',//realations Model Post
                'media'
            ])
            ->withCount(['comment','postreactions'])
            ->where(function ($q) use ($facultyId, $majorId) {
                $q->where('visibility', 'public')
                ->orWhere('faculty_id', $facultyId)
                ->orWhere('major_id', $majorId);
            })
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }
}