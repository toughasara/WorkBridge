<?php

namespace App\Http\Controllers\Candidat;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResumeRequest;
use App\Interfaces\Repositories\ResumeRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class WorkbridgeCVController extends Controller
{

    private $resumeRepository;

    public function __construct(ResumeRepositoryInterface $resumeRepository)
    {
        $this->resumeRepository = $resumeRepository;
    }
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
    public function store(ResumeRequest  $request)
    {
        $this->resumeRepository->createForUser(
            Auth::id(),
            $request->validated()
        );

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
        $resume = $this->resumeRepository->findById($id);
        return view('candidat/resumeedit', compact('resume'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ResumeRequest  $request, $id)
    {
        $this->resumeRepository->updateResume($id, $request->validated());
        
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
        $this->resumeRepository->deleteResume($id);
        return redirect()->route('profil.candidat')->with('success', 'Resume deleted successfully.');
    }
}
