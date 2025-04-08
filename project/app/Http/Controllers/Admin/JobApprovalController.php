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
}
