<?php

namespace App\Features\Domain\Recruitment\Payments\Models;
use App\Features\Domain\Recruitment\Subscriptions\Models\RecruiterSubscriptionModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentTransactionModel extends Model
{
    protected $table = 'payment_transactions';
    protected $primaryKey = 'transaction_id';

    public $timestamps = false;

    protected $fillable = [
        'subscription_id',
        'transaction_code',
        'payment_method',
        'amount',
        'status',
        'gateway_response',
        'ip_address',
        'completed_at',
        'created_at',
    ];

    protected $casts = [
        'amount'          => 'decimal:2',
        'gateway_response'=> 'array',
        'completed_at'    => 'datetime',
        'created_at'      => 'datetime',
    ];

    /** Relationships */

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(
            RecruiterSubscriptionModel::class,
            'subscription_id',
            'subscription_id'
        );
    }
}
