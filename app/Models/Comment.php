<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $primaryKey = 'comment_id';
    public $timestamps = true;
    protected $fillable = [
        'post_id',
        'user_id',
        'content',
        'parent_comment_id',
        'status'
    ];
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function parent()
    {
        return $this->belongsTo(
            Comment::class,
            'parent_comment_id',
            'comment_id'
        );
    }
    public function replies()
    {
        return $this->hasMany(
            Comment::class,
            'parent_comment_id',
            'comment_id'
        );
    }
}
