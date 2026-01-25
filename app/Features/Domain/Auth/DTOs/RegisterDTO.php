<?php

namespace App\Features\Domain\Auth\DTOs;

class RegisterDTO
{
    public function __construct(
        public string $full_name,
        public string $email,
        public string $password,
        public ?string $google_id = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            full_name: $data['name'],
            email: $data['email'],
            password: $data['password'],
            google_id: $data['google_id'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'full_name' => $this->full_name,
            'email' => $this->email,
            'password' => $this->password,
            'google_id' => $this->google_id,
        ];
    }
}
