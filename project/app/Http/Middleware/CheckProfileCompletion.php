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

        // Vérification si l'utilisateur a un profil complet
        if ($role === 'recruteur') {
            // Si l'utilisateur est recruteur, vérifie s'il a des informations sur l'entreprise
            if (!$user->company) { // Vérifie s'il a un enregistrement dans la table company
                return redirect()->route('recruter.completeProfile');
            }
        }

        if ($role === 'candidat') {
            // Si l'utilisateur est candidat, vérifie s'il a un CV
            if (!$user->resume) { // Vérifie s'il a un enregistrement dans la table resume
                return redirect()->route('candidat.completeProfile');
            }
        }

        // Si le profil est complété, autorise l'accès à la route demandée
        return $next($request);
    }
}
