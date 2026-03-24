<?php

namespace App\Features\Domain\RecruiterDashboard\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RecruiterApplicationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'application_id'    => $this->application_id,
            'job_id'            => $this->job_id,
            'full_name'         => $this->full_name,
            'email'             => $this->email,
            'phone'             => $this->phone,
            'cv_url'            => $this->cv_url,
            'cover_letter'      => $this->cover_letter,
            'status'            => $this->status,
            'note'              => $this->note,
            'rating'            => $this->rating,
            'rejection_reason'  => $this->rejection_reason,
            'interview_schedule'=> $this->interview_schedule,
            'interview_location'=> $this->interview_location,
            'interview_status'  => $this->interview_status,
            'reviewed_at'       => $this->reviewed_at,
            'applied_at'        => $this->applied_at,
            'jobpost'           => $this->whenLoaded('jobpost', fn() => [
                'job_id'    => $this->jobpost->job_id ?? null,
                'job_title' => $this->jobpost->job_title ?? null,
            ]),
            'applicant'         => $this->whenLoaded('applicant', fn() => [
                'user_id' => $this->applicant->user_id ?? null,
                'name'    => $this->applicant->name ?? null,
                'email'   => $this->applicant->email ?? null,
            ]),
            'timelines'         => $this->whenLoaded('timelines', fn() =>
                $this->timelines->map(fn($t) => [
                    'status'     => $t->status,
                    'note'       => $t->note,
                    'changed_at' => $t->changed_at,
                ])
            ),
        ];
    }
}
