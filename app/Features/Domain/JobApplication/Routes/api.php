<?php
use Illuminate\Support\Facades\Route;
use App\Features\Domain\JobApplication\Controllers\JobApplicationController;
Route::prefix('job-application')->group(function(){
    Route::middleware(['auth:api','role:2,3'])
    ->group(function () {
        Route::post('/submit-cv', [JobApplicationController::class, 'createJobApplicationFormCV']);
        Route::post('/submit-profile-cv', [JobApplicationController::class, 'createJobApplicationProfileCV']);
    });
    Route::middleware(['auth:api','role:4'])
    ->group(function () {
        Route::get('/list-applicant', [JobApplicationController::class, 'getApplicantbyPostid']);
        Route::post('/update-applicant', [JobApplicationController::class, 'updateApplicantByRecruiter']);
    });
});