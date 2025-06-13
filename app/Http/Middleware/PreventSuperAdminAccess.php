<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreventSuperAdminAccess
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'superadmin') {
            abort(403, 'SuperAdmin is not allowed to access this page.');
        }

        return $next($request);
    }
}
