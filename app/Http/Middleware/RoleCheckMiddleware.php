<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleCheckMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Ganti dengan ID role yang ingin Anda periksa
        $requiredRoleId = 'acf6f46d-1c53-4e4a-8e35-92fa21e20fc8';
     

        if (Auth::check() && Auth::user()->role_id === $requiredRoleId) {
            return $next($request);
        }

        return redirect()->route('forbidden'); 
    }
}
