<?php

namespace App\Features\Domain\Recruitment\Subscriptions\Models;

use Illuminate\Database\Eloquent\Model;

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
}
