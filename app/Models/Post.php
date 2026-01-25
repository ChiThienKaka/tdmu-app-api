<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $primaryKey = 'post_id';
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'faculty_id',
        'major_id',
        'content',
        'status'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function media()
    {
        return $this->hasMany(PostMedia::class, 'post_id');
    }
    public function postreactions()
    {
        return $this->hasMany(PostReaction::class, 'post_id');
    }

}
