<?php
use Illuminate\Support\Facades\Route;
use App\Features\Domain\JobPostings\Controllers\JobPostingsController;
Route::prefix('job-post')
    ->middleware(['auth:api'])
    ->group(function () {
        Route::get('/list', [JobPostingsController::class, 'getStoreJobPost']);
        Route::get('/list-detail', [JobPostingsController::class, 'getStoreJobPostDetail']);
    });
