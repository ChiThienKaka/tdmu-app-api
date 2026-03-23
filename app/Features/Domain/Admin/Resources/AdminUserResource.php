<?php

namespace App\Features\Domain\Admin\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminUserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'user_id'       => $this->user_id,
            'email'         => $this->email,
            'full_name'     => $this->full_name,
            'phone'         => $this->phone,
            'is_verified'   => $this->is_verified,
            'status'        => $this->status,
            'role_name'     => $this->role?->role_name,
            'created_at'    => $this->created_at,
            'company_name'  => $this->company?->company_name, // Nếu là nhà tuyển dụng
            'student_code'  => $this->student_code, // Nếu là sinh viên
        ];
    }
}
