<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the client dashboard.
     */
    public function index(): View
    {
        $user = Auth::user();
        $client = $user->client;
        
        // Get recent orders if client exists
        $recentOrders = [];
        if ($client) {
            $recentOrders = Commande::where('client_id', $client->id)
                ->orderBy('commande_date', 'desc')
                ->limit(5)
                ->get();
        }
        
        return view('client.dashboard', [
            'user' => $user,
            'client' => $client,
            'recentOrders' => $recentOrders
        ]);
    }
}