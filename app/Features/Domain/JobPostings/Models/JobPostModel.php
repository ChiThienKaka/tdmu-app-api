<?php

namespace App\Features\Domain\JobPostings\Models;

use App\Features\Domain\Recruitment\Companies\Models\RecruiterCompanyModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Features\Domain\Recruitment\Subscriptions\Models\RecruiterSubscriptionModel;
use App\Models\User;

class JobPostModel extends Model
{
    use HasFactory;

    protected $table = 'job_posts';

    protected $primaryKey = 'job_id';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'subscription_id',
        'user_id',
        'category_id',
        'moderated_by',

        'job_title',
        'slug',
        'job_description',
        'requirements',
        'benefits',

        'salary_min',
        'salary_max',
        'salary_type',

        'job_type',
        'experience_level',
        'education_level',
        'number_of_positions',
        'work_mode',
        'gender_requirement',

        'location_province',
        'location_district',
        'location_address',

        'application_deadline',
        'contact_email',
        'contact_phone',
        'contact_person',

        'is_featured',
        'priority_level',
        'status',
        'rejection_reason',
        'moderated_at',

        'view_count',
        'application_count',

        'last_refreshed_at',
        'published_at',
    ];

    protected $casts = [
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2',
        'is_featured' => 'boolean',
        'application_deadline' => 'date',
        'moderated_at' => 'datetime',
        'last_refreshed_at' => 'datetime',
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Job thuộc về Subscription
    public function subscription()
    {
        return $this->belongsTo(
            RecruiterSubscriptionModel::class,
            'subscription_id',
            'subscription_id'
        );
    }

    // Job thuộc về User (Recruiter)
    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'user_id'
        );
    }

    // Job thuộc về Category
    public function category()
    {
        return $this->belongsTo(
            JobCategoryModel::class,
            'category_id',
            'category_id'
        );
    }
    // 1 bài post chỉ 1 công ty, 1 công ty có nhiều bài post
    public function company()
    {
        return $this->belongsTo(RecruiterCompanyModel::class, 'company_id', 'company_id');
    }
    // Người duyệt bài
    public function moderator()
    {
        return $this->belongsTo(
            User::class,
            'moderated_by',
            'user_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes (rất hữu ích cho hệ thống tuyển dụng)
    |--------------------------------------------------------------------------
    */
    //Lấy job đã duyệt
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
    
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeActive($query)
    {
        return $query
            ->where('status', 'approved')
            ->where(function ($q) {
                $q->whereNull('application_deadline')
                  ->orWhere('application_deadline', '>=', now());
            });
    }
}
