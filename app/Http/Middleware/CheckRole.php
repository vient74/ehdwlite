<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Ambil role ID pengguna yang sedang login
        $userRole = Auth::check() ? Auth::user()->role_id : null;
 
        // Periksa jika role ID pengguna cocok dengan salah satu role yang dibutuhkan
        if ($userRole && in_array($userRole, $roles)) {
            return $next($request);
        }

        // Jika tidak memenuhi syarat, alihkan ke halaman forbidden
        return redirect()->route('forbidden');
    }
}

