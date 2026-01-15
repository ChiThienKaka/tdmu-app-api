<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    protected $primaryKey = 'major_id';

    public $timestamps = false;

    protected $fillable = [
        'faculty_id',
        'major_name',
        'major_code',
        'description'
    ];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }
    // Quan hệ với User thông qua bảng trung gian UserMajor
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_majors', 'major_id', 'user_id')
                    ->using(UserMajor::class)
                    ->withPivot(['class_name', 'academic_year']);
    }
}
