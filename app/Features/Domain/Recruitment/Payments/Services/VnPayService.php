<?php
namespace App\Features\Domain\Recruitment\Payments\Services;
use App\Features\Domain\Recruitment\Payments\Models\RecruiterPaymentModel;
use App\Features\Domain\Recruitment\Payments\Models\PaymentTransactionModel;
use App\Features\Domain\Recruitment\Subscriptions\Models\RecruiterSubscriptionModel;
use Illuminate\Support\Str;

class VnPayService
{
    public function createPayment($subscription_id, $routehome)
    {
        $subscription_payment = RecruiterPaymentModel::where('subscription_id', $subscription_id)
            ->where('payment_status', 'pending')
            ->first();
        if (!$subscription_payment) {
            throw new \Exception('Subscription payment not found');
        }
        $vnp_TmnCode = config('vnpay.tmn_code');
        $vnp_HashSecret = config('vnpay.hash_secret');
        $vnp_Url = config('vnpay.url');
        $vnp_ReturnUrl = $routehome ?? config('vnpay.return_url');

        // tạo bảng Payment transaction cho mỗi lần user bấm thanh toán
        $payment_transaction = PaymentTransactionModel::create([
            'subscription_id'   => $subscription_payment->subscription_id,
            'transaction_code'  => strtoupper(Str::random(12)),
            'payment_method'    => "vnpay",
            'amount'            => $subscription_payment->payment_amount,
            'status'            => 'pending',
            'created_at'        => now(),
            'ip_address'        => request()->ip(),
        ]);

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_Command" => "pay",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $subscription_payment->payment_amount * 100,
            "vnp_CreateDate" => now()->format('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => request()->ip(),
            "vnp_Locale" => "vn",
            "vnp_OrderInfo" => "Thanh toan hoa don {$subscription_payment->payment_id}",
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => $vnp_ReturnUrl,
            "vnp_BankCode" => "VNBANK", // mặc định là thanh toán qua ngân hàng
            "vnp_ExpireDate"=>now()->addMinutes(15)->format('YmdHis'),
            "vnp_TxnRef" => $payment_transaction->transaction_id,// mã giao dịch của mỗi lần thanh toán
        ];
        
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        return $vnp_Url;
    }
}
