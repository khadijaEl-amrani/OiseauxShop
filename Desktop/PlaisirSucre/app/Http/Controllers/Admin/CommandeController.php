<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Commande;
use App\Models\DetailsCommande;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommandeController extends Controller
{
    public function index()
    {
        $commandes = Commande::with('client')->paginate(10);
        return view('admin.commandes.index', compact('commandes'));
    }

    public function create()
    {
        $clients = Client::all();
        $produits = Produit::all();
        return view('admin.commandes.create', compact('clients', 'produits'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'commande_date' => 'required|date',
            'produits' => 'required|array',
            'produits.*.id' => 'required|exists:produits,id',
            'produits.*.quantite' => 'required|numeric|min:0.01',
        ]);

        DB::beginTransaction();

        try {
            $commande = Commande::create([
                'client_id' => $validated['client_id'],
                'commande_date' => $validated['commande_date'],
            ]);

            foreach ($validated['produits'] as $produit) {
                DetailsCommande::create([
                    'commande_id' => $commande->id,
                    'produit_id' => $produit['id'],
                    'quantité' => $produit['quantite'],
                ]);
            }

            DB::commit();

            return redirect()->route('admin.commandes.index')
                ->with('success', 'Commande créée avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Une erreur est survenue lors de la création de la commande.']);
        }
    }

    public function show(Commande $commande)
    {
        $commande->load(['client', 'detailsCommandes.produit']);
        return view('admin.commandes.show', compact('commande'));
    }

    public function edit(Commande $commande)
    {
        $commande->load('detailsCommandes.produit');
        $clients = Client::all();
        $produits = Produit::all();
        return view('admin.commandes.edit', compact('commande', 'clients', 'produits'));
    }

    public function update(Request $request, Commande $commande)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'commande_date' => 'required|date',
            'produits' => 'required|array',
            'produits.*.id' => 'required|exists:produits,id',
            'produits.*.quantite' => 'required|numeric|min:0.01',
        ]);

        DB::beginTransaction();

        try {
            $commande->update([
                'client_id' => $validated['client_id'],
                'commande_date' => $validated['commande_date'],
            ]);

            // Delete existing details
            $commande->detailsCommandes()->delete();

            // Create new details
            foreach ($validated['produits'] as $produit) {
                DetailsCommande::create([
                    'commande_id' => $commande->id,
                    'produit_id' => $produit['id'],
                    'quantité' => $produit['quantite'],
                ]);
            }

            DB::commit();

            return redirect()->route('admin.commandes.index')
                ->with('success', 'Commande mise à jour avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Une erreur est survenue lors de la mise à jour de la commande.']);
        }
    }

    public function destroy(Commande $commande)
    {
        DB::beginTransaction();

        try {
            // Delete details first
            $commande->detailsCommandes()->delete();
            
            // Then delete the commande
            $commande->delete();

            DB::commit();

            return redirect()->route('admin.commandes.index')
                ->with('success', 'Commande supprimée avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Une erreur est survenue lors de la suppression de la commande.']);
        }
    }
}