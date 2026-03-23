<?php
use Illuminate\Support\Facades\Route;
use App\Features\Domain\Admin\Controllers\CompanyApprovedController;
use App\Features\Domain\Admin\Controllers\JobPostApprovedController;
use App\Features\Domain\Admin\Controllers\AdminPackageController;
use App\Features\Domain\Admin\Controllers\AdminSubscriptionController;
use App\Features\Domain\Admin\Controllers\AdminPaymentController;
use App\Features\Domain\Admin\Controllers\AdminUserController;
use App\Features\Domain\Admin\Controllers\AdminDashboardController;

Route::prefix('admin')->group(function(){
    Route::middleware(['auth:api', 'role:1'])
        ->group(function () {
            // 1. Quản lý công ty tuyển dụng
            Route::prefix('company')->group(function () {
                Route::get('/list', [CompanyApprovedController::class, 'ListRecruiterCompany']);
                Route::get('/{company_id}', [CompanyApprovedController::class, 'show']);
                Route::patch('/{company_id}/verify', [CompanyApprovedController::class, 'verify']);
                Route::delete('/{company_id}', [CompanyApprovedController::class, 'destroy']);
            });

            // 2. Quản lý bài đăng tuyển dụng
            Route::prefix('job-post')->group(function () {
                Route::get('/list', [JobPostApprovedController::class, 'listJobPosts']);
                Route::get('/stats', [JobPostApprovedController::class, 'stats']);
                Route::get('/{job_id}', [JobPostApprovedController::class, 'show']);
                Route::patch('/{job_id}/status', [JobPostApprovedController::class, 'updateJobPostStatus']);
                Route::delete('/{job_id}', [JobPostApprovedController::class, 'destroy']);
            });

            // 3. Quản lý gói dịch vụ (Package)
            Route::prefix('package')->group(function () {
                Route::get('/', [AdminPackageController::class, 'index']);
                Route::post('/', [AdminPackageController::class, 'store']);
                Route::get('/{package_id}', [AdminPackageController::class, 'show']);
                Route::put('/{package_id}', [AdminPackageController::class, 'update']);
                Route::patch('/{package_id}/toggle', [AdminPackageController::class, 'toggle']);
                Route::delete('/{package_id}', [AdminPackageController::class, 'destroy']);
            });

            // 4. Quản lý gói đăng ký (Subscription)
            Route::prefix('subscription')->group(function () {
                Route::get('/', [AdminSubscriptionController::class, 'index']);
                Route::get('/{id}', [AdminSubscriptionController::class, 'show']);
                Route::patch('/{id}/activate', [AdminSubscriptionController::class, 'activate']);
            });

            // 5. Quản lý thanh toán (Payment)
            Route::prefix('payment')->group(function () {
                Route::get('/', [AdminPaymentController::class, 'index']);
                Route::get('/{id}', [AdminPaymentController::class, 'show']);
            });

            // 6. Quản lý người dùng (User)
            Route::prefix('user')->group(function () {
                Route::get('/', [AdminUserController::class, 'index']);
                Route::get('/{id}', [AdminUserController::class, 'show']);
                Route::patch('/{id}/ban', [AdminUserController::class, 'toggleBan']);
                Route::delete('/{id}', [AdminUserController::class, 'destroy']);
            });

            // 7. Dashboard
            Route::prefix('dashboard')->group(function () {
                Route::get('/overview', [AdminDashboardController::class, 'overview']);
                Route::get('/revenue', [AdminDashboardController::class, 'revenue']);
                Route::get('/trend', [AdminDashboardController::class, 'trend']);
            });
            
            // Tương thích với route cũ (Legacy Support)
            Route::get('/list-company-approved', [CompanyApprovedController::class, 'ListRecruiterCompany']);
            Route::get('/list-job-post-approved', [JobPostApprovedController::class, 'listJobPosts']);
            Route::patch('/update-job-post-status/{job_id}', [JobPostApprovedController::class, 'updateJobPostStatus']);
        });
});


