<?php

namespace App\Http\Controllers\Candidat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offre;
use App\Models\Resume;
use App\Services\MatchService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        try {
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
                'html' => view('candidat.partials.offer_details', compact('offer'))->render()
            ]);
            
        } catch (\Exception $e) {
            \Log::error("Erreur dans getOfferDetails: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur serveur'
            ], 500);
        }
    }

    public function search(Request $request)
    {
        \Log::info('Search function called');
        \Log::info('Request parameters: ', $request->all());
        dd("test");
        try {
            $user = Auth::user();
            $resume = Resume::where('user_id', $user->id)->first();

            if (!$resume) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Veuillez d\'abord créer votre CV pour voir les offres recommandées.',
                        'redirect' => route('resume.create')
                    ]);
                }
                
                return redirect()->route('resume.create')
                    ->with('warning', 'Veuillez d\'abord créer votre CV pour voir les offres recommandées.');
            }

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

            // Récupérer les offres filtrées
            $filteredOffers = $query->get();

            // Calculer le score de matching pour chaque offre
            $matchedOffers = collect();
            foreach ($filteredOffers as $offre) {
                $score = $this->matchService->calculate($resume, $offre);
                $offre->match_score = $score;
                $matchedOffers->push($offre);
            }

            // Trier par score de matching (du plus élevé au plus bas)
            $jobs = $matchedOffers->sortByDesc('match_score');

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'html' => view('candidat.partials.job_list', compact('jobs'))->render(),
                    'count' => $jobs->count()
                ]);
            }

            return view('candidat.pageaccueil', compact('jobs'));
        } catch (\Exception $e) {
            \Log::error("Erreur dans search: " . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Une erreur est survenue lors de la recherche: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Une erreur est survenue lors de la recherche.');
        }
    }

}
