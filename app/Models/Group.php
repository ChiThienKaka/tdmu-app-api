<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    protected $table = 'groups';

    protected $primaryKey = 'group_id';

    protected $fillable = [
        'group_name',
        'group_type',
        'faculty_id',
        'major_id',
        'description',
        'avatar_url',
        'cover_image',
        'is_auto_join',
        'privacy',
        'created_by',
    ];

    protected $casts = [
        'is_auto_join' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Người tạo group
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    // Thuộc faculty (nếu có)
    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class, 'faculty_id', 'faculty_id');
    }

    // Thuộc major (nếu có)
    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class, 'major_id', 'major_id');
    }

    // Thành viên group
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'group_members',
            'group_id',
            'user_id'
        )->withPivot('member_role', 'joined_at');
    }

    // Tin nhắn trong group
    public function messages(): HasMany
    {
        return $this->hasMany(GroupMessage::class, 'group_id', 'group_id');
    }
}
