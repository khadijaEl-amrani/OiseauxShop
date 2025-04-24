@extends('layouts.admin')

@section('title', 'Gestion des Commentaires')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold">Liste des commentaires</h2>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produit</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Commentaire</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($commentaires as $commentaire)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $commentaire->id }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $commentaire->produit->designation }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $commentaire->client->nom }} {{ $commentaire->client->prenom }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $commentaire->commentaire_date->format('d/m/Y H:i') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 max-w-xs truncate">{{ $commentaire->contenu }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button type="button" class="text-blue-600 hover:text-blue-900 mr-3 view-comment" data-comment="{{ $commentaire->contenu }}">
                                Voir
                            </button>
                            <form action="{{ route('admin.commentaires.destroy', $commentaire) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire?')">
                                    Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Aucun commentaire trouvé</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $commentaires->links() }}
    </div>

    <!-- Modal for viewing full comment -->
    <div id="comment-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg p-6 max-w-lg w-full">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Commentaire complet</h3>
                <button type="button" id="close-modal" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Fermer</span>
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="mt-2">
                <p id="comment-content" class="text-sm text-gray-500"></p>
            </div>
            <div class="mt-4">
                <button type="button" id="close-modal-btn" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-pink-600 border border-transparent rounded-md hover:bg-pink-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-pink-500">
                    Fermer
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('comment-modal');
            const commentContent = document.getElementById('comment-content');
            const closeModalBtn = document.getElementById('close-modal-btn');
            const closeModalX = document.getElementById('close-modal');
            
            document.querySelectorAll('.view-comment').forEach(button => {
                button.addEventListener('click', function() {
                    const comment = this.getAttribute('data-comment');
                    commentContent.textContent = comment;
                    modal.classList.remove('hidden');
                });
            });
            
            closeModalBtn.addEventListener('click', function() {
                modal.classList.add('hidden');
            });
            
            closeModalX.addEventListener('click', function() {
                modal.classList.add('hidden');
            });
            
            // Close modal when clicking outside
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        });
    </script>
@endsection