<?php
namespace App\Features\Domain\GroupStudent\Controllers;
use App\Http\Controllers\Controller;
use App\Features\Domain\GroupStudent\Services\CreateGroupMessageService;
use App\Features\Domain\GroupStudent\Requests\CreateGroupMessageRequest;
use App\Features\Domain\GroupStudent\DTOs\CreateGroupMessageDTO;
use App\Features\Domain\GroupStudent\Resources\GroupMessageResource;
use Illuminate\Foundation\Http\FormRequest;
use App\Features\Domain\GroupStudent\Repositories\ChatGroupRepository;
use App\Features\Domain\GroupStudent\Resources\ListGroupMessageResource;

class GroupMessageController extends Controller
{
    // Controller implementation goes here
    public function __construct(private CreateGroupMessageService $createGroupMessageService,
    private ChatGroupRepository $chat_group_repository)
    {
        // Constructor code here
    }
    public function getListMessageGroup(FormRequest $request){
        $user = auth('api')->user(); // hoặc $request->user()
        $group_id = $request->input('group_id');
        $result = $this->chat_group_repository->GetListGroupMessage($user, $group_id);
        return response()->json([
                'data' => ListGroupMessageResource::collection($result),
                'current_page' => $result->currentPage(),
                'total_pages' => $result->lastPage(),
                'total' => $result->total(),
            ],
            200);
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