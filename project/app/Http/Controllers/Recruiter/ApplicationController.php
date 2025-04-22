<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Offre;
use App\Models\Resume;
use App\Models\Cv;
use Illuminate\Support\Facades\Storage;
use App\Services\MatchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    protected $matchService;

    public function __construct(MatchService $matchService)
    {
        $this->matchService = $matchService;
    }
    /**
     * Affiche la liste des candidatures pour une offre
     */
    public function index(Request $request, $offerId = null)
    {
        $user = Auth::user();
        $offres = Offre::where('user_id', $user->id)->withCount('applications')->get();
        
        $selectedOffre = null;
        $applications = collect();
        
        if ($offerId) {
            $selectedOffre = Offre::where('user_id', $user->id)->findOrFail($offerId);
            $applications = $selectedOffre->applications()
                ->with(['user', 'resume'])
                ->paginate(10);
            foreach ($applications as $application) {
                $resume = $application->resume;
                if ($resume) {
                    $score = $this->matchService->calculate($resume, $selectedOffre);
                    $application->match_score = $score;
                } else {
                    $application->match_score = 0;
                }
            }
        }
        
        return view('recruter/candidatures', compact('offres', 'selectedOffre', 'applications'));
    }
    
    /**
     * Affiche les détails d'une candidature
     */
    public function show($offerId, $applicationId)
    {
        $user = Auth::user();
        $offre = Offre::where('user_id', $user->id)->findOrFail($offerId);
        
        $application = Application::where('offre_id', $offerId)
            ->with(['user', 'resume'])
            ->findOrFail($applicationId);
        
        $resume = $application->resume;
        $cv = Cv::where('user_id', $application->user_id)->first();
        
        return view('recruter/candidatureshow', compact('offre', 'application', 'resume', 'cv'));
    }

    public function showCv($id)
    {
        $cv = Cv::findOrFail($id);

        $filePath = Storage::path($cv->filePath);
        
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$cv->filename.'"'
        ]);
    }
    
    /**
     * Met à jour le statut d'une candidature
     */
    public function updateStatus(Request $request, $offerId, $applicationId)
    {
        $user = Auth::user();
        $offre = Offre::where('user_id', $user->id)->findOrFail($offerId);
        
        $application = Application::where('offre_id', $offerId)
            ->findOrFail($applicationId);
        
        $request->validate([
            'status' => 'required|in:pending,accepted,rejected,interview',
        ]);
        
        $application->status = $request->status;
        $application->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Statut mis à jour avec succès',
        ]);
    }
}
