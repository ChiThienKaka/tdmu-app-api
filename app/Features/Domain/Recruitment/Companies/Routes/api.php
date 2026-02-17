<?php
use Illuminate\Support\Facades\Route;
use App\Features\Domain\Recruitment\Companies\Controllers\RecruiterCompanyController;


Route::prefix('recruiter-companies')
    ->group(function () {
        // Lấy danh sách công ty đã xác thực (public)
        Route::get('/', [RecruiterCompanyController::class, 'getVerifiedCompanies']);
        //PROTECTED — cần auth
        Route::middleware(['auth:api', 'role:4'])->group(function () {
            Route::get('/info-company', [RecruiterCompanyController::class, 'getInfoComapanyUser']);
            Route::post('/update', [RecruiterCompanyController::class, 'updateRecruiterCompany']);
        });
    });
