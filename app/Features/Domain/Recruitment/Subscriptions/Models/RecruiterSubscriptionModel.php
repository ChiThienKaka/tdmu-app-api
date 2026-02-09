<?php

namespace App\Features\Domain\Recruitment\Subscriptions\Models;


use Illuminate\Database\Eloquent\Model;
use App\Features\Domain\Recruitment\Packages\Models\RecruiterPackageModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecruiterSubscriptionModel extends Model
{
    protected $table = 'recruiter_subscriptions';
    protected $primaryKey = 'subscription_id';

    protected $fillable = [
        'user_id',
        'package_id',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];
    // default status khi tạo mới
    protected $attributes = [
        'status' => 'pending',
    ];
    /**
     * Mỗi subscription thuộc về 1 package
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(
            RecruiterPackageModel::class,
            'package_id',
            'package_id'
        );
    }
}
