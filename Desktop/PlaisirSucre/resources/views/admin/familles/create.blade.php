@extends('layouts.admin')

@section('title', 'Ajouter une famille')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.familles.index') }}" class="text-pink-600 hover:text-pink-800">
            &larr; Retour à la liste
        </a>
    </div>

    <form action="{{ route('admin.familles.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <div>
            <label for="famille" class="block text-sm font-medium text-gray-700">Nom de la famille</label>
            <input type="text" name="famille" id="famille" value="{{ old('famille') }}" class="mt-1 focus:ring-pink-500 focus:border-pink-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        </div>

        <div class="flex justify-end">
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                Enregistrer
            </button>
        </div>
    </form>
@endsection