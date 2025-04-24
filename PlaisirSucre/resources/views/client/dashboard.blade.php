@extends('layouts.client')

@section('title', 'Tableau de bord')

@section('content')
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 bg-pink-50">
            <h1 class="text-lg leading-6 font-medium text-gray-900">Bienvenue, {{ $user->prenom }} {{ $user->nom }}</h1>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Votre tableau de bord personnel</p>
        </div>
        
        <div class="border-t border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4">
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-pink-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-pink-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Commandes totales
                                    </dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900">
                                            {{ $client ? $client->commandes->count() : 0 }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="{{ route('client.orders') }}" class="font-medium text-pink-600 hover:text-pink-500">
                                Voir toutes les commandes
                            </a>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-pink-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-pink-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Montant total dépensé
                                    </dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900">
                                            @php
                                                $totalSpent = 0;
                                                if ($client) {
                                                    foreach ($client->commandes as $commande) {
                                                        foreach ($commande->detailsCommandes as $detail) {
                                                            $totalSpent += $detail->produit->prix * $detail->quantité;
                                                        }
                                                    }
                                                }
                                            @endphp
                                            {{ number_format($totalSpent, 2) }} €
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="{{ route('shop') }}" class="font-medium text-pink-600 hover:text-pink-500">
                                Visiter la boutique
                            </a>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-pink-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-pink-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Mon profil
                                    </dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900">
                                            {{ $user->email }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="{{ route('client.profile') }}" class="font-medium text-pink-600 hover:text-pink-500">
                                Modifier mon profil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 bg-pink-50">
            <h2 class="text-lg leading-6 font-medium text-gray-900">Commandes récentes</h2>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Vos 5 dernières commandes</p>
        </div>
        <div class="border-t border-gray-200">
            @if(count($recentOrders) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Numéro
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nombre d'articles
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($recentOrders as $order)
                                @php
                                    $total = 0;
                                    $itemCount = 0;
                                    foreach ($order->detailsCommandes as $detail) {
                                        $total += $detail->produit->prix * $detail->quantité;
                                        $itemCount += $detail->quantité;
                                    }
                                @endphp
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            #{{ $order->id }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $order->commande_date->format('d/m/Y H:i') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $itemCount }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ number_format($total, 2) }} €
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('client.orders.show', $order) }}" class="text-pink-600 hover:text-pink-900">
                                            Détails
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-4 text-center text-gray-500">
                    <p>Vous n'avez pas encore passé de commande.</p>
                    <a href="{{ route('shop') }}" class="mt-2 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                        Commencer vos achats
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection