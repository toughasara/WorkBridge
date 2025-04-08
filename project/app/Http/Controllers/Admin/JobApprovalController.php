<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offre;
use App\Models\Company;
use Illuminate\Http\Request;

class JobApprovalController extends Controller
{
    public function index()
    {
        $pendingJobs = Offre::with(['user.company'])
            ->where('statut', 'en attente')
            ->latest()
            ->paginate(8);

        return view('admin.jobapproval', compact('pendingJobs'));
    }

    public function approve(Request $request, Offre $job)
    {
        $validated = $request->validate([
            'comment' => 'nullable|string|max:500'
        ]);

        $job->update([
            'statut' => 'approved',
        ]);

        return redirect()->route('admin.JobApproval')->with('success', 'Offre approuvée avec succès.');
    }

    public function reject(Request $request, Offre $job)
    {

        $job->update([
            'statut' => 'rejected',
        ]);

        return redirect()->route('admin.JobApproval')->with('success', 'Offre rejetée avec succès.');
    }
}
