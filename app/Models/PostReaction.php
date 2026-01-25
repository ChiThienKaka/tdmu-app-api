<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostReaction extends Model
{
    protected $primaryKey = 'reaction_id';
    public $timestamps = true;
    protected $fillable = [
        'post_id',
        'user_id',
        'reaction_type'
    ];
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
