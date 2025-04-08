<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('recruter/companiecreat');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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


        return redirect()->route('recruiter')->with('success', 'Informations de l\'entreprise enregistrées avec succès !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($companyId)
    {
        $company = Company::findOrFail($companyId);
        
        return view('recruter.companieedit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'pays' => 'required|string|max:255',
                'ville' => 'required|string|max:255',
                'sector' => 'required|string|max:255',
                'size' => 'required|string|max:255',
                // 'website' => 'nullable|url|max:255',
                'description' => 'nullable|string',
            ]);
    
            $company = Auth::user()->company;
            $company->update($validatedData);
    
            return redirect()->route('recruiter.profile')->with('success', 'Les informations de votre entreprise ont été mises à jour.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
