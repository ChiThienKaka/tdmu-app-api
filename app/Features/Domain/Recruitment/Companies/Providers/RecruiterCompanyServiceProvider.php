<?php

namespace App\Features\Domain\Recruitment\Companies\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class RecruiterCompanyServiceProvider extends ServiceProvider
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
