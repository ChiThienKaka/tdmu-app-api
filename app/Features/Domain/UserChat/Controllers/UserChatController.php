<?php

namespace App\Features\Domain\UserChat\Controllers;

use App\Http\Controllers\Controller;
use App\Features\Domain\UserChat\Services\UserChatService;
use App\Features\Domain\UserChat\Resources\UserChatMessageResource;
use Illuminate\Http\Request;
use App\Features\Domain\UserChat\Requests\SendUserChatMessageRequest;
use App\Features\Domain\UserChat\Services\SendUserChatMessageService;
use App\Features\Domain\UserChat\DTOs\SendUserChatMessageDTO;
use App\Features\Domain\UserChat\Models\UserChatMessage;

class UserChatController extends Controller
{
    public function __construct(private UserChatService $userChatService, 
    private SendUserChatMessageService $sendUserChatMessageService)
    {
    }

    /**
     * Gửi tin nhắn
     */
    public function sendMessage(SendUserChatMessageRequest $request)
    {
        try {
            $user = auth('api')->user();
            $dto = SendUserChatMessageDTO::fromArray($request->validated());
            $medias = $request->file('medias', []);
            $message = $this->sendUserChatMessageService->sendMessage(
                $user,
                $dto,
                $medias
            );
            return response()->json([
                'message' => 'Tin nhắn gửi thành công',
                'data' => UserChatMessageResource::make($message),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Lấy danh sách tin nhắn giữa 2 user
     */
    public function getConversation(Request $request, $other_user_id)
    {
        $request->validate([
            'per_page' => 'nullable|integer|min:1|max:100',
        ]);

        $user = auth('api')->user();
        $per_page = $request->per_page ?? 20;

        $messages = $this->userChatService->getConversation($user->user_id, $other_user_id, $per_page);

        // Đánh dấu tin nhắn từ $other_user_id gửi cho current user là đã đọc
        $this->userChatService->markAsRead($other_user_id, $user->user_id);

        return response()->json([
            'data' => UserChatMessageResource::collection($messages->items()),
            'pagination' => [
                'current_page' => $messages->currentPage(),
                'per_page' => $messages->perPage(),
                'total' => $messages->total(),
                'last_page' => $messages->lastPage(),
            ],
        ], 200);
    }

    /**
     * Lấy danh sách cuộc hội thoại gần đây
     */
    public function getRecentConversations(Request $request)
    {
        $user = auth('api')->user();
        $limit = $request->limit ?? 20;
        
        $conversations = $this->userChatService->getRecentConversations($user->user_id, $limit);

        return response()->json([
            'data' => UserChatMessageResource::collection($conversations),
        ], 200);
    }

    /**
     * Xóa tin nhắn
     */
    public function deleteMessage(Request $request, $message_id)
    {
        $user = auth('api')->user();

        $success = $this->userChatService->deleteMessage($message_id, $user->user_id);

        if (!$success) {
            return response()->json([
                'error' => 'Không thể xóa tin nhắn này',
            ], 403);
        }

        return response()->json([
            'message' => 'Xóa tin nhắn thành công',
        ], 200);
    }
}
