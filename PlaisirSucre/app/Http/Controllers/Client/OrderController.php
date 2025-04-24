<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display a listing of the client's orders.
     */
    public function index(): View
    {
        $user = Auth::user();
        $client = $user->client;
        
        $orders = [];
        if ($client) {
            $orders = Commande::where('client_id', $client->id)
                ->orderBy('commande_date', 'desc')
                ->paginate(10);
        }
        
        return view('client.orders', [
            'orders' => $orders
        ]);
    }

    /**
     * Display the specified order.
     */
    public function show(Commande $order): View
    {
        $user = Auth::user();
        $client = $user->client;
        
        // Check if the order belongs to the authenticated client
        if (!$client || $order->client_id !== $client->id) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('client.order-details', [
            'order' => $order
        ]);
    }
}