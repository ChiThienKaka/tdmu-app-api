<?php
use Illuminate\Support\Facades\Route;
use App\Features\Domain\CommentPost\Controllers\CreateCommentController;

Route::middleware('auth:api')->post('create-comment', [CreateCommentController::class, 'createCommentPost']);