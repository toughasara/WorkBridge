<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


class UserManagementController extends Controller
{

    public function index(Request $request)
    {
        $query = User::whereHas('role', function($q) {
            $q->where('title', 'recruteur');
        })->with('Company')->latest();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
            });
        }

        $recruiters = $query->paginate(15);

        return view('admin.usermanagement', compact('recruiters'));
    }

    public function suspend(User $recruiter)
    {
        $recruiter->update(['statut' => 'suspended']);
        return redirect()->back()->with('success', 'Recruteur suspendu avec succès.');
    }
    
}
