<?php

namespace App\Http\Middleware;

use Closure;

class PelangganSessionAuth
{
    public function handle($request, Closure $next)
    {
        if (!session('pelanggan_id')) {
            if ($request->routeIs('login') || $request->routeIs('register') || $request->is('login') || $request->is('register')) {
                return $next($request);
            }
            return redirect()->route('login');
        }
        return $next($request);
    }
} 