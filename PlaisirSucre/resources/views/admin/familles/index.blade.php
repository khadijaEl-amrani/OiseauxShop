@extends('layouts.admin')

@section('title', 'Gestion des Familles')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold">Liste des familles</h2>
        <a href="{{ route('admin.familles.create') }}" class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
            Ajouter une famille
        </a>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom de la famille</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre de sous-familles</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($familles as $famille)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $famille->id }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $famille->famille }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $famille->sous_familles_count }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.familles.edit', $famille) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                Modifier
                            </a>
                            <form action="{{ route('admin.familles.destroy', $famille) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette famille?')">
                                    Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Aucune famille trouvée</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $familles->links() }}
    </div>
@endsection