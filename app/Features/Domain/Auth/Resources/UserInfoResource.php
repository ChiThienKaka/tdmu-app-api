<?php

namespace App\Features\Domain\Auth\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->user_id,
            'email' => $this->email,
            'full_name' => $this->full_name,
            'avatar_url' => $this->avatar_url,
            'phone' => $this->phone,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            'student_code' => $this->student_code,
            'is_verified' => $this->is_verified,
            'status' => $this->status,

            'majors' => $this->whenLoaded('majors', function () {
                return $this->majors->map(function ($major) {
                    return [
                        'major_id' => $major->major_id,
                        'major_name' => $major->major_name,
                        'major_code' => $major->major_code,

                        'faculty' => $major->faculty ? [
                            'faculty_id' => $major->faculty->faculty_id,
                            'faculty_name' => $major->faculty->faculty_name,
                            'faculty_code' => $major->faculty->faculty_code,
                        ] : null,
                    ];
                });
            }),
        ];
    }
}
