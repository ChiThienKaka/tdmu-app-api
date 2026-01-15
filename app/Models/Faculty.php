<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $primaryKey = 'faculty_id';

    public $timestamps = false;

    protected $fillable = [
        'faculty_name',
        'faculty_code',
        'description',
        'cover_image'
    ];

    // Ví dụ: 1 khoa có nhiều ngành
    public function majors()
    {
        return $this->hasMany(Major::class, 'faculty_id');
    }
}
