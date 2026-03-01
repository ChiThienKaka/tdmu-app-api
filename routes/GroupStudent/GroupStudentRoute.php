<?php

use Illuminate\Support\Facades\Route;
use App\Features\Domain\GroupStudent\Controllers\GroupMessageController;
use App\Features\Domain\GroupStudent\Controllers\GroupStudentController;

Route::middleware(['auth:api','role:2,3'])->group(function () {
    Route::post('create-group-message', [GroupMessageController::class, 'createGroupMessage']);
    Route::get('get-group-students-by-user', [GroupStudentController::class, 'getGroupStudentsByUser']);
    Route::get('get-users-by-group/{group_id}', [GroupStudentController::class, 'getUsersByGroup']);
    Route::get('list-message-group', [GroupMessageController::class, 'getListMessageGroup']);
});
