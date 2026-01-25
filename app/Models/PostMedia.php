<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PostMedia extends Model
{
    protected $primaryKey = 'media_id';
    protected $appends = ['url'];
    public $timestamps = true;
    protected $fillable = [
        'post_id',
        'media_type',
        'media_url',
        'disk',
        'media_order'
    ];
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
    // thêm thuộc tính url ảo để truy cập đường dẫn đầy đủ của media
    public function getUrlAttribute(): string
    {
        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk($this->disk);

        return $disk->url($this->media_url);
    }
}
