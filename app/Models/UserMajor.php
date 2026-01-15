<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserMajor extends Pivot
{
    protected $table = 'user_majors';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'major_id',
        'class_name',
        'academic_year'
    ];
}
