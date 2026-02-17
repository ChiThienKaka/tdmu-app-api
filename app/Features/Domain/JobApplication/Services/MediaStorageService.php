<?php
namespace App\Features\Domain\JobApplication\Services;

use App\Features\Infrastructure\Services\Media\BaseMediaStorage;

class MediaStorageService extends BaseMediaStorage
{
    protected function directory(): string
    {
        return 'cv_jobapplication';
    }
}
