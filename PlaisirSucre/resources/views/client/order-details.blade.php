@extends('layouts.client')

@section('title', 'Détails de la commande #' . $order->id)

@section('content')
    <div class="mb-6">
        <a href="{{ route('client.orders') }}" class="text-pink-600 hover:text-pink-800">
            &larr; Retour à mes commandes
        </a>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6 bg-pink-50">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Informations sur la commande</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Détails et articles de la commande.</p>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Numéro de commande</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">#{{ $order->id }}</dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Date de commande</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $order->commande_date->format('d/m/Y H:i') }}</dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Adresse de livraison</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $order->client->adresse }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 bg-pink-50">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Articles commandés</h3>
        </div>
        <div class="border-t border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produit</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix unitaire</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php $total = 0; @endphp
                    @forelse($order->detailsCommandes as $detail)
                        @php 
                            $sousTotal = $detail->produit->prix * $detail->quantité;
                            $total += $sousTotal;
                        @endphp
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $detail->produit->image) }}" alt="{{ $detail->produit->designation }}">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $detail->produit->designation }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ number_format($detail->produit->prix, 2) }} €</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $detail->quantité }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ number_format($sousTotal, 2) }} €</div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Aucun article dans cette commande</td>
                        </tr>
                    @endforelse
                    <tr class="bg-gray-50">
                        <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">Total</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ number_format($total, 2) }} €</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection