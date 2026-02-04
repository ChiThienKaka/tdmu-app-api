<?php

use Illuminate\Support\Facades\Route;
use App\Features\Domain\GroupStudent\Controllers\GroupMessageController;
use App\Features\Domain\GroupStudent\Controllers\GroupStudentController;

Route::middleware('auth:api')->post('create-group-message', [GroupMessageController::class, 'createGroupMessage']);
Route::middleware('auth:api')->get('get-group-students-by-user', [GroupStudentController::class, 'getGroupStudentsByUser']);