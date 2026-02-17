<?php

namespace App\Features\Domain\ApplicantProfile\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class StudentProfileModel extends Model
{
    protected $table = 'student_profiles';

    // Primary key là user_id (không auto increment)
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'int';

    // Cho phép mass assignment
    protected $fillable = [
        'user_id',

        // Academic info
        'student_code',
        'university',
        'major',
        'graduation_year',
        'gpa',
        
        'email',
        'phone',
        // CV & links
        'cv_default_url',
        'linkedin_url',
        'github_url',
        'portfolio_url',

        // Profile content
        'bio',
        'career_goals',

        // Job preference
        'expected_salary_min',
        'expected_salary_max',
        'preferred_job_type',
        'preferred_location',

        'is_public',
    ];

    // Cast dữ liệu
    protected $casts = [
        'preferred_job_type' => 'array',
        'preferred_location' => 'array',
        'graduation_year' => 'integer',
        'gpa' => 'decimal:2',
        'expected_salary_min' => 'decimal:2',
        'expected_salary_max' => 'decimal:2',
        'is_public' => 'boolean',
    ];

    /**
     * Relationship: Student profile belongs to a user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
