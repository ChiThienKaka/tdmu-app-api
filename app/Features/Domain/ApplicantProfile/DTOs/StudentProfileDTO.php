<?php

namespace App\Features\Domain\ApplicantProfile\DTOs;

class StudentProfileDTO
{
    public function __construct(
        // public int $user_id,
        public ?string $student_code,
        public ?string $university,
        public ?string $major,
        public ?int $graduation_year,
        public ?float $gpa,

        public ?string $cv_default_url,
        public ?string $linkedin_url,
        public ?string $github_url,
        public ?string $portfolio_url,

        public ?string $bio,
        public ?string $career_goals,

        public ?float $expected_salary_min,
        public ?float $expected_salary_max,

        public ?array $preferred_job_type,
        public ?array $preferred_location,

        public bool $is_public
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            // user_id: $userId,
            student_code: $data['student_code'] ?? null,
            university: $data['university'] ?? null,
            major: $data['major'] ?? null,
            graduation_year: $data['graduation_year'] ?? null,
            gpa: $data['gpa'] ?? null,

            cv_default_url: $data['cv_default_url'] ?? null,
            linkedin_url: $data['linkedin_url'] ?? null,
            github_url: $data['github_url'] ?? null,
            portfolio_url: $data['portfolio_url'] ?? null,

            bio: $data['bio'] ?? null,
            career_goals: $data['career_goals'] ?? null,

            expected_salary_min: $data['expected_salary_min'] ?? null,
            expected_salary_max: $data['expected_salary_max'] ?? null,

            preferred_job_type: $data['preferred_job_type'] ?? null,
            preferred_location: $data['preferred_location'] ?? null,

            is_public: $data['is_public'] ?? true
        );
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
