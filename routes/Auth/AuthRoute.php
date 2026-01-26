<?php

use Illuminate\Support\Facades\Route;
use App\Features\Domain\Auth\Controllers\AuthController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('login/google', [AuthController::class, 'loginWithGoogle']);