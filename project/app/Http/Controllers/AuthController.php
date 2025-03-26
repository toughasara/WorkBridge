<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    // formulaire login
    public function login()
    {
        return view('auth/login');
    }

    // formulaire register
    public function register()
    {
        return view('auth/register');
    }

    // Inscription
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|in:2,3',
        ]);

        // Création de l'utilisateur avec les nouveaux champs
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'statut' => 'active',
        ]);

        // Connexion de l'utilisateur après l'inscription
        Auth::login($user);

        return $this->redirectBasedOnRole($user);
    }

    // Connexion
    public function loginUser(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->statut !== 'active') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Votre compte est désactivé.',
                ]);
            }

            return $this->redirectBasedOnRole($user);     
        }

        return back()->withErrors([
            'email' => 'Les informations d\'identification sont incorrectes.',
        ]);
    }

    // Déconnexion
    public function logout()
    {
        Auth::logout();

        return redirect()->route('register');
    }

    protected function redirectBasedOnRole($user)
    {
        switch ($user->role_id) {
            case 1:
                return redirect()->route('admin');
            case 2:
                return redirect()->route('profil.candidat');
            case 3:
                return redirect()->route('recruter');
            default:
                return redirect()->route('home');
        }
    }
}

