<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'AKSES DITOLAK. HALAMAN INI HANYA UNTUK ADMIN.');
        }

        return $next($request);
    }
}