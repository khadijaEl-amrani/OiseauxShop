<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use App\Models\SousFamille;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProduitController extends Controller
{
    public function index()
    {
        $produits = Produit::with(['sousFamille.famille', 'user'])->paginate(10);
        return view('admin.produits.index', compact('produits'));
    }

    public function create()
    {
        $sousFamilles = SousFamille::with('famille')->get();
        $users = User::where('admin', false)->get();
        return view('admin.produits.create', compact('sousFamilles', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'designation' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'user_id' => 'required|exists:users,id',
            'sous_famille_id' => 'required|exists:sous_familles,id',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('produits', 'public');
            $validated['image'] = $imagePath;
        }

        Produit::create($validated);

        return redirect()->route('admin.produits.index')
            ->with('success', 'Produit créé avec succès.');
    }

    public function edit(Produit $produit)
    {
        $sousFamilles = SousFamille::with('famille')->get();
        $users = User::where('admin', false)->get();
        return view('admin.produits.edit', compact('produit', 'sousFamilles', 'users'));
    }

    public function update(Request $request, Produit $produit)
    {
        $validated = $request->validate([
            'designation' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'user_id' => 'required|exists:users,id',
            'sous_famille_id' => 'required|exists:sous_familles,id',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($produit->image) {
                Storage::disk('public')->delete($produit->image);
            }
            
            $imagePath = $request->file('image')->store('produits', 'public');
            $validated['image'] = $imagePath;
        }

        $produit->update($validated);

        return redirect()->route('admin.produits.index', ['page' => $request->input('page')])
            ->with('success', 'Produit mis à jour avec succès.');
    }

    public function destroy(Produit $produit)
    {
        // Delete image
        if ($produit->image) {
            Storage::disk('public')->delete($produit->image);
        }
        
        $produit->delete();

        return redirect()->route('admin.produits.index')
            ->with('success', 'Produit supprimé avec succès.');
    }
}