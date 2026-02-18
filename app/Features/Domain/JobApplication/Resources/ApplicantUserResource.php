<?php

namespace App\Features\Domain\JobApplication\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicantUserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->user_id,
            // 'google_id' => $this->google_id,

            'email' => $this->email,
            'full_name' => $this->full_name,
            'avatar_url' => $this->avatar_url,
            // 'phone' => $this->phone,

            // 'date_of_birth' => $this->date_of_birth,
            // 'gender' => $this->gender,

            // 'role_id' => $this->role_id,
            // 'student_code' => $this->student_code,

            // 'is_verified' => $this->is_verified,
            // 'status' => $this->status,

            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
        ];
    }
}
