<?php

namespace App\Features\Domain\Recruitment\Payments\Services;

use App\Features\Domain\Recruitment\Payments\Models\PaymentTransactionModel;
use App\Features\Domain\Recruitment\Subscriptions\Models\RecruiterSubscriptionModel;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PaymentService
{
    /**
     * Tạo payment cho subscription
     */
    public function createPayment(RecruiterSubscriptionModel $subscription, string $method)
    {
        if ($subscription->status !== 'pending') {
            throw ValidationException::withMessages([
                'subscription' => 'Subscription is not payable'
            ]);
        }

        // Check đã có payment pending chưa
        $existing = PaymentTransactionModel::where('subscription_id', $subscription->subscription_id)
            ->where('status', 'pending')
            ->first();

        if ($existing) {
            return $existing; // không tạo thêm
        }

        return PaymentTransactionModel::create([
            'subscription_id'   => $subscription->subscription_id,
            'transaction_code'  => strtoupper(Str::random(12)),
            'payment_method'    => $method,
            'amount'            => $this->calculateAmount($subscription),
            'status'            => 'pending',
            'created_at'        => now(),
            'ip_address'        => request()->ip(),
        ]);
    }

    /**
     * Xác nhận thanh toán thành công
     * (CALLBACK / WEBHOOK)
     */
    public function confirmPaymentSuccess(
        string $transactionCode,
        array $gatewayResponse = []
    ) {
        return DB::transaction(function () use ($transactionCode, $gatewayResponse) {

            $payment = PaymentTransactionModel::where('transaction_code', $transactionCode)
                ->where('status', 'pending')
                ->lockForUpdate()
                ->firstOrFail();

            $payment->update([
                'status' => 'success',
                'gateway_response' => $gatewayResponse,
                'completed_at' => now(),
            ]);

            $subscription = $payment->subscription;

            $subscription->update([
                'status' => 'active',
                'start_date' => now(),
                'end_date' => now()->addMonth(),
            ]);

            return $subscription;
        });
    }

    /**
     * Thanh toán thất bại / timeout
     */
    public function failPayment(
        string $transactionCode,
        array $gatewayResponse = []
    ) {
        return DB::transaction(function () use ($transactionCode, $gatewayResponse) {

            $payment = PaymentTransactionModel::where('transaction_code', $transactionCode)
                ->where('status', 'pending')
                ->lockForUpdate()
                ->firstOrFail();

            $payment->update([
                'status' => 'failed',
                'gateway_response' => $gatewayResponse,
                'completed_at' => now(),
            ]);

            $payment->subscription->update([
                'status' => 'cancelled'
            ]);
        });
    }

    protected function calculateAmount(RecruiterSubscriptionModel $subscription): float
    {
        // Thực tế lấy từ bảng recruiter_packages
        return 499000;
    }
}
