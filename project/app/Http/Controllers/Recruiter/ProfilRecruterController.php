<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;

class ProfilRecruterController extends Controller
{

    public function showProfile()
    {
        $user = Auth::user();
        
        $company = $user->company;
        
        return view('recruter.profilrecruteur', compact('user', 'company'));
    }
}
