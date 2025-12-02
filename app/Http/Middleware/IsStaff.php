<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && (Auth::user()->isStaff() || Auth::user()->isAdmin())) {
            return $next($request);
        }

        return redirect('/dashboard')->with('error', 'Unauthorized access. Staff or Admin privileges required.');
    }
}
