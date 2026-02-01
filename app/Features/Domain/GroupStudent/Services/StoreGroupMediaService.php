<?php
namespace App\Features\Domain\GroupStudent\Services;
use App\Features\Infrastructure\Services\Media\BaseMediaStorage;

class StoreGroupMediaService extends BaseMediaStorage
{
    // Service implementation goes here
    protected function directory(): string
    {
        return 'groups/media';
    }
}