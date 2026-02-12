<?php

namespace App\Features\Domain\JobPostings\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class JobPostViewModel extends Model
{
    protected $table = 'job_post_views';

    protected $primaryKey = 'view_id';

    public $timestamps = false; // vì không có created_at, updated_at

    protected $fillable = [
        'job_id',
        'user_id',
        'ip_address',
        'user_agent',
        'session_id',
        'viewed_at',
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function job()
    {
        return $this->belongsTo(
            JobPostModel::class,
            'job_id',
            'job_id'
        );
    }

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'user_id'
        );
    }
}
