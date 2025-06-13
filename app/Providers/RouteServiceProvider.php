<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/dashboard';

    public function boot()
    {
        $this->configureRateLimiting();

        Route::middleware('web')
            ->group(base_path('routes/web.php'));

        // 👇 Handle login redirect per role
        \Illuminate\Support\Facades\Route::get('/redirect', function () {
            $user = Auth::user();

            if ($user->role === 'superadmin') {
                return redirect('/superadmin/dashboard');
            } elseif ($user->role === 'admin') {
                return redirect('/admin/dashboard');
            } elseif ($user->role === 'member') {
                return redirect('/urls');
            }

            return redirect(self::HOME); // fallback
        });
    }
}
