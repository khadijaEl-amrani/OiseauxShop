<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ville;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $credentials['email'], 'mot_de_passe' => $credentials['password']])) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Les informations d\'identification fournies ne correspondent pas à nos enregistrements.',
        ])->onlyInput('email');
    }

    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        $villes = Ville::all();
        
        return view('auth.register', compact('villes'));
    }

    /**
     * Handle registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'mot_de_passe' => 'required|string|min:8|confirmed',
            'tele' => 'required|string|max:20',
            'id_ville' => 'required|exists:villes,id',
            'adresse' => 'required|string|max:255',
        ]);

        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'mot_de_passe' => Hash::make($request->mot_de_passe),
            'tele' => $request->tele,
            'id_ville' => $request->id_ville,
            'adresse' => $request->adresse,
            'is_admin' => false,
            'blockes' => false,
        ]);

        Auth::login($user);

        return redirect('/');
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Show the user profile.
     */
    public function profile()
    {
        $user = Auth::user();
        $villes = Ville::all();
        
        return view('user.profile', compact('user', 'villes'));
    }

    /**
     * Update the user profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'tele' => 'required|string|max:20',
            'id_ville' => 'required|exists:villes,id',
            'adresse' => 'required|string|max:255',
        ]);

        $user->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'tele' => $request->tele,
            'id_ville' => $request->id_ville,
            'adresse' => $request->adresse,
        ]);

        return back()->with('success', 'Profil mis à jour avec succès.');
    }

    /**
     * Show the change password form.
     */
    public function showChangePasswordForm()
    {
        return view('user.change-password');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->mot_de_passe)) {
            return back()->withErrors([
                'current_password' => 'Le mot de passe actuel est incorrect.',
            ]);
        }

        $user->update([
            'mot_de_passe' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Mot de passe mis à jour avec succès.');
    }
}