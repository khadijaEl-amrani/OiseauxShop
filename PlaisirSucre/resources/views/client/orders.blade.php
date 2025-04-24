@extends('layouts.client')

@section('title', 'Mes commandes')

@section('content')
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 bg-pink-50">
            <h1 class="text-lg leading-6 font-medium text-gray-900">Mes commandes</h1>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Historique de toutes vos commandes</p>
        </div>
        
        <div class="border-t border-gray-200">
            @if(count($orders) > 0)
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
                            @foreach($orders as $order)
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
                
                <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
                    {{ $orders->links() }}
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