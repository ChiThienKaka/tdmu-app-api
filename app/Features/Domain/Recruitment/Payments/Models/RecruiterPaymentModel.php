<?php

namespace App\Features\Domain\Recruitment\Payments\Models;
use App\Features\Domain\Recruitment\Subscriptions\Models\RecruiterSubscriptionModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruiterPaymentModel extends Model
{
    use HasFactory;

    /**
     * Table name
     */
    protected $table = 'recruiter_payments';

    /**
     * Primary key
     */
    protected $primaryKey = 'payment_id';
    
    /**
     * Mass assignable
     */
    protected $fillable = [
        'subscription_id',
        'payment_status',
        'payment_method',
        'payment_amount',
        'payment_transaction_id',
        'paid_at',
    ];

    /**
     * Cast attributes
     */
    protected $casts = [
        'payment_amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    /**
     * Relationship: Payment belongs to a subscription
     */
    public function subscription()
    {
        return $this->belongsTo(
            RecruiterSubscriptionModel::class,
            'subscription_id',
            'subscription_id'
        );
    }
}
