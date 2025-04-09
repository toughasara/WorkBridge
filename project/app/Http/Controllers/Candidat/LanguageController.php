<?php

namespace App\Http\Controllers\Candidat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resume;
use App\Models\Language;

class LanguageController extends Controller
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
    public function create(Resume $resume)
    {
        $languages = Language::all();
        $selectedLanguages = $resume->languages()->withPivot('level')->get();
        
        return view('candidat.languagecreat', [
            'resume' => $resume,
            'languages' => $languages,
            'selectedLanguages' => $selectedLanguages,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Resume $resume)
    {
        $request->validate([
            'languages' => 'required|array',
            'languages.*.selected' => 'sometimes|boolean',
            'languages.*.level' => 'required_with:languages.*.selected|in:débutant,intermédiaire,avancé,courant,natif',
            'new_language_name' => 'sometimes|string|max:255|unique:languages,name',
            'new_language_level' => 'required_with:new_language_name|in:débutant,intermédiaire,avancé,courant,natif',
        ]);

        // Préparer les données pour sync
        $languagesToSync = [];
        
        // Traiter les langues existantes
        foreach ($request->languages as $languageId => $data) {
            if (isset($data['selected']) && $data['selected']) {
                $languagesToSync[$languageId] = ['level' => $data['level']];
            }
        }
        
        // Traiter la nouvelle langue si elle existe
        if ($request->filled('new_language_name')) {
            $newLanguage = Language::firstOrCreate([
                'name' => $request->new_language_name
            ]);
            
            $languagesToSync[$newLanguage->id] = ['level' => $request->new_language_level];
        }
        
        // Synchroniser les langues avec le CV
        $resume->languages()->sync($languagesToSync);

        return redirect()
            ->route('resume.view', $resume->id)
            ->with('success', 'Vos langues ont été mises à jour avec succès.');
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
