@extends('layouts.admin')

@section('title', 'Modifier un produit')

@section('content')
    <div class="mb-6">
        <a href="{{ url()->previous() }}" class="text-pink-600 hover:text-pink-800">
            &larr; Retour à la liste
        </a>
    </div>

    <form action="{{ route('admin.produits.update', $produit) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        <input type="hidden" name="page" value="{{ request()->input('page', 1) }}">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="designation" class="block text-sm font-medium text-gray-700">Désignation</label>
                <input type="text" name="designation" id="designation" value="{{ old('designation', $produit->designation) }}" class="mt-1 focus:ring-pink-500 focus:border-pink-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>

            <div>
                <label for="prix" class="block text-sm font-medium text-gray-700">Prix</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">€</span>
                    </div>
                    <input type="number" name="prix" id="prix" step="0.01" min="0" value="{{ old('prix', $produit->prix) }}" class="focus:ring-pink-500 focus:border-pink-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md">
                </div>
            </div>

            <div>
                <label for="sous_famille_id" class="block text-sm font-medium text-gray-700">Sous-famille</label>
                <select name="sous_famille_id" id="sous_famille_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                    <option value="">Sélectionner une sous-famille</option>
                    @foreach($sousFamilles as $sousFamille)
                        <option value="{{ $sousFamille->id }}" {{ old('sous_famille_id', $produit->sous_famille_id) == $sousFamille->id ? 'selected' : '' }}>
                            {{ $sousFamille->famille->famille }} > {{ $sousFamille->sous_famille }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700">Créé par</label>
                <select name="user_id" id="user_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                    <option value="">Sélectionner un utilisateur</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id', $produit->user_id) == $user->id ? 'selected' : '' }}>
                            {{ $user->nom }} {{ $user->prenom }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" rows="4" class="mt-1 focus:ring-pink-500 focus:border-pink-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('description', $produit->description) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Image actuelle</label>
            <div class="mt-2">
                <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->designation }}" class="h-32 w-32 object-cover rounded-md">
            </div>
        </div>

        <div>
            <label for="image" class="block text-sm font-medium text-gray-700">Nouvelle image (laisser vide pour conserver l'image actuelle)</label>
            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                <div class="space-y-1 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="flex text-sm text-gray-600">
                        <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-pink-600 hover:text-pink-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-pink-500">
                            <span>Télécharger un fichier</span>
                            <input id="image" name="image" type="file" class="sr-only">
                        </label>
                        <p class="pl-1">ou glisser-déposer</p>
                    </div>
                    <p class="text-xs text-gray-500">PNG, JPG, GIF jusqu'à 2MB</p>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                Mettre à jour
            </button>
        </div>
    </form>
@endsection