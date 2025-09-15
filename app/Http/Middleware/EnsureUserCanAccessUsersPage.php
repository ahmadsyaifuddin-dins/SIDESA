<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserCanAccessUsersPage
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login DAN rolenya adalah 'superadmin' ATAU 'pimpinan'
        if (! $request->user() || ! in_array($request->user()->role, ['superadmin', 'pimpinan'])) {
            // Jika tidak, tolak akses
            abort(403, 'AKSES DITOLAK');
        }

        return $next($request);
    }
}