@extends('layouts.admin')

@section('title', 'Ajouter un utilisateur')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="text-pink-600 hover:text-pink-800">
            &larr; Retour à la liste
        </a>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="cin" class="block text-sm font-medium text-gray-700">CIN</label>
                <input type="text" name="cin" id="cin" value="{{ old('cin') }}" class="mt-1 focus:ring-pink-500 focus:border-pink-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>

            <div>
                <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                <input type="text" name="nom" id="nom" value="{{ old('nom') }}" class="mt-1 focus:ring-pink-500 focus:border-pink-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>

            <div>
                <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
                <input type="text" name="prenom" id="prenom" value="{{ old('prenom') }}" class="mt-1 focus:ring-pink-500 focus:border-pink-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="mt-1 focus:ring-pink-500 focus:border-pink-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>

            <div>
                <label for="telephone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                <input type="text" name="telephone" id="telephone" value="{{ old('telephone') }}" class="mt-1 focus:ring-pink-500 focus:border-pink-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                <input type="password" name="password" id="password" class="mt-1 focus:ring-pink-500 focus:border-pink-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 focus:ring-pink-500 focus:border-pink-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>

            <div class="flex items-center">
                <input type="hidden" name="admin" value="0">
                <input type="checkbox" name="admin" id="admin" value="1" class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded" {{ old('admin') ? 'checked' : '' }}>
                <label for="admin" class="ml-2 block text-sm text-gray-900">
                    Administrateur
                </label>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                Enregistrer
            </button>
        </div>
    </form>
@endsection 