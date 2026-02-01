<?php

namespace App\Features\Infrastructure\Services\Media;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Features\Infrastructure\Services\Media\MediaStorageInterface;

abstract class BaseMediaStorage implements MediaStorageInterface
{
    abstract protected function directory(): string;

    public function detectMediaType(UploadedFile $file): string
    {
        $mime = $file->getMimeType(); // server-side, an toàn hơn

        return match (true) {
            str_starts_with($mime, 'image/gif')   => 'gif',
            str_starts_with($mime, 'image/')      => 'image',
            str_starts_with($mime, 'video/')      => 'video',
            default                               => 'file',
        };
    }

    public function store(UploadedFile $file): string
    {
        return $file->store(
            $this->directory(),
            'public'
        );
    }

    public function delete(string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
     public function url(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        return Storage::disk('public')->url($path);
    }
}
