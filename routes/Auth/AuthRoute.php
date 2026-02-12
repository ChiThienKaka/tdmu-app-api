<?php

use Illuminate\Support\Facades\Route;
use App\Features\Domain\Auth\Controllers\AuthController;
use App\Features\Domain\Auth\Controllers\AuthRecruiterController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('login/google', [AuthController::class, 'loginWithGoogle']);
Route::get('user/info', [AuthController::class, 'me'])->middleware('auth:api');

// tuyển dụng
Route::post('register-recruiter', [AuthRecruiterController::class, 'registerRecruiter']);
Route::post('recruiter-login/google', [AuthRecruiterController::class, 'loginWithGoogle']);