<?php
use Illuminate\Support\Facades\Route;
use App\Features\Domain\CommentPost\Controllers\CommentController;

Route::middleware(['auth:api','role:2,3'])->group(function () {
    Route::post('create-comment', [CommentController::class, 'createCommentPost']);
    Route::get('parents-comment', [CommentController::class, 'getCommentParent']);
    Route::get('replies-comment', [CommentController::class, 'getReplyComment']);
});

