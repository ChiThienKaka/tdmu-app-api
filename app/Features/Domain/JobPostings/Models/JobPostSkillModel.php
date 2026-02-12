<?php

namespace App\Features\Domain\JobPostings\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class JobPostSkillModel extends Pivot
{
    //bảng trung gian
    protected $table = 'job_post_skills';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable = [
        'job_id',
        'skill_id',
        'is_required',
        'proficiency_level',
    ];

    protected $casts = [
        'is_required' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function job()
    {
        return $this->belongsTo(JobPostModel::class, 'job_id', 'job_id');
    }

    public function skill()
    {
        return $this->belongsTo(JobSkillModel::class, 'skill_id', 'skill_id');
    }
}
