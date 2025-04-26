@extends('layouts.admin')

@section('title', 'Modifier la commande #' . $commande->id)

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.commandes.index') }}" class="text-pink-600 hover:text-pink-800">
            &larr; Retour à la liste
        </a>
    </div>

    <form action="{{ route('admin.commandes.update', $commande) }}" method="POST" class="space-y-6" id="commande-form">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="client_id" class="block text-sm font-medium text-gray-700">Client</label>
                <select name="client_id" id="client_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                    <option value="">Sélectionner un client</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ old('client_id', $commande->client_id) == $client->id ? 'selected' : '' }}>
                            {{ $client->nom }} {{ $client->prenom }} - {{ $client->telephone }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="commande_date" class="block text-sm font-medium text-gray-700">Date de commande</label>
                <input type="datetime-local" name="commande_date" id="commande_date" value="{{ old('commande_date', $commande->commande_date->format('Y-m-d\TH:i')) }}" class="mt-1 focus:ring-pink-500 focus:border-pink-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg p-4 mt-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Articles de la commande</h3>
            
            <div id="produits-container">
                @foreach($commande->detailsCommandes as $index => $detail)
                    <div class="produit-item grid grid-cols-1 md:grid-cols-12 gap-4 mb-4 items-end">
                        <div class="md:col-span-6">
                            <label class="block text-sm font-medium text-gray-700">Produit</label>
                            <select name="produits[{{ $index }}][id]" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                                <option value="">Sélectionner un produit</option>
                                @foreach($produits as $produit)
                                    <option value="{{ $produit->id }}" data-prix="{{ $produit->prix }}" {{ $detail->produit_id == $produit->id ? 'selected' : '' }}>
                                        {{ $produit->designation }} - {{ number_format($produit->prix, 2) }} €
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-3">
                            <label class="block text-sm font-medium text-gray-700">Quantité</label>
                            <input type="number" name="produits[{{ $index }}][quantite]" min="0.01" step="0.01" value="{{ old('produits.' . $index . '.quantite', $detail->quantité) }}" class="mt-1 focus:ring-pink-500 focus:border-pink-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Prix</label>
                            <div class="mt-1 text-sm text-gray-900 py-2">{{ number_format($detail->produit->prix * $detail->quantité, 2) }} €</div>
                        </div>
                        <div class="md:col-span-1">
                            <button type="button" class="remove-produit text-red-600 hover:text-red-900" {{ $index == 0 && $commande->detailsCommandes->count() == 1 ? 'style=display:none' : '' }}>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @endforeach

                @if($commande->detailsCommandes->isEmpty())
                    <div class="produit-item grid grid-cols-1 md:grid-cols-12 gap-4 mb-4 items-end">
                        <div class="md:col-span-6">
                            <label class="block text-sm font-medium text-gray-700">Produit</label>
                            <select name="produits[0][id]" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                                <option value="">Sélectionner un produit</option>
                                @foreach($produits as $produit)
                                    <option value="{{ $produit->id }}" data-prix="{{ $produit->prix }}">
                                        {{ $produit->designation }} - {{ number_format($produit->prix, 2) }} €
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-3">
                            <label class="block text-sm font-medium text-gray-700">Quantité</label>
                            <input type="number" name="produits[0][quantite]" min="0.01" step="0.01" value="1" class="mt-1 focus:ring-pink-500 focus:border-pink-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Prix</label>
                            <div class="mt-1 text-sm text-gray-900 py-2">0.00 €</div>
                        </div>
                        <div class="md:col-span-1">
                            <button type="button" class="remove-produit text-red-600 hover:text-red-900" style="display: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
            
            <div class="mt-4">
                <button type="button" id="add-produit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Ajouter un produit
                </button>
            </div>
            
            <div class="mt-6 flex justify-end">
                <div class="text-right">
                    <div class="text-sm text-gray-500">Total</div>
                    <div class="text-lg font-medium text-gray-900" id="total-commande">
                        @php
                            $total = 0;
                            foreach($commande->detailsCommandes as $detail) {
                                $total += $detail->produit->prix * $detail->quantité;
                            }
                            echo number_format($total, 2) . ' €';
                        @endphp
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                Mettre à jour la commande
            </button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let produitIndex = {{ $commande->detailsCommandes->count() > 0 ? $commande->detailsCommandes->count() - 1 : 0 }};
            const produitsContainer = document.getElementById('produits-container');
            const addProduitButton = document.getElementById('add-produit');
            const totalCommandeElement = document.getElementById('total-commande');
            
            // Add new product row
            addProduitButton.addEventListener('click', function() {
                produitIndex++;
                const produitTemplate = document.querySelector('.produit-item').cloneNode(true);
                
                // Update name attributes
                produitTemplate.querySelectorAll('select, input').forEach(element => {
                    if (element.name) {
                        element.name = element.name.replace(/\[\d+\]/, `[${produitIndex}]`);
                        element.value = element.tagName === 'SELECT' ? '' : (element.type === 'number' ? '1' : '');
                    }
                });
                
                // Reset price display
                produitTemplate.querySelector('div.text-sm.text-gray-900').textContent = '0.00 €';
                
                // Show remove button
                produitTemplate.querySelector('.remove-produit').style.display = 'block';
                
                produitsContainer.appendChild(produitTemplate);
                
                // Add event listeners to the new row
                addEventListeners(produitTemplate);
            });
            
            // Remove product row
            produitsContainer.addEventListener('click', function(e) {
                if (e.target.closest('.remove-produit')) {
                    e.target.closest('.produit-item').remove();
                    updateTotal();
                }
            });
            
            // Add event listeners to all existing rows
            document.querySelectorAll('.produit-item').forEach(row => {
                addEventListeners(row);
            });
            
            function addEventListeners(row) {
                const productSelect = row.querySelector('select[name*="[id]"]');
                const quantityInput = row.querySelector('input[name*="[quantite]"]');
                const priceDisplay = row.querySelector('div.text-sm.text-gray-900');
                
                productSelect.addEventListener('change', function() {
                    updateRowPrice(productSelect, quantityInput, priceDisplay);
                    updateTotal();
                });
                
                quantityInput.addEventListener('input', function() {
                    updateRowPrice(productSelect, quantityInput, priceDisplay);
                    updateTotal();
                });
            }
            
            function updateRowPrice(productSelect, quantityInput, priceDisplay) {
                const selectedOption = productSelect.options[productSelect.selectedIndex];
                if (selectedOption && selectedOption.value) {
                    const prix = parseFloat(selectedOption.dataset.prix);
                    const quantite = parseFloat(quantityInput.value) || 0;
                    const total = prix * quantite;
                    priceDisplay.textContent = total.toFixed(2) + ' €';
                } else {
                    priceDisplay.textContent = '0.00 €';
                }
            }
            
            function updateTotal() {
                let total = 0;
                document.querySelectorAll('.produit-item').forEach(row => {
                    const productSelect = row.querySelector('select[name*="[id]"]');
                    const quantityInput = row.querySelector('input[name*="[quantite]"]');
                    
                    const selectedOption = productSelect.options[productSelect.selectedIndex];
                    if (selectedOption && selectedOption.value) {
                        const prix = parseFloat(selectedOption.dataset.prix);
                        const quantite = parseFloat(quantityInput.value) || 0;
                        total += prix * quantite;
                    }
                });
                
                totalCommandeElement.textContent = total.toFixed(2) + ' €';
            }
        });
    </script>
@endsection