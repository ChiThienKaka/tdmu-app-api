<?php

namespace App\Features\Domain\Recruitment\Payments\Services;

use App\Features\Domain\Recruitment\Payments\Models\RecruiterPaymentModel;
use App\Features\Domain\Recruitment\Payments\Models\PaymentTransactionModel;

class VnpayIpnService
{
    protected string $hashSecret;

    public function __construct()
    {
        $this->hashSecret = config('vnpay.hash_secret');
    }

    public function handle(array $query): array
    {
        $inputData = [];

        // ===== 1. Lấy dữ liệu vnp_ giống VNPAY =====
        foreach ($query as $key => $value) {
            if (substr($key, 0, 4) === 'vnp_') {
                $inputData[$key] = $value;
            }
        }

        $vnpSecureHash = $inputData['vnp_SecureHash'] ?? '';
        unset($inputData['vnp_SecureHash']);

        // ===== 2. Sort & build hash giống VNPAY =====
        ksort($inputData);

        $hashData = '';
        $i = 0;
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . '=' . urlencode($value);
            } else {
                $hashData .= urlencode($key) . '=' . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $this->hashSecret);

        // ===== 3. Check chữ ký =====
        if ($secureHash !== $vnpSecureHash) {
            return $this->response('97', 'Invalid signature');
        }

        // ===== 4. Lấy thông tin giao dịch =====
        $transactionId = $inputData['vnp_TxnRef'] ?? null;
        $amount         = ($inputData['vnp_Amount'] ?? 0) / 100;

        // ===== 5. Check đơn hàng (DB) =====
        $transaction = PaymentTransactionModel::where('transaction_id', $transactionId)->first();
        if (!$transaction) {
            return $this->response('01', 'Transaction not found');
        }

        $payment = RecruiterPaymentModel::with('subscription.package')
        ->where('subscription_id', $transaction->subscription_id)->first();
        // lấy gói đã đăng ký
        $recruiter_subscription = $payment?->subscription;
        //lấy thông tin gói
        $package = $payment?->subscription?->package;
        if (!$payment) {
            return $this->response('01', 'Order not found');
        }

        if ((float) $payment->payment_amount !== (float) $amount) {
            return $this->response('04', 'Invalid amount');
        }

        if ($payment->payment_status !== 'pending') {
            return $this->response('02', 'Order already confirmed');
        }

        // ===== 6. Xử lý kết quả thanh toán =====
        if (
            ($inputData['vnp_ResponseCode'] ?? '') === '00' &&
            ($inputData['vnp_TransactionStatus'] ?? '') === '00'
        ) {
            $payment->update([
                'payment_status'                => 'completed',
                'paid_at'               => now(),
                'payment_method'        => $inputData['vnp_BankCode'] ?? null,
                // 'vnp_transaction_no' => $inputData['vnp_TransactionNo'] ?? null,
            ]);
            $transaction->update([
                'transaction_code' => $inputData['vnp_TransactionNo'] ?? null,
                'status' => 'completed',
            ]);
            // Cập nhật trạng thái subscription lấy thời gian của gói
            if ($recruiter_subscription) {
                $recruiter_subscription->update([
                    'status' => 'active',
                    'start_date' => now(),
                    'end_date' => now()->addDays($package->duration_days), // Giả sử gia hạn 1 tháng
                ]);
            }
        } else {
            $payment->update([
                'payment_status' => 'failed',
            ]);
            $transaction->update([
                'status' => 'failed',
            ]);
        }

        // ===== 7. Trả kết quả cho VNPAY =====
        return $this->response('00', 'Confirm Success');
    }

    private function response(string $code, string $message): array
    {
        return [
            'RspCode' => $code,
            'Message' => $message,
        ];
    }
}
