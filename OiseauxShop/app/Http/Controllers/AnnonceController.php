<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Categorie;
use App\Models\Ville;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AnnonceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Annonce::query()->where('valider', true)->where('expérer', false);
        
        // Filter by category
        if ($request->has('categorie_id')) {
            $query->where('categorie_id', $request->categorie_id);
        }
        
        // Filter by city
        if ($request->has('ville_id')) {
            $query->where('ville_id', $request->ville_id);
        }
        
        // Filter by price range
        if ($request->has('prix_min')) {
            $query->where('prix', '>=', $request->prix_min);
        }
        
        if ($request->has('prix_max')) {
            $query->where('prix', '<=', $request->prix_max);
        }
        
        // Sort results
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price-low':
                $query->orderBy('prix', 'asc');
                break;
            case 'price-high':
                $query->orderBy('prix', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        $annonces = $query->with(['user', 'ville', 'categorie', 'images'])->paginate(12);
        $categories = Categorie::all();
        $villes = Ville::all();
        
        return view('annonces.index', compact('annonces', 'categories', 'villes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categorie::all();
        $villes = Ville::all();
        
        return view('annonces.create', compact('categories', 'villes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'categorie_id' => 'required|exists:categories,id',
            'ville_id' => 'required|exists:villes,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $annonce = Annonce::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'prix' => $request->prix,
            'user_id' => Auth::id(),
            'categorie_id' => $request->categorie_id,
            'ville_id' => $request->ville_id,
            'expérer' => false,
            'valider' => false, // Requires admin validation
        ]);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('annonces', $filename, 'public');
                Image::create([
                    'chemin_image' => $path,
                    'annonce_id' => $annonce->id,
                ]);
    }
}

        return redirect()->route('annonces.show', $annonce->id)
            ->with('success', 'Votre annonce a été créée et est en attente de validation.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $annonce = Annonce::with(['user', 'ville', 'categorie', 'images'])->findOrFail($id);
        
        // Get similar announcements
        $similarAnnonces = Annonce::where('categorie_id', $annonce->categorie_id)
            ->where('id', '!=', $annonce->id)
            ->where('valider', true)
            ->where('expérer', false)
            ->take(3)
            ->get();
            
        $isFavorite = false;
        if (Auth::check()) {
            $isFavorite = Auth::user()->annoncesFavorites()->where('annonce_id', $id)->exists();
        }
        
        return view('annonces.show', compact('annonce', 'similarAnnonces', 'isFavorite'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $annonce = Annonce::findOrFail($id);
        
        // Check if the user is the owner of the announcement
        if (Auth::id() !== $annonce->user_id) {
            return redirect()->route('annonces.index')
                ->with('error', 'Vous n\'êtes pas autorisé à modifier cette annonce.');
        }
        
        $categories = Categorie::all();
        $villes = Ville::all();
        
        return view('annonces.edit', compact('annonce', 'categories', 'villes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $annonce = Annonce::findOrFail($id);
        
        // Check if the user is the owner of the announcement
        if (Auth::id() !== $annonce->user_id) {
            return redirect()->route('annonces.index')
                ->with('error', 'Vous n\'êtes pas autorisé à modifier cette annonce.');
        }
        
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'categorie_id' => 'required|exists:categories,id',
            'ville_id' => 'required|exists:villes,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $annonce->update([
            'titre' => $request->titre,
            'description' => $request->description,
            'prix' => $request->prix,
            'categorie_id' => $request->categorie_id,
            'ville_id' => $request->ville_id,
            'valider' => false, // Requires admin validation again after update
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('annonces', 'public');
                
                Image::create([
                    'chemin_image' => $path,
                    'annonce_id' => $annonce->id,
                ]);
            }
        }

        return redirect()->route('annonces.show', $annonce->id)
            ->with('success', 'Votre annonce a été mise à jour et est en attente de validation.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $annonce = Annonce::findOrFail($id);
        
        // Check if the user is the owner of the announcement
        if (Auth::id() !== $annonce->user_id && !Auth::user()->is_admin) {
            return redirect()->route('annonces.index')
                ->with('error', 'Vous n\'êtes pas autorisé à supprimer cette annonce.');
        }
        
        // Delete associated images from storage
        foreach ($annonce->images as $image) {
            Storage::disk('public')->delete($image->chemin_image);
            $image->delete();
        }
        
        // Delete favorites
        $annonce->favoris()->delete();
        
        // Delete the announcement
        $annonce->delete();
        
        return redirect()->route('annonces.index')
            ->with('success', 'L\'annonce a été supprimée avec succès.');
    }

    /**
     * Display user's announcements.
     */
    public function userAnnonces()
    {
        $annonces = Annonce::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('user.annonces', compact('annonces'));
    }
}