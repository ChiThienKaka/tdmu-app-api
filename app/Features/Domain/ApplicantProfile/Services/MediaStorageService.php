<?php
namespace App\Features\Domain\ApplicantProfile\Services;

use App\Features\Infrastructure\Services\Media\BaseMediaStorage;

class MediaStorageService extends BaseMediaStorage
{
    protected function directory(): string
    {
        return 'student_profiles';
    }
}
