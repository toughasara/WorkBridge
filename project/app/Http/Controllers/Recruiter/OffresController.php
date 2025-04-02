<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use App\Http\Requests\OffreRequest;
use App\Interfaces\Services\OffreServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Skill;
use App\Models\Language;




class OffresController extends Controller
{

    private OffreServiceInterface $offreService;

    public function __construct(OffreServiceInterface $offreService)
    {
        $this->offreService = $offreService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $offres = $this->offreService->getUserOffres(Auth::id());
        return view('recruter.offres', compact('offres'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
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
    
    public function store(OffreRequest $request): RedirectResponse
    {
        try {
            $offre = $this->offreService->createOffre($request->validated(), Auth::id());
            
            $message = 'Offre créée avec succès!';
            if ($request->statut === 'en attente') {
                $message .= ' (Votre offre est en attente de validation)';
            }

            return redirect()->route('offers.index')->with('success', $message);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View|RedirectResponse
    {
        try {
            $offre = $this->offreService->getOffreWithRelations($id, Auth::id());
            return view('recruter.offreshow', compact('offre'));
        } catch (\Exception $e) {
            return redirect()->route('offers.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View|RedirectResponse
    {
        try {
            $offre = $this->offreService->getOffreWithRelations($id, Auth::id());
            $skills = Skill::all();
            $languages = Language::all();
            return view('recruter.offreedit', compact('offre', 'skills', 'languages'));
        } catch (\Exception $e) {
            return redirect()->route('offers.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OffreRequest $request, $id): RedirectResponse
    {
        try {
            $this->offreService->updateOffre($id, $request->validated(), Auth::id());
            
            $message = 'Offre mise à jour avec succès!';
            if ($request->statut === 'en attente') {
                $message .= ' (Votre offre est en attente de validation)';
            }

            return redirect()->route('offers.index')->with('success', $message);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        try {
            $this->offreService->deleteOffre($id, Auth::id());
            return redirect()->route('offers.index')->with('success', 'Offre supprimée avec succès!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

}
