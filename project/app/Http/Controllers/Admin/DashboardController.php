<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Offre;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques simplifiées
        $totalUsers = User::count();

        $totalCandidates = User::whereHas('role', function($q) {
            $q->where('title', 'candidat');
        })->count();

        $totalRecruiters = User::whereHas('role', function($q) {
            $q->where('title', 'recruteur');
        })->count();
        
        $totalJobs = Offre::count();
        $pendingJobs = Offre::where('statut', 'en attente')->count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalRecruiters',
            'totalCandidates',
            'totalJobs',
            'pendingJobs'
        ));
    }
}
