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


}
