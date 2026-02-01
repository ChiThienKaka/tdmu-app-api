<?php
namespace App\Features\Infrastructure\Persistence\GroupStudent;
use App\Models\GroupMessage;

class GroupMessageRepository
{
    // Repository methods will be implemented here
    
    public function __construct(private GroupMessage $group_message)
    {
    }

    public function findById(int $id): ?GroupMessage
    {
        return $this->group_message->find($id);
    }
    public function create(array $data): GroupMessage
    {
        return $this->group_message->create($data);
    }
    public function update(GroupMessage $group_message, array $data): GroupMessage
    {
        $group_message->update($data);
        return $group_message;
    }
    public function delete(GroupMessage $group_message): void
    {
        $group_message->delete();
    }
}