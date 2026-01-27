<?php
namespace App\Features\Domain\CommentPost\Controllers;

use App\Features\Domain\CommentPost\Requests\CreateCommentRequest;
use App\Http\Controllers\Controller;
use App\Features\Domain\CommentPost\Services\CreateCommentService;
use App\Features\Domain\CommentPost\DTOs\CreateCommentDTO;

class CreateCommentController extends Controller
{
    public function __construct(private CreateCommentService $createCommentService)
    {
    }
    public function createCommentPost(CreateCommentRequest $request){
        $user = auth('api')->user(); // hoặc $request->user()
        $dto = CreateCommentDTO::fromArray($request->validated());
        $result = $this->createCommentService->create($dto, $user);
        return response()->json([
            $result
        ], 200);
    }
}