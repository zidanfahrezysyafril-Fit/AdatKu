<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // SESUAIKAN dengan struktur tabel users kamu
        // contoh: kalau kamu punya kolom 'role' berisi 'admin' / 'user'
        if (!Auth::check() || Auth::user()->role !== 'Admin') {
            // bisa redirect atau abort
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
