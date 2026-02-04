<?php

namespace App\Features\Domain\Recruitment\Packages\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Features\Domain\Recruitment\Subscriptions\Models\RecruiterSubscriptionModel;

class RecruiterPackageModel extends Model
{
    protected $table = 'recruiter_packages';
    protected $primaryKey = 'package_id';

    protected $fillable = [
        'package_name',
        'price',
        'duration_days',
        'post_limit',
        'featured_posts_limit',
        'refresh_limit',
        'support_priority',
        'features',
        'is_active',
        'display_order',
    ];

    protected $casts = [
        'price'        => 'decimal:2',
        'features'     => 'array',
        'is_active'    => 'boolean',
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
    ];

    /** Relationships */

    public function subscriptions(): HasMany
    {
        return $this->hasMany(
            RecruiterSubscriptionModel::class,
            'package_id',
            'package_id'
        );
    }
}
