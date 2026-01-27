<?php
use Illuminate\Support\Facades\Route;
use App\Features\Domain\CommentPost\Controllers\CommentController;

Route::middleware('auth:api')->post('create-comment', [CommentController::class, 'createCommentPost']);
Route::middleware('auth:api')->get('parents-comment', [CommentController::class, 'getCommentParent']);
Route::middleware('auth:api')->get('replies-comment', [CommentController::class, 'getReplyComment']);