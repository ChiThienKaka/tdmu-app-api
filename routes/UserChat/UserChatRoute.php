<?php

use Illuminate\Support\Facades\Route;
use App\Features\Domain\UserChat\Controllers\UserChatController;

Route::middleware(['auth:api','role:2,3'])->group(function () {
    Route::post('send-message', [UserChatController::class, 'sendMessage']);
    Route::get('conversation/{other_user_id}', [UserChatController::class, 'getConversation']);
    Route::get('recent-conversations', [UserChatController::class, 'getRecentConversations']);
    Route::delete('delete-message/{message_id}', [UserChatController::class, 'deleteMessage']);
});
