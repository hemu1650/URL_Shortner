<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;

class MiddlewareServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Register custom middleware alias
        Route::aliasMiddleware('role', RoleMiddleware::class);
    }
}

