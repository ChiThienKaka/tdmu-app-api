<?php

namespace App\Features\Domain\UserChat\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserChatMessageMedia extends Model
{
    protected $table = 'user_chat_message_media';

    protected $fillable = [
        'message_id',
        'media_type',
        'media_url',
        'media_path',
        'file_name',
        'disk',
        'file_size',
    ];

    /**
     * Media thuộc về 1 message
     */
    public function message(): BelongsTo
    {
        return $this->belongsTo(UserChatMessage::class, 'message_id', 'id');
    }
}
