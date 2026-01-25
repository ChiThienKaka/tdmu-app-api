<?php
namespace App\Features\Domain\PostContext\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageStorageService
{
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

    public function storePostImage(UploadedFile $file): string
    {
        return $file->store('posts', 'public');
    }

    public function delete(string $path): void
    {
        if (!$path) {
            return;
        }
        Storage::disk('public')->delete($path);
    }
}
