<?php

use Illuminate\Support\Facades\Route;
use App\Features\Domain\RecruiterDashboard\Controllers\RecruiterJobPostController;
use App\Features\Domain\RecruiterDashboard\Controllers\RecruiterApplicationController;
use App\Features\Domain\RecruiterDashboard\Controllers\RecruiterCompanyController;
use App\Features\Domain\RecruiterDashboard\Controllers\RecruiterSubscriptionController;
use App\Features\Domain\RecruiterDashboard\Controllers\RecruiterDashboardController;

Route::prefix('recruiter')->middleware(['auth:api', 'role:4'])->group(function () {

    // 1. Dashboard – Thống kê tổng quan nhà tuyển dụng
    Route::prefix('dashboard')->group(function () {
        Route::get('/overview', [RecruiterDashboardController::class, 'overview']);
    });

    // 2. Quản lý bài đăng tuyển dụng
    Route::prefix('job-post')->group(function () {
        Route::get('/',              [RecruiterJobPostController::class, 'index']);
        Route::post('/',             [RecruiterJobPostController::class, 'store']);
        Route::get('/{job_id}',      [RecruiterJobPostController::class, 'show']);
        Route::put('/{job_id}',      [RecruiterJobPostController::class, 'update']);
        Route::delete('/{job_id}',   [RecruiterJobPostController::class, 'destroy']);
        Route::patch('/{job_id}/refresh', [RecruiterJobPostController::class, 'refresh']);

        // Danh sách ứng viên theo bài đăng
        Route::get('/{job_id}/applications', [RecruiterApplicationController::class, 'byJobPost']);
    });

    // 3. Quản lý đơn ứng tuyển
    Route::prefix('application')->group(function () {
        Route::get('/',           [RecruiterApplicationController::class, 'index']);
        Route::get('/{id}',       [RecruiterApplicationController::class, 'show']);
        Route::get('/by-job-post/{id}',       [RecruiterApplicationController::class, 'byJobPost']);
        Route::patch('/{id}/status',    [RecruiterApplicationController::class, 'updateStatus']);
        Route::post('/{id}/interview',  [RecruiterApplicationController::class, 'scheduleInterview']);
    });

    // 4. Thông tin công ty
    Route::prefix('company')->group(function () {
        Route::get('/',  [RecruiterCompanyController::class, 'show']);
        Route::put('/',  [RecruiterCompanyController::class, 'update']);
    });

    // 5. Gói đăng ký (Subscription)
    Route::prefix('subscription')->group(function () {
        Route::get('/',        [RecruiterSubscriptionController::class, 'current']);
        Route::get('/history', [RecruiterSubscriptionController::class, 'history']);
    });
});
