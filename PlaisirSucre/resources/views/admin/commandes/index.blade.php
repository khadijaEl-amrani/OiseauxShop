@extends('layouts.admin')

@section('title', 'Gestion des Commandes')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold">Liste des commandes</h2>
        <a href="{{ route('admin.commandes.create') }}" class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
            Ajouter une commande
        </a>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre d'articles</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($commandes as $commande)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $commande->id }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $commande->client->nom }} {{ $commande->client->prenom }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $commande->commande_date->format('d/m/Y H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $commande->detailsCommandes->count() }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.commandes.show', $commande) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                Voir
                            </a>
                            <a href="{{ route('admin.commandes.edit', $commande) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                Modifier
                            </a>
                            <form action="{{ route('admin.commandes.destroy', $commande) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette commande?')">
                                    Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Aucune commande trouvée</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $commandes->links() }}
    </div>
@endsection