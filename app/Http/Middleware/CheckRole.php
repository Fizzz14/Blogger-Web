<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Please login to continue.');
        }

        $user = Auth::user();

        foreach ($roles as $role) {
            if ($role === 'admin' && $user->isAdmin()) {
                return $next($request);
            }

            if ($role === 'staff' && ($user->isStaff() || $user->isAdmin())) {
                return $next($request);
            }
        }

        return redirect('/dashboard')->with('error', 'Unauthorized access.');
    }
}
