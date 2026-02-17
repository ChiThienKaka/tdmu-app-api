<?php
use Illuminate\Support\Facades\Route;
use App\Features\Domain\JobApplication\Controllers\JobApplicationController;
Route::prefix('job-application')
    ->middleware(['auth:api','role:2,3'])
    ->group(function () {
        Route::post('/submit-cv', [JobApplicationController::class, 'createJobApplicationFormCV']);
        Route::post('/submit-profile-cv', [JobApplicationController::class, 'createJobApplicationProfileCV']);
    });
