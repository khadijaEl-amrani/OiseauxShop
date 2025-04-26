<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the client's profile.
     */
    public function index(): View
    {
        $user = Auth::user();
        $client = $user->client;
        
        return view('client.profile', [
            'user' => $user,
            'client' => $client
        ]);
    }

    /**
     * Update the client's profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'cin' => ['required', 'string', 'max:20', Rule::unique('users')->ignore($user->id)],
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'adresse' => ['required', 'string'],
            'current_password' => ['nullable', 'required_with:password', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail('Le mot de passe actuel est incorrect.');
                }
            }],
            'password' => ['nullable', 'min:8', 'confirmed'],
        ]);
        
        // Update user information
        $user->cin = $request->cin;
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->telephone = $request->telephone;
        $user->email = $request->email;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();
        
        // Update or create client information
        $client = $user->client;
        if (!$client) {
            $client = new Client();
            $client->user_id = $user->id;
        }
        
        $client->nom = $user->nom;
        $client->prenom = $user->prenom;
        $client->telephone = $user->telephone;
        $client->adresse = $request->adresse;
        $client->save();
        
        return redirect()->route('client.profile')->with('success', 'Votre profil a été mis à jour avec succès.');
    }
}