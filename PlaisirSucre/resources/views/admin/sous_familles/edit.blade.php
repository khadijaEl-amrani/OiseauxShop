@extends('layouts.admin')

@section('title', 'Modifier une sous-famille')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.sous-familles.index') }}" class="text-pink-600 hover:text-pink-800">
            &larr; Retour à la liste
        </a>
    </div>

    <form action="{{ route('admin.sous-familles.update', $sousFamille) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="sous_famille" class="block text-sm font-medium text-gray-700">Nom de la sous-famille</label>
                <input type="text" name="sous_famille" id="sous_famille" value="{{ old('sous_famille', $sousFamille->sous_famille) }}" class="mt-1 focus:ring-pink-500 focus:border-pink-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>

            <div>
                <label for="famille_id" class="block text-sm font-medium text-gray-700">Famille</label>
                <select name="famille_id" id="famille_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                    <option value="">Sélectionner une famille</option>
                    @foreach($familles as $famille)
                        <option value="{{ $famille->id }}" {{ old('famille_id', $sousFamille->famille_id) == $famille->id ? 'selected' : '' }}>
                            {{ $famille->famille }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                Mettre à jour
            </button>
        </div>
    </form>
@endsection