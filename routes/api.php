<?php

use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(base_path('routes/Auth/AuthRoute.php'));
Route::prefix('post-context')->group(base_path('routes/PostContext/PostContextRoute.php'));