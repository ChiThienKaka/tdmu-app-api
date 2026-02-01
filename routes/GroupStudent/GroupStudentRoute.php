<?php

use Illuminate\Support\Facades\Route;
use App\Features\Domain\GroupStudent\Controllers\GroupMessageController;

Route::middleware('auth:api')->post('create-group-message', [GroupMessageController::class, 'createGroupMessage']);
