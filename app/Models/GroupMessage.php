<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GroupMessage extends Model
{
    protected $table = 'group_messages';

    protected $primaryKey = 'message_id';

    protected $fillable = [
        'group_id',
        'user_id',
        'message_content',
        'message_type',
        'media_url',
        'reply_to_message_id',
        'is_pinned',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Tin nhắn thuộc group nào
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'group_id', 'group_id');
    }

    // Người gửi tin nhắn
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Tin nhắn gốc (nếu là reply)
    public function parentMessage(): BelongsTo
    {
        return $this->belongsTo(
            GroupMessage::class,
            'reply_to_message_id',
            'message_id'
        );
    }

    // Các reply của tin nhắn này
    public function replies(): HasMany
    {
        return $this->hasMany(
            GroupMessage::class,
            'reply_to_message_id',
            'message_id'
        );
    }
    // Các media đính kèm của tin nhắn
    public function medias(): HasMany
    {
        return $this->hasMany(
            GroupMessageMedia::class,
            'message_id',
            'message_id'
        );
    }
}
