@extends('layouts.admin')

@section('title', 'Gestion des Produits')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold">Liste des produits</h2>
        <a href="{{ route('admin.produits.create',['page' => $produits->currentPage()]) }}" class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
            Ajouter un produit
        </a>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Désignation</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catégorie</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Créé par</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($produits as $produit)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->designation }}" class="h-16 w-16 object-cover rounded">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $produit->designation }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ number_format($produit->prix, 2) }} €</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $produit->sousFamille->famille->famille }} > {{ $produit->sousFamille->sous_famille }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $produit->user->nom }} {{ $produit->user->prenom }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.produits.edit', ['produit'=>$produit,'page' => $produits->currentPage()]) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                Modifier
                            </a>
                            <form action="{{ route('admin.produits.destroy', ['produit'=>$produit,'page' => $produits->currentPage()]) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit?')">
                                    Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Aucun produit trouvé</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $produits->links() }}
    </div>
@endsection