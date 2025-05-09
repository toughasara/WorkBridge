<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MatchingPreference;
use App\Models\Offre;
use Illuminate\Support\Facades\Auth;

class MatchingPreferenceController extends Controller
{
    /**
     * Affiche la page des préférences de matching pour une offre
     */
    public function index($offreId)
    {
        $offre = Offre::findOrFail($offreId);
        
        $preference = MatchingPreference::where('offer_id', $offreId)->first();
        
        return view('recruter.preference', compact('offre', 'preference'));
    }
    
    /**
     * Enregistre ou met à jour les préférences de matching
     */
    public function storePreference(Request $request, $offreId)
    {
        // Récupérer l'offre
        $offre = Offre::findOrFail($offreId);

        $preference = MatchingPreference::where('offer_id', $offreId)->first();

        $useAi = $request->has('use_ai');

        if($useAi){
            $rules = ['use_ai' => 'sometimes',];
        }
        else{
            $rules['skills_weight'] = 'required|numeric|min:0|max:100';
            $rules['languages_weight'] = 'required|numeric|min:0|max:100';
            $rules['experience_weight'] = 'required|numeric|min:0|max:100';
            $rules['location_weight'] = 'required|numeric|min:0|max:100';
        }

        $validated = $request->validate($rules);

        if ($preference) {
            // modification si il existe 
            $this->updatePreference($preference, $request);
        } else {
            // creation si il n'existe pas 
            $this->createPreference($offreId, $request);
        }
        
        return redirect()->route('offers.index')->with('success', 'Les préférences de matching ont été enregistrées avec succès.');
    }

    // creation si il n'existe pas 
    private function createPreference($offreId, Request $request)
    {
        $useAi = $request->has('use_ai');

        if ($useAi) {
            // ajouter valeur par defaut si ai est utiliser 
            $skillsWeight = 0.40;
            $languagesWeight = 0.20;
            $experienceWeight = 0.25;
            $locationWeight = 0.15;
        } else {
            // changer les pois 0-1
            $skillsWeight = (float)$request->skills_weight / 100;
            $languagesWeight = (float)$request->languages_weight / 100;
            $experienceWeight = (float)$request->experience_weight / 100;
            $locationWeight = (float)$request->location_weight / 100;
        }
        
        MatchingPreference::create([
            'offer_id' => $offreId,
            'use_ai' => $useAi,
            'skills_weight' => $skillsWeight,
            'languages_weight' => $languagesWeight,
            'experience_weight' => $experienceWeight,
            'location_weight' => $locationWeight,
        ]);
    }

    // modification si il existe 
    private function updatePreference(MatchingPreference $preference, Request $request)
    {
        $useAi = $request->has('use_ai');
        
        if ($useAi) {
            // definie valeur par defaut si ai est utiliser 
            $skillsWeight = 0.40;
            $languagesWeight = 0.20;
            $experienceWeight = 0.25;
            $locationWeight = 0.15;
        } else {
            // changer les pois 0-1
            $skillsWeight = (float)$request->skills_weight / 100;
            $languagesWeight = (float)$request->languages_weight / 100;
            $experienceWeight = (float)$request->experience_weight / 100;
            $locationWeight = (float)$request->location_weight / 100;
        }
        
        $preference->update([
            'use_ai' => $useAi,
            'skills_weight' => $skillsWeight,
            'languages_weight' => $languagesWeight,
            'experience_weight' => $experienceWeight,
            'location_weight' => $locationWeight,
        ]);
    }
}
