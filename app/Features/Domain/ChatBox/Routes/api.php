<?php
use Illuminate\Support\Facades\Route;
use App\Features\Domain\ChatBox\Controllers\ChatBoxController;
Route::prefix('chat-box')->group(function(){
    Route::middleware(['auth:api'])
    ->group(function () {
        Route::post('/search', [ChatBoxController::class, 'debugSearch']);
        Route::get('/recent-messages', [ChatBoxController::class, 'getgetRecentMessages']);
    });
    Route::middleware(['auth:api','role:4'])
    ->group(function () {

    });
});