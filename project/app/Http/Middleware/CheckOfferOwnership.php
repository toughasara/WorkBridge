<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckOfferOwnership
{
    public function handle($request, Closure $next)
    {
        $offer = $request->route('offer');

        if (!$offer) {
            abort(404, 'Offre non trouvée.');
        }

        if (is_string($offer)) {
            $offer = \App\Models\Offre::findOrFail($offer);
        }

        if ($offer->user_id !== Auth::id()) {
            abort(403, 'Vous ne pouvez pas accéder à cette offre.');
        }

        return $next($request);
    }
}