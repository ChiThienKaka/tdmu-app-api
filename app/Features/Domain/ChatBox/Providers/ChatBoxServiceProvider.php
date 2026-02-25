<?php

namespace App\Features\Domain\ChatBox\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class ChatBoxServiceProvider extends ServiceProvider
{
     public function boot(): void
    {
        Route::middleware('api')
        ->prefix('api')
        ->group(__DIR__ . '/../Routes/api.php');
    }
    public function register(): void
    {

    }
}
