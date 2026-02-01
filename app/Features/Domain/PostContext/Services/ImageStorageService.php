<?php
namespace App\Features\Domain\PostContext\Services;

use App\Features\Infrastructure\Services\Media\BaseMediaStorage;

class ImageStorageService extends BaseMediaStorage
{
    protected function directory(): string
    {
        return 'posts';
    }
}
