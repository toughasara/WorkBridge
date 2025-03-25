<?php

namespace App\Http\Controllers\Candidat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cv;
use App\Models\User;
use App\Models\Resume;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;

class ProfilCandidatController extends Controller
{
    // formulaire info campany
    public function index()
    {
        return view('recruter/inforecruteur');
    }

    public function showProfil()
    {
        $user = Auth::user();
        $cv = Cv::where('user_id', $user->id)->first();
        $resume = $user->resume;

        return view('candidat/profilcandidat', compact('cv', 'resume'));
    }

    public function showResume()
    {
        $user = Auth::user();
        $resume = $user->resume;

        if (!$resume) {
            return redirect()->route('profil.candidat')->with('error', 'Aucun CV WorkBridge trouvé.');
        }

        $experiences = $resume->experiences;
        $educations = $resume->education;
        $skills = $resume->skills;
        $languages = $resume->languages;

        return view('candidat.candidatresume', compact('user', 'resume', 'experiences', 'educations', 'skills', 'languages'));
    }


}
