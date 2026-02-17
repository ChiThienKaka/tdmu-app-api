<?php
use Illuminate\Support\Facades\Route;
use App\Features\Domain\JobPostings\Controllers\JobPostingsController;
use App\Features\Domain\JobPostings\Controllers\JobCategoryController;
Route::prefix('job-post')
    ->middleware(['auth:api'])
    ->group(function () {
        Route::get('/list', [JobPostingsController::class, 'getStoreJobPost']);
        Route::get('/list-detail', [JobPostingsController::class, 'getStoreJobPostDetail']);

        //categroy
         Route::get('/list-category', [JobCategoryController::class, 'listJobCategoryParent']);
    });
