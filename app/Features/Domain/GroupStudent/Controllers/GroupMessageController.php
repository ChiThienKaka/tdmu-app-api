<?php
namespace App\Features\Domain\GroupStudent\Controllers;
use App\Http\Controllers\Controller;
use App\Features\Domain\GroupStudent\Services\CreateGroupMessageService;
use App\Features\Domain\GroupStudent\Requests\CreateGroupMessageRequest;
use App\Features\Domain\GroupStudent\DTOs\CreateGroupMessageDTO;
use App\Features\Domain\GroupStudent\Resources\GroupMessageResource;

class GroupMessageController extends Controller
{
    // Controller implementation goes here
    public function __construct(private CreateGroupMessageService $createGroupMessageService)
    {
        // Constructor code here
    }
    public function createGroupMessage(CreateGroupMessageRequest $request)
    {
        $user = auth('api')->user(); // hoặc $request->user()
        $dto = CreateGroupMessageDTO::fromArray($request->validated());
        $medias = $request->file('medias', []);
        $result = $this->createGroupMessageService->createGroupMessage($user, $dto, $medias);
        return response()->json([
           'message' => 'Tin nhắn đã được gửi thành công.',
           'data' => new GroupMessageResource($result)
        ], 200);
    }
}