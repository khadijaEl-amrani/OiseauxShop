<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\User;
use App\Models\Categorie;
use App\Models\Ville;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display admin dashboard.
     */
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalAnnonces = Annonce::count();
        $pendingAnnonces = Annonce::where('valider', false)->count();
        $totalCategories = Categorie::count();
        $totalVilles = Ville::count();
        
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAnnonces',
            'pendingAnnonces',
            'totalCategories',
            'totalVilles'
        ));
    }

    /**
     * Display a listing of all announcements.
     */
    public function annonces(Request $request)
    {
        $query = Annonce::query();
        
        // Filter by validation status
        if ($request->has('status')) {
            if ($request->status === 'pending') {
                $query->where('valider', false);
            } elseif ($request->status === 'approved') {
                $query->where('valider', true);
            }
        }
        
        $annonces = $query->with(['user', 'categorie', 'ville'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('admin.annonces', compact('annonces'));
    }

    /**
     * Approve an announcement.
     */
    public function approveAnnonce($id)
    {
        $annonce = Annonce::findOrFail($id);
        $annonce->update(['valider' => true]);
        
        return back()->with('success', 'Annonce approuvée avec succès.');
    }

    /**
     * Reject an announcement.
     */
    public function rejectAnnonce($id)
    {
        $annonce = Annonce::findOrFail($id);
        $annonce->update(['valider' => false]);
        
        return back()->with('success', 'Annonce rejetée avec succès.');
    }

    /**
     * Display a listing of all users.
     */
    public function users()
    {
        $users = User::with('ville')->paginate(20);
        
        return view('admin.users', compact('users'));
    }

    /**
     * Block/unblock a user.
     */
    public function toggleBlockUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['blockes' => !$user->blockes]);
        
        $status = $user->blockes ? 'bloqué' : 'débloqué';
        
        return back()->with('success', "L'utilisateur a été $status avec succès.");
    }

    /**
     * Display a listing of all categories.
     */
    public function categories()
    {
        $categories = Categorie::withCount('annonces')->paginate(20);
        
        return view('admin.categories', compact('categories'));
    }

    /**
     * Store a newly created category.
     */
    public function storeCategory(Request $request)
    {
        $request->validate([
            'categorie' => 'required|string|max:255|unique:categories',
        ]);
        
        Categorie::create([
            'categorie' => $request->categorie,
        ]);
        
        return back()->with('success', 'Catégorie créée avec succès.');
    }

    /**
     * Update the specified category.
     */
    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'categorie' => 'required|string|max:255|unique:categories,categorie,' . $id,
        ]);
        
        $category = Categorie::findOrFail($id);
        $category->update([
            'categorie' => $request->categorie,
        ]);
        
        return back()->with('success', 'Catégorie mise à jour avec succès.');
    }

    /**
     * Display a listing of all cities.
     */
    public function villes()
    {
        $villes = Ville::withCount('annonces')->paginate(20);
        
        return view('admin.villes', compact('villes'));
    }

    /**
     * Store a newly created city.
     */
    public function storeVille(Request $request)
    {
        $request->validate([
            'ville' => 'required|string|max:255|unique:villes',
        ]);
        
        Ville::create([
            'ville' => $request->ville,
        ]);
        
        return back()->with('success', 'Ville créée avec succès.');
    }

    /**
     * Update the specified city.
     */
    public function updateVille(Request $request, $id)
    {
        $request->validate([
            'ville' => 'required|string|max:255|unique:villes,ville,' . $id,
        ]);
        
        $ville = Ville::findOrFail($id);
        $ville->update([
            'ville' => $request->ville,
        ]);
        
        return back()->with('success', 'Ville mise à jour avec succès.');
    }
}