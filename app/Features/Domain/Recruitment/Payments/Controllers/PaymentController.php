<?php
namespace App\Features\Domain\Recruitment\Payments\Controllers;
use App\Features\Domain\Recruitment\Payments\Services\PaymentService;
use App\Features\Domain\Recruitment\Payments\Services\VnPayService;
use App\Features\Domain\Recruitment\Payments\Services\VnpayIpnService;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;

class PaymentController extends Controller
{
    public function __construct(
        protected PaymentService $paymentService,
        protected VnPayService $vnPayService,
        protected VnpayIpnService $vnPayIpnService
    ) {}


    // tạo đơn thanh toán
    public function createPaymentVnPay(FormRequest $request)
    {
        $user = auth('api')->user();
        $subsriptionId = $request->input('subscription_id');
        $payment = $this->vnPayService->createPayment($subsriptionId);
        return response()->json([
            'payment_url' => $payment,
            'user'      => $user,
        ]);
    }
    // xử lý IPN từ VNPAY
    public function handleVnpayIpn(FormRequest $request)
    {
        $result = $this->vnPayIpnService->handle($request->query());
        return response()->json($result);
    }

    public function paymentCallback(FormRequest $request)
    {
        $paymentStatus = $request->input('payment_status');
        $transactionCode = $request->input('transaction_code');

        if ($paymentStatus === 'success') {
            $this->paymentService->confirmPaymentSuccess(
                $transactionCode,
                $request->all()
            );
        } else {
            $this->paymentService->failPayment(
                $transactionCode,
                $request->all()
            );
        }

        return response()->json(['message' => 'Payment processed']);
    }

}