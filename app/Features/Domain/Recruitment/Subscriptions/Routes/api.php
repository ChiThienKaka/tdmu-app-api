<?php
use Illuminate\Support\Facades\Route;
use App\Features\Domain\Recruitment\Subscriptions\Controllers\RecruiterSubscriptionController;

Route::prefix('recruiter-subscriptions')
    ->middleware(['auth:api', 'role:4'])
    ->group(function () {
        // Đăng ký gói cho nhà tuyển dụng
        Route::post('/subscribe', [RecruiterSubscriptionController::class, 'subscribeRecruiter']);
        // Lấy gói đang chờ xử lý thanh toán của user
        Route::get('/user/pending', [RecruiterSubscriptionController::class, 'getUserPendingSubscription']);
        // Lấy subscription đang active của user (public / hoặc private tuỳ config)
        Route::get('/user/{userId}/active', [RecruiterSubscriptionController::class, 'getUserActiveSubscriptions']);
    });
