<?php

namespace App\Features\Domain\UserChat\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;

class UserChatMessage extends Model
{
    protected $table = 'user_chat_messages';

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'content',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    /**
     * User gửi tin nhắn
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id', 'user_id');
    }

    /**
     * User nhận tin nhắn
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id', 'user_id');
    }

    /**
     * Các media đính kèm của tin nhắn
     */
    public function medias(): HasMany
    {
        return $this->hasMany(
            UserChatMessageMedia::class,
            'message_id',
            'id'
        );
    }
}
