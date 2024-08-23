<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $roleId)
    {
        if (Auth::check()) {
            // Ambil role pengguna yang sedang login
            $userRole = Auth::user()->role_id;
            if ($userRole === $roleId) {
                return $next($request);
            }
        }
        return redirect()->route('forbidden');
    }
}

