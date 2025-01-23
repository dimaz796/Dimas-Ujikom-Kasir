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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Memeriksa apakah user sudah login dan memiliki peran 'admin'
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request); // Melanjutkan request jika peran 'admin'
        }

        // Jika bukan admin, abort dengan status 403 Unauthorized
        abort(403, 'Unauthorized');
    }
}
