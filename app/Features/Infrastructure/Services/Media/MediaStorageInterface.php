<?php

namespace App\Features\Infrastructure\Services\Media;

use Illuminate\Http\UploadedFile;

interface MediaStorageInterface
{
    public function store(UploadedFile $file): string;

    public function delete(string $path): void;

    public function detectMediaType(UploadedFile $file): string;

    public function url(?string $path): ?string;
}
