<?php
use Illuminate\Support\Facades\Route;
use App\Features\Domain\Recruitment\Payments\Controllers\PaymentController;

Route::prefix('recruiter-payments')
    ->middleware(['auth:api', 'role:4'])
    ->group(function () {
        // Tạo đơn thanh toán
        Route::get('/create-vnpay', [PaymentController::class, 'createPaymentVnPay']);
    });
Route::prefix('recruiter-payments')
    ->group(function () {
        Route::get('/vnpay-ipn', [PaymentController::class, 'handleVnpayIpn']);
    });