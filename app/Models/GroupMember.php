<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupMember extends Model
{
    protected $table = 'group_members';

    // Vì dùng composite primary key nên:
    public $incrementing = false;
    protected $primaryKey = null;

    protected $fillable = [
        'group_id',
        'user_id',
        'member_role',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'group_id', 'group_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
