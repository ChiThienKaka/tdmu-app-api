<?php
use Illuminate\Support\Facades\Route;
use App\Features\Domain\Admin\Controllers\CompanyApprovedController;

Route::prefix('admin')->group(function(){
    Route::middleware(['auth:api', 'role:1'])
        ->group(function () {
            Route::get('/list-company-approved', [CompanyApprovedController::class, 'ListRecruiterCompany']);
        });
        // Route::middleware(['auth:api','role:4'])
        //     ->group(function () {
        //     });
});
