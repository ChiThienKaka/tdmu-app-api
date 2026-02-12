<?php

namespace App\Features\Domain\JobPostings\Models;

use Illuminate\Database\Eloquent\Model;

class JobSkillModel extends Model
{
    protected $table = 'job_skills';

    protected $primaryKey = 'skill_id';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'skill_name',
        'skill_category',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
