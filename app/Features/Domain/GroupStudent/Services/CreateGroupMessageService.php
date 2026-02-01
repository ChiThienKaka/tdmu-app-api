<?php
namespace App\Features\Domain\GroupStudent\Services;

use App\Features\Domain\GroupStudent\Repositories\ChatGroupRepository;
use App\Features\Domain\GroupStudent\DTOs\CreateGroupMessageDTO;
use App\Features\Infrastructure\Persistence\GroupStudent\GroupMessageMediaRepository;
use App\Features\Domain\GroupStudent\Services\StoreGroupMediaService;
use App\Models\User;

class CreateGroupMessageService
{
    // Service implementation goes here
    public function __construct(private ChatGroupRepository $chatGroupRepository, 
    private GroupMessageMediaRepository $groupMessageMediaRepository,
    private StoreGroupMediaService $storeGroupMediaService)
    {
        // Constructor code here
    }
    public function createGroupMessage(User $use, CreateGroupMessageDTO $dto, array $medias)
    {
        // Method implementation here
        if($use === null) {
            throw new \Exception('User must be authenticated to create a group message.');
        }
        if(empty($dto->content) && empty($medias)) {
            throw new \Exception('Content or medias must be provided to create a group message.');
        }
        // đã check ở request nên ko cần check lại
        $group_message = $this->chatGroupRepository->createGroupMessage($use, $dto->groupId, $dto->content);
        // Nếu không có media → xong luôn
        if (empty($medias)) {
            return $group_message;
        }
        //Chuẩn bị batch insert (nhanh hơn nhiều)
        $mediaData = [];
        // Handle media saving logic here
        foreach($medias as $media){
            $path = $this->storeGroupMediaService->store($media);
            $mediaData[] = [
                'message_id' => $group_message->message_id,
                'media_path' => $path,
                'media_url' =>  $this->storeGroupMediaService->url($path),
                'media_type' => $this->storeGroupMediaService->detectMediaType($media),
                'file_name' => $media->getClientOriginalName(),
                'file_size' => $media->getSize(),
                'disk' => 'public',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        // Thực hiện batch insert 1 lúc chỉ createMany chỉ tạo cho quan hệ many thôi nó trả về eloquent collection
        // nhớ khai báo quan hệ trong model GroupMessage
        //chỉ tồn tại trên relationship
        $mediaData = $group_message->medias()->createMany($mediaData);
        // KHÔNG CÓ query nào phát sinh thêm
        $result = $group_message->setRelation('medias', collect($mediaData));
        return $result;
    }
}