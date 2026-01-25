<?php

namespace App\Features\Domain\Auth\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TokenResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'access_token' => $this['access_token'],
            // 'token_type' => $this['token_type'] ?? 'Bearer',
            'expires_in' => $this['expires_in'] ?? null,
            'user' => new AuthResource($this['user']),
        ];
    }
}
