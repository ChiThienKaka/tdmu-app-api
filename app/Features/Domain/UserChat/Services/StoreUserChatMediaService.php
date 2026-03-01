<?php

namespace App\Features\Domain\UserChat\Services;

use App\Features\Infrastructure\Services\Media\BaseMediaStorage;

class StoreUserChatMediaService extends BaseMediaStorage
{
    /**
     * Thư mục lưu media user chat
     */
    protected function directory(): string
    {
        return 'user-chat/media';
    }
}
