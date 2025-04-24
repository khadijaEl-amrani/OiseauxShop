@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-pink-50 rounded-xl p-6 flex items-center">
            <div class="bg-pink-500 rounded-full p-3 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Utilisateurs</p>
                <h3 class="text-2xl font-bold">{{ $totalUsers }}</h3>
            </div>
        </div>
        
        <div class="bg-blue-50 rounded-xl p-6 flex items-center">
            <div class="bg-blue-500 rounded-full p-3 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Clients</p>
                <h3 class="text-2xl font-bold">{{ $totalClients }}</h3>
            </div>
        </div>
        
        <div class="bg-green-50 rounded-xl p-6 flex items-center">
            <div class="bg-green-500 rounded-full p-3 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Produits</p>
                <h3 class="text-2xl font-bold">{{ $totalProduits }}</h3>
            </div>
        </div>
        
        <div class="bg-purple-50 rounded-xl p-6 flex items-center">
            <div class="bg-purple-500 rounded-full p-3 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Commandes</p>
                <h3 class="text-2xl font-bold">{{ $totalCommandes }}</h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-4 bg-gray-50 border-b">
                <h2 class="font-semibold text-lg">Commandes récentes</h2>
            </div>
            <div class="p-4">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($recentCommandes as $commande)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $commande->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $commande->client->nom }} {{ $commande->client->prenom }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $commande->commande_date->format('d/m/Y H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.commandes.show', $commande) }}" class="text-indigo-600 hover:text-indigo-900">Voir</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Aucune commande récente</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-4 bg-gray-50 border-b">
                <h2 class="font-semibold text-lg">Produits populaires</h2>
            </div>
            <div class="p-4">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produit</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Commandes</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($topProduits as $produit)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $produit->designation }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($produit->prix, 2) }} €</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $produit->commandes_count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Aucun produit populaire</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection