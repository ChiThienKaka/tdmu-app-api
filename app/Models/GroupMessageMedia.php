<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupMessageMedia extends Model
{
    protected $table = 'group_message_media';

    protected $primaryKey = 'group_message_media_id';

    protected $fillable = [
        'message_id',
        'media_type',
        'media_url',
        'file_name',
        'disk',
        'media_path',
        'file_size',
    ];
     /**
     * Quan hệ: media thuộc về 1 message
     */
    public function message()
    {
        return $this->belongsTo(GroupMessage::class, 'message_id', 'message_id');
    }
}
