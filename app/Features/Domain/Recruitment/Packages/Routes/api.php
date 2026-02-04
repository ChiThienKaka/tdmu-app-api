<?php
use Illuminate\Support\Facades\Route;
use App\Features\Domain\Recruitment\Packages\Controllers\RecruiterController;

Route::prefix('recruiter-packages')
    ->group(function () {
        // Lấy danh sách gói (public)
        Route::get('/', [RecruiterController::class, 'getRecruiterPackages_isActive']);
    });
