<?php

namespace App\Features\Domain\Admin\Services;

use App\Features\Domain\Recruitment\Payments\Models\RecruiterPaymentModel;

class AdminPaymentService
{
    public function __construct() {}

    // Lấy danh sách thanh toán (filter theo payment_status)
    public function listPayments(string $payment_status = null, int $perPage = 20)
    {
        $query = RecruiterPaymentModel::with(['subscription.package', 'subscription.user'])
            ->orderByDesc('created_at');

        if ($payment_status) {
            $query->where('payment_status', $payment_status);
        }

        return $query->paginate($perPage);
    }

    // Chi tiết một giao dịch thanh toán
    public function getDetail(int $payment_id)
    {
        return RecruiterPaymentModel::with(['subscription.package', 'subscription.user'])
            ->find($payment_id);
    }
}
