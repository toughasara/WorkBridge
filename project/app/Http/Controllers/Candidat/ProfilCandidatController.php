<?php

namespace App\Http\Controllers\Candidat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;

class ProfilCandidatController extends Controller
{
    // formulaire info campany
    public function index()
    {
        return view('recruter/inforecruteur');
    }

    // enregistrer informations
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'pays' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'sector' => 'required|string|max:255',
            'size' => 'required|string|max:255',
            // 'website' => 'nullable|url|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();

        $company = Company::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'pays' => $request->pays,
            'ville' => $request->ville,
            'sector' => $request->sector,
            'size' => $request->size,
            'website' => $request->website,
            'description' => $request->description,
        ]);
        // dd($company);


        return redirect()->route('register')->with('success', 'Informations de l\'entreprise enregistrées avec succès !');
    }

}
