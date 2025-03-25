<?php

namespace App\Http\Controllers\Candidat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Experience;
use App\Models\Resume;


class ExperienceController extends Controller
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
        return view('candidat/experiencecreate', compact('resume'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Resume $resume)
    {
        // dd($request->all());
        // dd($resume);
        // dd($request);
        $request->validate([
            'company_name' => 'required',
            'job_title' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'description' => 'nullable',
        ]);

        $resume->experiences()->create($request->all());

        return redirect()->route('resume.view')->with('success', 'Experience added successfully.');
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
    public function edit(Resume $resume, Experience $experience)
    {
        return view('candidat/experienceedit', compact('experience', 'resume'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resume $resume, Experience $experience)
    {
        $request->validate([
            'company_name' => 'required',
            'job_title' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'description' => 'nullable',
        ]);

        $experience->update($request->all());

        return redirect()->route('resume.view')->with('success', 'Experience updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resume $resume, Experience $experience)
    {
        // Vérifier que l'expérience appartient bien au CV
        if ($experience->resume_id !== $resume->id) {
            return redirect()->route('resume.view')->with('error', 'Unauthorized action.');
        }

        // Suppression
        $experience->delete();

        return redirect()->route('resume.view')->with('success', 'Experience deleted successfully.');
    }
}
