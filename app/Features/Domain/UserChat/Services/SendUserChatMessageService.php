<?php

namespace App\Features\Domain\UserChat\Services;

use App\Features\Domain\UserChat\DTOs\SendUserChatMessageDTO;
use App\Features\Domain\UserChat\Repositories\UserChatRepository;
use App\Models\User;

class SendUserChatMessageService
{
    public function __construct(
        private UserChatRepository $userChatRepository,
        private StoreUserChatMediaService $storeUserChatMediaService
    ) {}

    /**
     * Gửi tin nhắn kèm media (hoặc chỉ content)
     */
    public function sendMessage(User $sender, SendUserChatMessageDTO $dto, array $medias = [])
    {
        // Kiểm tra user gửi đúng không
        if ($sender === null) {
            throw new \Exception('Người dùng phải được xác thực để gửi tin nhắn.');
        }

        // Kiểm tra có nội dung hoặc media
        if (empty($dto->content) && empty($medias)) {
            throw new \Exception('Tin nhắn phải có nội dung hoặc ít nhất một tệp đính kèm.');
        }

        // Tạo tin nhắn (chỉ content)
        $message = $this->userChatRepository->sendMessage($sender, $dto->receiver_id, $dto->content ?? '');

        // Nếu không có media → xong
        if (empty($medias)) {
            return $message->load('medias');
        }

        // Xử lý media - batch insert
        $mediaData = [];
        foreach ($medias as $media) {
            $path = $this->storeUserChatMediaService->store($media);
            $mediaData[] = [
                'message_id' => $message->id,
                'media_path' => $path,
                'media_url' => $this->storeUserChatMediaService->url($path),
                'media_type' => $this->storeUserChatMediaService->detectMediaType($media),
                'file_name' => $media->getClientOriginalName(),
                'file_size' => $media->getSize(),
                'disk' => 'public',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Batch insert media
        $mediaData = $message->medias()->createMany($mediaData);

        // Set relation và return
        $result = $message->setRelation('medias', collect($mediaData));
        return $result;
    }
}
