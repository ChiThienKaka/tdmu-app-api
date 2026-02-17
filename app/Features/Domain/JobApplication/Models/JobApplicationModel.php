<?php

namespace App\Features\Domain\JobApplication\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Features\Domain\JobPostings\Models\JobPostModel;
use App\Models\User;

class JobApplicationModel extends Model
{
    protected $table = 'job_applications';

    protected $primaryKey = 'application_id';

    public $timestamps = false; // vì bạn custom timestamps

    /*
    |--------------------------------------------------------------------------
    | Mass assignment
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'job_id',
        'user_id',
        'reviewed_by',
        'full_name',
        'email',
        'phone',
        'cv_url',
        'cover_letter',
        'status',
        'note',
        'rating',
        'rejection_reason',
        'interview_schedule',
        'interview_location',
        'interview_status',
        'reviewed_at',
        'applied_at',
        'updated_at',
    ];

    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'rating' => 'integer',
        'interview_schedule' => 'datetime',
        'reviewed_at' => 'datetime',
        'applied_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Status constants
    |--------------------------------------------------------------------------
    */

    public const STATUS_PENDING = 'pending';
    public const STATUS_REVIEWED = 'reviewed';
    public const STATUS_SHORTLISTED = 'shortlisted';
    public const STATUS_INTERVIEWED = 'interviewed';
    public const STATUS_OFFERED = 'offered';
    public const STATUS_ACCEPTED = 'accepted';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_WITHDRAWN = 'withdrawn';

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function timelines()
    {
        return $this->hasMany(
            ApplicationTimelineModel::class,
            'application_id',
            'application_id'
        );
    }
    public function jobpost()
    {
        return $this->belongsTo(JobPostModel::class, 'job_id', 'job_id');
    }

    public function applicant()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by', 'user_id');
    }
    
    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeStatus(Builder $query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeForJob(Builder $query, int $jobId)
    {
        return $query->where('job_id', $jobId);
    }

    public function scopeRecent(Builder $query)
    {
        return $query->orderByDesc('applied_at');
    }
    /*
    |--------------------------------------------------------------------------
    | Business helpers
    |--------------------------------------------------------------------------
    */

    public function markReviewed(int $reviewerId): void
    {
        $this->update([
            'status' => self::STATUS_REVIEWED,
            'reviewed_by' => $reviewerId,
            'reviewed_at' => now(),
        ]);
    }

    public function reject(string $reason): void
    {
        $this->update([
            'status' => self::STATUS_REJECTED,
            'rejection_reason' => $reason,
        ]);
    }

    public function scheduleInterview($datetime, $location): void
    {
        $this->update([
            'interview_schedule' => $datetime,
            'interview_location' => $location,
            'interview_status' => 'scheduled',
            'status' => self::STATUS_INTERVIEWED,
        ]);
    }
}
