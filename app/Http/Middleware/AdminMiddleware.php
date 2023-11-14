<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated and has the admin role (role == 1)
        if (auth()->check() && auth()->user()->role == 1) {
            return $next($request);
        }

        // If the user is not an admin, return a 403 Forbidden response
        abort(403, 'Unauthorized action.');
    }
}
