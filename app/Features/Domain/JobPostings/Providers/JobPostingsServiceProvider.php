<?php

namespace App\Features\Domain\JobPostings\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class JobPostingsServiceProvider extends ServiceProvider
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
