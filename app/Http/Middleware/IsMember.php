<?php
// app/Http/Middleware/IsMember.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsMember
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'member') {
            return $next($request);
        }

        abort(403, 'Unauthorized. Members only.');
    }
}
