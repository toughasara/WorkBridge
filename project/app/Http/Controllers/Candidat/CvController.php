<?php

namespace App\Http\Controllers\Candidat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cv;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class CvController extends Controller
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
        //
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
            'cv_file' => 'required|mimes:pdf|max:2048',
        ]);

        $user = Auth::user();
        $filePath = $request->file('cv_file')->store('cvs');

        Cv::create([
            'user_id' => $user->id,
            'filePath' => $filePath,
        ]);

        return redirect()->route('profil.candidat')->with('success', 'CV uploaded successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cv = Cv::findOrFail($id);

        $filePath = Storage::path($cv->filePath);
        
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$cv->filename.'"'
        ]);
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
        $request->validate([
            'cv_file' => 'required|mimes:pdf|max:2048',
        ]);

        $cv = Cv::findOrFail($id);
        Storage::delete($cv->filePath);

        $filePath = $request->file('cv_file')->store('cvs');
        $cv->update(['filePath' => $filePath]);

        return redirect()->route('profil.candidat')->with('success', 'CV updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cv = Cv::findOrFail($id);
        Storage::delete($cv->filePath);
        $cv->delete();

        return redirect()->route('profil.candidat')->with('success', 'CV deleted successfully.');
    }
}
