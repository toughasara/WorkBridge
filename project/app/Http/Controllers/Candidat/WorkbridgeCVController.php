<?php

namespace App\Http\Controllers\Candidat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resume;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class WorkbridgeCVController extends Controller
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
        return view('candidat/resumecreate');
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
            'pays' => 'required',
            'ville' => 'required',
            'phone' => 'required',
            'birthDate' => 'required|date',
        ]);

        $user = Auth::user();
        $resume = Resume::create([
            'user_id' => $user->id,
            'pays' => $request->pays,
            'ville' => $request->ville,
            'phone' => $request->phone,
            'birthDate' => $request->birthDate,
        ]);

        return redirect()->route('resume.view')->with('success', 'Resume created successfully.');
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
        $resume = Resume::findOrFail($id);

        return view('candidat/resumeedit', compact('resume'));
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
        $request->validate([
            'pays' => 'required',
            'ville' => 'required',
            'phone' => 'required',
            'birthDate' => 'required|date',
        ]);

        $resume = Resume::findOrFail($id);
        $resume->update($request->all());

        return redirect()->route('resume.view')->with('success', 'Resume updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resume = Resume::findOrFail($id);
        $resume->delete();

        return redirect()->route('profil.candidat')->with('success', 'Resume deleted successfully.');
    }
}
