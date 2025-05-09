<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check() || Auth::user()->role->title !== $role) {
            abort(403, 'Accès interdit.');
        }

        return $next($request);
    }
}