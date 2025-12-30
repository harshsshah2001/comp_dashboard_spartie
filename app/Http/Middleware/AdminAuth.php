<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAuth
{
    public function handle($request, Closure $next)
    {
        // Check admin guard, NOT session
        if (!Auth::guard('userlist')->check()) {
            return redirect()->route('loginform');
        }

        return $next($request);
    }
}
