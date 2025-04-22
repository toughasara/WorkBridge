<?php

namespace App\Http\Controllers\Candidat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offre;
use App\Models\Resume;
use App\Services\MatchService;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    protected $matchService;

    public function __construct(MatchService $matchService)
    {
        $this->matchService = $matchService;
    }

    // affichier les offres d'emploie recommander qui on plus de 50% de scor de matching
    public function index(Request $request)
    {
        $user = Auth::user();
        $resume = Resume::where('user_id', $user->id)->first();

        if (!$resume) {
            return redirect()->route('resume.create')
                ->with('warning', 'Veuillez d\'abord créer votre CV pour voir les offres recommandées.');
        }

        // recuperer toutes les offres publiées
        $allOffers = Offre::with(['company', 'skills', 'languages'])
            ->where('statut', 'publiée')
            ->get();

        // filter les offres avec score de matching plus que 50%
        $matchedOffers = collect();
        foreach ($allOffers as $offre) {
            $score = $this->matchService->calculate($resume, $offre);
            if ($score >= 1) {
                $offre->match_score = $score;
                $matchedOffers->push($offre);
            }
        }

        // classer les offres par score
        $jobs = $matchedOffers->sortByDesc('match_score');

        
        return view('candidat.pageaccueil', compact('jobs'));

    }

    public function getOfferDetails($id)
    {
        // try {
            $offer = Offre::with(['company', 'skills', 'languages'])
                ->where('id', $id)
                ->where('statut', 'publiée')
                ->first();

            if (!$offer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Offre non trouvée ou non publiée'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'html' => view('candidat.offerdetails', compact('offer'))->render()
            ]);
            
        // } catch (\Exception $e) {
        //     \Log::error("Erreur dans getOfferDetails: " . $e->getMessage());
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Erreur serveur'
        //     ], 500);
        // }
    }

    public function search(Request $request)
    {
        $query = Offre::with(['company', 'skills', 'languages'])
            ->where('statut', 'publiée');

        // Filtrer par mots-clés
        if ($request->has('keywords') && !empty($request->keywords)) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->keywords . '%')
                    ->orWhereHas('company', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->keywords . '%');
                })
                ->orWhere('location', 'like', '%' . $request->keywords . '%');
            });
        }

        // Filtrer par lieu
        if ($request->has('location') && !empty($request->location)) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // Trier par date de publication
        $offers = $query->orderBy('created_at', 'desc')->get();

        return view('candidat.pageaccueil', compact('offers'));    
    }

}
