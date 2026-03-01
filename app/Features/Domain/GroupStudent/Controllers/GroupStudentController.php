<?php
namespace App\Features\Domain\GroupStudent\Controllers;
use App\Http\Controllers\Controller;
use App\Features\Domain\GroupStudent\Services\GroupStudentService;
use App\Features\Domain\GroupStudent\Resources\GroupStudentsByUserResource;
use App\Features\Domain\GroupStudent\Resources\GroupUsersResource;
use Illuminate\Http\Request;
class GroupStudentController extends Controller 
{
    // Controller implementation goes here
    public function __construct(private GroupStudentService $groupStudentService)
    {
        // Constructor code here
    }
    public function getGroupStudentsByUser()
    {
        $user = auth('api')->user(); // hoặc $request->user()
        $result = $this->groupStudentService->getGroupStudentsByUser($user);
        return response()->json([
            'data' => GroupStudentsByUserResource::collection($result)
        ], 200);
    }
    // lấy danh sách thành viên trong group
    public function getUsersByGroup(Request $request, $group_id)
    {
        $result = $this->groupStudentService->getUsersByGroup($group_id);
        return response()->json([
            'data' => GroupUsersResource::collection($result)
        ], 200);
    }
}