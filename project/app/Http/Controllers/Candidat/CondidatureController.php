<?php

namespace App\Http\Controllers\Candidat;

use App\Http\Controllers\Controller;
use App\Models\Offre;
use App\Models\Application;
use App\Models\Cv;
use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CondidatureController extends Controller
{
    public function postuler(Request $request, $id)
    {
        $user = Auth::user();
        $offre = Offre::findOrFail($id);

        if ($user->hasAppliedToJob($id)) {
            return response()->json([
                'success' => false,
                'message' => 'Vous avez déjà postulé à cette offre.'
            ]);
        }

        $cv = Cv::where('user_id', $user->id)->first();
        $resume = Resume::where('user_id', $user->id)->first();

        if (!$cv) {
            return response()->json([
                'success' => false,
                'message' => 'Veuillez compléter votre profil en ajoutant votre CV avant de postuler.',
                'redirect' => route('cv.create')
            ]);
        }

        // Creer la candidature
        $application = new Application();
        $application->user_id = $user->id;
        $application->offre_id = $id;
        $application->cv_id = $cv->id;
        $application->resume_id = $resume->id;
        $application->status = 'pending';
        $application->save();

        $offre->increment('candidatures_count');

        return response()->json([
            'success' => true,
            'message' => 'Votre candidature a été envoyée avec succès!'
        ]);
    }
}
