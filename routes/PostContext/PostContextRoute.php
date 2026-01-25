<?php

use Illuminate\Support\Facades\Route;
use App\Features\Domain\PostContext\Controllers\PostController;

Route::middleware('auth:api')->post('create-post', [PostController::class, 'createPost']);
Route::middleware('auth:api')->get('posts-media', [PostController::class, 'getPosts']);