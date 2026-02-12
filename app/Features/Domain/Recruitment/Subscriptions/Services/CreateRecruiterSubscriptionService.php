<?php

namespace App\Features\Domain\Recruitment\Subscriptions\Services;

use App\Features\Domain\Recruitment\Subscriptions\Models\RecruiterSubscriptionModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Features\Domain\Recruitment\Payments\Models\RecruiterPaymentModel;
class CreateRecruiterSubscriptionService
{
    public function subscribe(User $user, int $packageId)
    {
        $userId = $user->user_id;
        $user->load('company');
        if ($user->company?->verification_status !== 'verified') {
            throw ValidationException::withMessages([
                'company' => 'Thông tin công ty chưa được xác minh',
                'support' => 'Vui lòng cập nhật thông tin công ty để có thể tuyển dụng'
            ]);
        }
        return DB::transaction(function () use ($userId, $packageId) {

            // Lấy subscription mới nhất của user
            $current = RecruiterSubscriptionModel::where('user_id', $userId)
                ->whereIn('status', ['pending', 'active'])
                ->orderByDesc('subscription_id')
                ->first();

            /**
             * TRƯỜNG HỢP 4: ĐANG PENDING
             */
            if ($current && $current->status === 'pending') {
                throw ValidationException::withMessages([
                    'subscription' => 'You already have a pending subscription. Please complete payment first.'
                ]);
            }

            /**
             * TRƯỜNG HỢP 2: ACTIVE + SAME PACKAGE → GIA HẠN
             */
            if ($current && $current->status === 'active' && $current->package_id === $packageId) {

                $current->end_date = $current->end_date->addMonth();
                $current->save();
                $current->loadMissing('package');
                //check spam hóa đơn
                $pendingPayment = RecruiterPaymentModel::where('subscription_id', $current->subscription_id)
                    ->where('payment_status', 'pending')
                    ->first();

                if ($pendingPayment) {
                    return [
                        'action' => 'pending_payment_exists',
                        // 'subscription' => $current,
                        // 'payment' => $pendingPayment
                    ];
                }
                //Tạo hóa đơn recurring payment ở đây
                RecruiterPaymentModel::create([
                    'subscription_id' => $current->subscription_id,
                    'payment_status' => 'pending',
                    'payment_amount' => $current->package->price
                ]);
                return [
                    'action' => 'renew',
                    'subscription' => $current
                ];
            }

            /**
             * TRƯỜNG HỢP 3: ACTIVE + DIFFERENT PACKAGE → UPGRADE
             */
            if ($current && $current->status === 'active' && $current->package_id !== $packageId) {

                // Hết hiệu lực gói cũ
                $current->update([
                    'status' => 'expired',
                    'end_date' => now()
                ]);
                // Tạo gói mới
                $newSubscription = RecruiterSubscriptionModel::create([
                    'user_id' => $userId,
                    'package_id' => $packageId,
                    'start_date' => now(),
                    'end_date' => now()->addMonth(),
                    'status' => 'pending', // chờ thanh toán
                ]);
                //load lại kèm gói mới để lấy giá
                $newSubscription->loadMissing('package');
                //check hóa đơn spam
                $pendingPayment = RecruiterPaymentModel::where('subscription_id', $newSubscription->subscription_id)
                    ->where('payment_status', 'pending')
                    ->first();

                if ($pendingPayment) {
                    return [
                        'action' => 'pending_payment_exists',
                        // 'subscription' => $newSubscription,
                        // 'payment' => $pendingPayment
                    ];
                }
                //Tạo hóa đơn recurring payment ở đây
                RecruiterPaymentModel::create([
                    'subscription_id' => $newSubscription->subscription_id,
                    'payment_status' => 'pending',
                    'payment_amount' => $newSubscription->package->price
                ]);

                return [
                    'action' => 'upgrade',
                    'subscription' => $newSubscription
                ];
            }

            /**
             * TRƯỜNG HỢP 1: CHƯA CÓ SUBSCRIPTION → ĐĂNG KÝ MỚI
             */
            $subscription = RecruiterSubscriptionModel::create([
                'user_id' => $userId,
                'package_id' => $packageId,
                'start_date' => now(),
                'end_date' => now()->addMonth(),
                'status' => 'pending',
            ]);
            $subscription->loadMissing('package');
            //Tạo hóa đơn recurring payment ở đây
            RecruiterPaymentModel::create([
                'subscription_id' => $subscription->subscription_id,
                'payment_status' => 'pending',
                'payment_amount' => $subscription->package->price
            ]);
            return [
                'action' => 'new',
                'subscription' => $subscription
            ];
        });
    }
}
