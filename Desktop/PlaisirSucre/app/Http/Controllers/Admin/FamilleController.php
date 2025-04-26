<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Famille;
use Illuminate\Http\Request;

class FamilleController extends Controller
{
    public function index()
    {
        $familles = Famille::withCount('sousFamilles')->paginate(10);
        return view('admin.familles.index', compact('familles'));
    }

    public function create()
    {
        return view('admin.familles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'famille' => 'required|string|max:255|unique:familles',
        ]);

        Famille::create($validated);

        return redirect()->route('admin.familles.index')
            ->with('success', 'Famille créée avec succès.');
    }

    public function edit(Famille $famille)
    {
        return view('admin.familles.edit', compact('famille'));
    }

    public function update(Request $request, Famille $famille)
    {
        $validated = $request->validate([
            'famille' => 'required|string|max:255|unique:familles,famille,' . $famille->id,
        ]);

        $famille->update($validated);

        return redirect()->route('admin.familles.index')
            ->with('success', 'Famille mise à jour avec succès.');
    }

    public function destroy(Famille $famille)
    {
        if ($famille->sousFamilles()->count() > 0) {
            return back()->withErrors(['error' => 'Impossible de supprimer cette famille car elle contient des sous-familles.']);
        }

        $famille->delete();

        return redirect()->route('admin.familles.index')
            ->with('success', 'Famille supprimée avec succès.');
    }
}