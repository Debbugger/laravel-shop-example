<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($request->is('*admin*')) {
            if (!Auth::check() || !Auth::user()->hasRole('admin')) {
                return redirect('/');
            }
        }

        return $next($request);
    }
}
