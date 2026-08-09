<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RolePelanggan
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        if (auth()->user()->role !== UserRole::PELANGGAN) {
            return redirect('/admin');
        }
        return $next($request);
    }
}
