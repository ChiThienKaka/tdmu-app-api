<?php

namespace App\Features\Auth\DTOs;

class GoogleLoginDTO
{
    public function __construct(
        public string $google_id,
        public string $email,
        public string $name,
        public ?string $picture = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            google_id: $data['google_id'],
            email: $data['email'],
            name: $data['name'],
            picture: $data['picture'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'google_id' => $this->google_id,
            'email' => $this->email,
            'name' => $this->name,
            'picture' => $this->picture,
        ];
    }
}
