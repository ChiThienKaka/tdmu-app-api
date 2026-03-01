<?php
namespace App\Features\Domain\GroupStudent\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupUsersResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->user->user_id ?? null,
            'full_name' => $this->user->full_name ?? null,
            'avatar_url' => $this->user->avatar_url ?? null,
            'student_code' => $this->user->student_code ?? null,
            'member_role' => $this->member_role ?? null,
        ];
    }
}
