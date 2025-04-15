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

        // Récupérer toutes les offres publiées
        $allOffers = Offre::with(['company', 'skills', 'languages'])
            ->where('statut', 'publiée')
            ->get();

        // filtrer les offres avec score de matching plus que 50%
        $matchedOffers = collect();
        foreach ($allOffers as $offre) {
            $score = $this->matchService->calculate($resume, $offre);
            if ($score >= 1) {
                $offre->match_score = $score;
                $matchedOffers->push($offre);
            }
        }

        // Classer les offres par score
        $jobs = $matchedOffers->sortByDesc('match_score');

        // Si une offre spécifique est demandée, la récupérer
        $selectedJob = null;
        if ($request->has('job_id')) {
            $selectedJob = Offre::with(['company', 'skills', 'languages'])
                ->where('id', $request->job_id)
                ->where('statut', 'publiée')
                ->first();
        }
        
        return view('candidat.pageaccueil', compact('jobs', 'selectedJob'));

    }


}
