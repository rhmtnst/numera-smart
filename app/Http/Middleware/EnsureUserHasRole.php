<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        abort_unless($request->user() && $request->user()->role === $role, 403, 'Anda tidak memiliki hak akses ke halaman ini.');
        abort_if(isset($request->user()->is_active) && !$request->user()->is_active, 403, 'Akun Anda sedang dinonaktifkan.');
        return $next($request);
    }
}
