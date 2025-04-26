<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Famille;
use App\Models\SousFamille;
use Illuminate\Http\Request;

class SousFamilleController extends Controller
{
    public function index()
    {
        $sousFamilles = SousFamille::with('famille')->withCount('produits')->paginate(10);
        return view('admin.sous_familles.index', compact('sousFamilles'));
    }

    public function create()
    {
        $familles = Famille::all();
        return view('admin.sous_familles.create', compact('familles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sous_famille' => 'required|string|max:255',
            'famille_id' => 'required|exists:familles,id',
        ]);

        SousFamille::create($validated);

        return redirect()->route('admin.sous_familles.index')
            ->with('success', 'Sous-famille créée avec succès.');
    }

    public function edit(SousFamille $sousFamille)
    {
        $familles = Famille::all();
        return view('admin.sous_familles.edit', compact('sousFamille', 'familles'));
    }

    public function update(Request $request, SousFamille $sousFamille)
    {
        $validated = $request->validate([
            'sous_famille' => 'required|string|max:255',
            'famille_id' => 'required|exists:familles,id',
        ]);

        $sousFamille->update($validated);

        return redirect()->route('admin.sous_familles.index')
            ->with('success', 'Sous-famille mise à jour avec succès.');
    }

    public function destroy(SousFamille $sousFamille)
    {
        if ($sousFamille->produits()->count() > 0) {
            return back()->withErrors(['error' => 'Impossible de supprimer cette sous-famille car elle contient des produits.']);
        }

        $sousFamille->delete();

        return redirect()->route('admin.sous_familles.index')
            ->with('success', 'Sous-famille supprimée avec succès.');
    }
}