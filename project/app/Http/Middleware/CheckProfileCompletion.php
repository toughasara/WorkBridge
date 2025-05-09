<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckProfileCompletion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($role === 'recruteur') {
            if (!$user->company) {
                return redirect()->route('recruter.completeProfile');
            }
        }

        if ($role === 'candidat') {
            if (!$user->resume) { 
                return redirect()->route('candidat.completeProfile');
            }
        }

        // Si le profil est complété, autorise l'accès à la route demandée
        return $next($request);
    }
}
