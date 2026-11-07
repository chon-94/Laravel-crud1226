<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        // Si la sesión dice que es admin, lo deja pasar
        if (session('es_admin') === true) {
            return $next($request);
        }

        // Si no, lo manda al login
        return redirect()->route('admin.login');
    }
}