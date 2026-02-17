<?php

use Illuminate\Support\Facades\Route;
use App\Features\Domain\PostContext\Controllers\PostController;

Route::middleware(['auth:api','role:2,3'])->group(function () {
    Route::post('create-post', [PostController::class, 'createPost']);
    Route::get('posts-media', [PostController::class, 'getPosts']);
});
