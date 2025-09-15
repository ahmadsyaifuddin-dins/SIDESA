<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsSuperAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login DAN rolenya adalah 'superadmin'
        if (! $request->user() || $request->user()->role !== 'superadmin') {
            // Jika tidak, tolak akses
            abort(403, 'AKSES DITOLAK');
        }

        return $next($request);
    }
}