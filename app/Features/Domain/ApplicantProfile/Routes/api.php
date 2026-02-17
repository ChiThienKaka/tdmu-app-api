<?php
use Illuminate\Support\Facades\Route;
use App\Features\Domain\ApplicantProfile\Controllers\StudentProfileController;
Route::prefix('applicant-profile')
    ->middleware(['auth:api','role:2,3'])
    ->group(function () {
        Route::get('/info', [StudentProfileController::class, 'getStudentProfile']);
        Route::post('/update', [StudentProfileController::class, 'updateStudentProfile']);
    });
