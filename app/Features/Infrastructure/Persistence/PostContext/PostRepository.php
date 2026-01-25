<?php
namespace App\Features\Infrastructure\Persistence\PostContext;

use App\Models\Post;

class PostRepository
{
    public function __construct(private Post $post)
    {
    }
    public function all(): array
    {
        return $this->post->all()->toArray();
    }
    public function findById(int $id): ?Post
    {
        return $this->post->find($id);
    } 
    public function create(array $data): Post
    {
        return $this->post->create($data);
    }
    public function update(Post $post, array $data): Post
    {
        $post->update($data);
        return $post;
    }   
    public function delete(Post $post): void
    {
        $post->delete();
    }
}