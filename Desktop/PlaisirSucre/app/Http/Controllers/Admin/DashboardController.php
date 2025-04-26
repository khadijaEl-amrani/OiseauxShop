<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Produit;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalClients = Client::count();
        $totalProduits = Produit::count();
        $totalCommandes = Commande::count();
        
        $recentCommandes = Commande::with(['client', 'detailsCommandes.produit'])
            ->orderBy('commande_date', 'desc')
            ->take(5)
            ->get();
            
        $topProduits = Produit::withCount('detailsCommandes')
            // ->orderBy('commandes_count', 'desc')
            ->take(5)
            ->get();
            
        return view('admin.dashboard', compact(
            'totalUsers', 
            'totalClients', 
            'totalProduits', 
            'totalCommandes', 
            'recentCommandes', 
            'topProduits'
        ));
    }
}