<?php

namespace App\Features\Domain\ChatBox\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class MessageChatboxModel extends Model
{
    use HasFactory;

    protected $table = 'message_chatbox';

    protected $fillable = [
        'user_id',
        'role',
        'content',
        'job_ids',
        'jobs',
    ];
    protected $casts = [
        'job_ids' => 'array',
        'jobs' => 'array',
    ];
    /**
     * Vì users dùng user_id làm primary key
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}