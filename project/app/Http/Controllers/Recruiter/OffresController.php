<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Offre;
use App\Models\Skill;
use App\Models\Language;


class OffresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offres = Offre::where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->paginate(10); // Utilisez paginate() au lieu de get()

        return view('recruter.offres', compact('offres'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $skills = Skill::all();
        $languages = Language::all();

        return view('recruter.offrecreat', compact('skills', 'languages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté');
        }
        
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'nombre_poste' => 'required|integer|min:1',
            'type_contrat' => 'required|string',
            'mode_travail' => 'required|string',
            'description' => 'required|string',
            'date_expiration' => 'nullable|date',
            'salaire' => 'required|integer',
            'experience' => 'required|integer',
            'location' => 'required|string',
            'statut' => 'required|string',
            'skill_ids' => 'required|array',
            'skill_ids.*' => 'exists:skills,id',
            'language_ids' => 'nullable|array',
            'language_ids.*' => 'exists:languages,id',
            'language_levels' => 'nullable|array',
            'language_levels.*' => 'string',
        ]);

        DB::beginTransaction();

        try {
            $offre = new Offre();
            $offre->user_id = $user->id;
            
            $offre->title = $validatedData['title'];
            $offre->nombre_poste = $validatedData['nombre_poste'];
            $offre->type_contrat = $validatedData['type_contrat'];
            $offre->mode_travail = $validatedData['mode_travail'];
            $offre->description = $validatedData['description'];
            $offre->date_expiration = $validatedData['date_expiration'];
            $offre->salaire = $validatedData['salaire'];
            $offre->experience = $validatedData['experience'];
            $offre->location = $validatedData['location'];
            $offre->statut = $validatedData['statut'];
            
            if (!$offre->save()) {
                throw new \Exception("Échec de l'enregistrement de l'offre");
            }

            $offre->skills()->sync($validatedData['skill_ids']);

            $languageData = [];
            if (isset($validatedData['language_ids']) && isset($validatedData['language_levels'])) {
                foreach ($validatedData['language_ids'] as $index => $languageId) {
                    $level = isset($validatedData['language_levels'][$index]) ? $validatedData['language_levels'][$index] : 'débutant';
                    $languageData[$languageId] = ['level' => $level];
                }
            }
            $offre->languages()->sync($languageData);

            DB::commit();

            $message = 'Offre créée avec succès!';
            if ($validatedData['statut'] === 'en attente') {
                $message .= ' (Votre offre est en attente de validation)';
            }

            return redirect()->route('offers.index')->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Une erreur est survenue lors de la mise à jour de l\'offre.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $offre = Offre::with(['skills', 'languages', 'user'])
                    ->findOrFail($id);
        
        if ($offre->user_id !== auth()->id()) {
            return redirect()->route('recruiter.offers.index')
                ->with('error', 'Vous n\'êtes pas autorisé à voir cette offre.');
        }

        return view('recruter.offreshow', compact('offre'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $offre = Offre::with(['skills', 'languages'])->findOrFail($id);
    
        if ($offre->user_id !== auth()->id()) {
            return redirect()->route('recruiter.offers.index')
                ->with('error', 'Vous n\'êtes pas autorisé à modifier cette offre.');
        }
        
        $skills = Skill::all();
        $languages = Language::all();
        
        return view('recruter.offreedit', compact('offre', 'skills', 'languages'));
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
        $offre = Offre::findOrFail($id);
        
        if ($offre->user_id !== auth()->id()) {
            return redirect()->route('recruiter.offers.index')
                ->with('error', 'Vous n\'êtes pas autorisé à modifier cette offre.');
        }
        
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'nombre_poste' => 'required|integer|min:1',
            'type_contrat' => 'required|string',
            'mode_travail' => 'required|string',
            'description' => 'required|string',
            'date_expiration' => 'nullable|date',
            'salaire' => 'required|integer',
            'experience' => 'required|integer',
            'location' => 'required|string',
            'statut' => 'required|string',
            'skill_ids' => 'required|array',
            'skill_ids.*' => 'exists:skills,id',
            'language_ids' => 'nullable|array',
            'language_ids.*' => 'exists:languages,id',
            'language_levels' => 'nullable|array',
            'language_levels.*' => 'string',
        ]);

        DB::beginTransaction();

        try {
            // Gestion du statut
            $statut = $validatedData['statut'];
            if ($statut === 'publiée') {
                $statut = 'en attente';
            }

            $offre->update([
                'title' => $validatedData['title'],
                'nombre_poste' => $validatedData['nombre_poste'],
                'type_contrat' => $validatedData['type_contrat'],
                'mode_travail' => $validatedData['mode_travail'],
                'description' => $validatedData['description'],
                'date_expiration' => $validatedData['date_expiration'],
                'salaire' => $validatedData['salaire'],
                'experience' => $validatedData['experience'],
                'location' => $validatedData['location'],
                'statut' => $statut,
            ]);

            $offre->skills()->sync($validatedData['skill_ids']);
            
            $languageData = [];
            if (!empty($validatedData['language_ids'])) {
                foreach ($validatedData['language_ids'] as $index => $languageId) {
                    $languageData[$languageId] = [
                        'level' => $validatedData['language_levels'][$index] ?? 'débutant'
                    ];
                }
                $offre->languages()->sync($languageData);
            }

            DB::commit();

            $message = 'Offre mise à jour avec succès!';
            if ($statut === 'en attente') {
                $message .= ' (Votre offre est en attente de validation)';
            }

            return redirect()->route('offers.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Erreur lors de la mise à jour: '.$e->getMessage());
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
        $offre = Offre::findOrFail($id);
        
        if ($offre->user_id !== auth()->id()) {
            return redirect()->route('recruiter.offers.index')
                ->with('error', 'Vous n\'êtes pas autorisé à supprimer cette offre.');
        }

        DB::beginTransaction();

        try {
            // Détacher d'abord les relations
            $offre->skills()->detach();
            $offre->languages()->detach();
            
            // Puis supprimer l'offre
            $offre->delete();

            DB::commit();

            return redirect()->route('offers.index')
                ->with('success', 'Offre supprimée avec succès!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la suppression: '.$e->getMessage());
        }
    }

}
