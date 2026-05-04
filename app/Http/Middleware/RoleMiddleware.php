<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Cek apakah role user sesuai dengan yang diminta di route
        if ($request->user()->role !== $role) {
            abort(403, 'Akses Ditolak! Halaman ini khusus ' . strtoupper($role));
        }

        return $next($request);
    }
}