<?php
namespace App\Features\Domain\GroupStudent\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupStudentsByUserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'group_id' => $this->group_id,
            'member_role' => $this->member_role,

            'group' => [
                'group_id' => $this->group->group_id ?? null,
                'group_name' => $this->group->group_name ?? null,
                'group_type' => $this->group->group_type ?? null,
                'avatar_url' => $this->group->avatar_url ?? null,
                'cover_image' => $this->group->cover_image ?? null,
                'privacy' => $this->group->privacy ?? null,
            ]
        ];
    }
}
