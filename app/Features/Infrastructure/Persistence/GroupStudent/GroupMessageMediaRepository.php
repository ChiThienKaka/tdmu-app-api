<?php
namespace App\Features\Infrastructure\Persistence\GroupStudent;

use App\Models\Group;
use App\Models\GroupMessageMedia;
class GroupMessageMediaRepository
{
    // Repository methods will be implemented here
    
    public function __construct(private GroupMessageMedia $group_message_media)
    {
    }

    public function findById(int $id): ?GroupMessageMedia
    {
        return $this->group_message_media->find($id);
    }
    public function create(array $data): GroupMessageMedia
    {
        return $this->group_message_media->create($data);
    }
    public function update(GroupMessageMedia $group_message_media, array $data): GroupMessageMedia
    {
        $group_message_media->update($data);
        return $group_message_media;
    }
    public function delete(GroupMessageMedia $group_message_media): void
    {
        $group_message_media->delete();
    }
    // trả về boolean
    public function insert(array $data)
    {
        return GroupMessageMedia::insert($data);
    }
    //trả về Eloquent collection
    ////chỉ tồn tại trên relationship
    public function createMany(array $data)
    {
        return GroupMessageMedia::createMany($data);
    }
}