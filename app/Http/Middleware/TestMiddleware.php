<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
    dd('Test middleware working');
        // You can add any logic here that you want to execute before the request is handled
        // For example, you can check for certain conditions or modify the request

        // Call the next middleware or controller
        return $next($request);
    }
}
