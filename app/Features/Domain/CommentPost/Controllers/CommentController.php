<?php
namespace App\Features\Domain\CommentPost\Controllers;

use App\Features\Domain\CommentPost\Requests\CreateCommentRequest;
use App\Http\Controllers\Controller;
use App\Features\Domain\CommentPost\Services\CreateCommentService;
use App\Features\Domain\CommentPost\DTOs\CreateCommentDTO;
use App\Features\Domain\CommentPost\Services\StoreCommentService;
use App\Features\Domain\CommentPost\Requests\GetCommentParentRequest;
use Illuminate\Foundation\Http\FormRequest;

class CommentController extends Controller
{
    public function __construct(
        private CreateCommentService $createCommentService, 
        private StoreCommentService $storeCommentService
    )
    {
    }
    // tạo bài post
    public function createCommentPost(CreateCommentRequest $request){
        $user = auth('api')->user(); // hoặc $request->user()
        $dto = CreateCommentDTO::fromArray($request->validated());
        $result = $this->createCommentService->create($dto, $user);
        return response()->json([
            $result
        ], 200);
    }
    //lấy comment cha
    public function getCommentParent(GetCommentParentRequest $request)
    {
        auth('api')->user(); // hoặc $request->user()
        $data = $request->validated();
        $postId = $data['post_id'];
        $perPage = $data['per_page'] ?? 10;
        $result = $this->storeCommentService->getParents($postId, $perPage);
        return response()->json($result);
    }
    //lấy reply của comment cha
    public function getReplyComment(FormRequest $request)
    {
        auth('api')->user(); // hoặc $request->user()
        $data = $request->validate([
            'comment_id' => ['required', 'integer', 'exists:comments,comment_id'],
        ]);
        $commentId = $data['comment_id'];
        $result = $this->storeCommentService->getReplyParent($commentId);
        return response()->json($result);
    }
}