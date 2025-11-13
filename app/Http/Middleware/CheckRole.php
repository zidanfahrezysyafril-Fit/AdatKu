<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::user();
        if (!$user) {
            abort(401);
        }

        $userRole = strtolower((string) $user->role);   // "MUA" -> "mua"
        $roles    = array_map('strtolower', $roles);    // ["mua","admin"] -> lower semua

        // izinkan admin juga walau tidak disebut eksplisit
        if (!in_array($userRole, $roles, true) && $userRole !== 'admin') {
            abort(403, 'Akses khusus MUA');
        }

        return $next($request);
    }
}
