<?php
namespace App\Features\Domain\PostContext\Controllers;
use App\Http\Controllers\Controller;
use App\Features\Domain\PostContext\Services\CreatePostService;
use App\Features\Domain\PostContext\DTOs\CreatePostDTO;
use App\Features\Domain\PostContext\Requests\CreatePostRequest;
use Illuminate\Support\Facades\Auth;
use App\FEatures\Domain\PostContext\Services\GetPostService;
use Illuminate\Http\Request;
use App\Features\Domain\PostContext\Resources\PostContextResource;
use App\Features\Domain\PostContext\Resources\StorePostResource;

class PostController extends Controller
{
    protected GetPostService $getPostService;
    protected CreatePostService $createPostService;
    public function __construct(CreatePostService $createPostService, GetPostService $getPostService)
    {
        $this->createPostService = $createPostService;
        $this->getPostService = $getPostService;
    }
    // Tạo bài Post
    public function createPost(CreatePostRequest $request)
    {
        $user = $request->user(); // ← từ token
        $dtoPost = CreatePostDTO::fromArray($request->validated());
        $medias = $request->file('images', []);
        $result = $this->createPostService->createPost($dtoPost, $medias, $user);
        return response()->json(
            new PostContextResource($result),
            201
        );
    }

    // Lấy danh sách bài Post theo user đăng nhập
    public function getPosts(Request $request)
    {
        $cursor = $request->get('perPage');
        $user = Auth::user();
        // Sử dụng dịch vụ để lấy bài viết
        $result = $this->getPostService->getPosts($user, 10, $cursor); 
        return response()->json(
            [
                'data' =>  StorePostResource::collection($result),
                'current_page' => $result->currentPage(),
                'total' => $result->total(),
            ]
        );
    }

}