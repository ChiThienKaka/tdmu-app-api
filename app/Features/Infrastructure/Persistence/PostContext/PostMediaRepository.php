<?php 
namespace App\Features\Infrastructure\Persistence\PostContext;
use App\Models\PostMedia;
class PostMediaRepository
{
    public function __construct(private PostMedia $postMedia)
    {
    }

    public function findById(int $id): ?PostMedia
    {
        return $this->postMedia->find($id);
    }
    public function create(array $data): PostMedia
    {
        return $this->postMedia->create($data);
    }
    public function update(PostMedia $postMedia, array $data): PostMedia
    {
        $postMedia->update($data);
        return $postMedia;
    }
    public function delete(PostMedia $postMedia): void
    {
        $postMedia->delete();
    }
}