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

        $userRole = strtolower((string) $user->role);
        $roles    = array_map('strtolower', $roles);

        // jika bukan role yang diperbolehkan dan bukan admin
        if (!in_array($userRole, $roles, true) && $userRole !== 'admin') {

            $needed = strtoupper($roles[0] ?? 'USER');

            abort(403, "Akses khusus {$needed}");
        }

        return $next($request);
    }
}
