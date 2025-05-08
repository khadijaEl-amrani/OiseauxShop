@extends('layouts.app')

@section('title', 'Modifier l\'annonce')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h1 class="h3 mb-0">Modifier l'annonce</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('annonces.update', $annonce->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Title -->
                        <div class="mb-3">
                            <label for="titre" class="form-label">Titre de l'annonce <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('titre') is-invalid @enderror" id="titre" name="titre" value="{{ old('titre', $annonce->titre) }}" required>
                            @error('titre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Category -->
                        <div class="mb-3">
                            <label for="categorie_id" class="form-label">Catégorie <span class="text-danger">*</span></label>
                            <select class="form-select @error('categorie_id') is-invalid @enderror" id="categorie_id" name="categorie_id" required>
                                <option value="">Sélectionnez une catégorie</option>
                                @foreach($categories as $categorie)
                                    <option value="{{ $categorie->id }}" {{ old('categorie_id', $annonce->categorie_id) == $categorie->id ? 'selected' : '' }}>
                                        {{ $categorie->categorie }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categorie_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Price -->
                        <div class="mb-3">
                            <label for="prix" class="form-label">Prix (€) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" class="form-control @error('prix') is-invalid @enderror" id="prix" name="prix" value="{{ old('prix', $annonce->prix) }}" required>
                            @error('prix')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- City -->
                        <div class="mb-3">
                            <label for="ville_id" class="form-label">Ville <span class="text-danger">*</span></label>
                            <select class="form-select @error('ville_id') is-invalid @enderror" id="ville_id" name="ville_id" required>
                                <option value="">Sélectionnez une ville</option>
                                @foreach($villes as $ville)
                                    <option value="{{ $ville->id }}" {{ old('ville_id', $annonce->ville_id) == $ville->id ? 'selected' : '' }}>
                                        {{ $ville->ville }}
                                    </option>
                                @endforeach
                            </select>
                            @error('ville_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="6" required>{{ old('description', $annonce->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Décrivez en détail l'oiseau (âge, sexe, couleur, comportement, etc.)</small>
                        </div>
                        
                        <!-- Current Images -->
                        @if($annonce->images->count() > 0)
                            <div class="mb-3">
                                <label class="form-label">Images actuelles</label>
                                <div class="row">
                                    @foreach($annonce->images as $image)
                                        <div class="col-4 col-md-3 mb-3">
                                            <div class="position-relative">
                                                <img src="{{ asset('storage/' . $image->chemin_image) }}" class="img-thumbnail" style="height: 150px; width: 100%; object-fit: cover;">
                                                <div class="form-check position-absolute bottom-0 end-0 m-2 bg-white rounded p-1">
                                                    <input class="form-check-input" type="checkbox" name="delete_images[]" value="{{ $image->id }}" id="delete_image_{{ $image->id }}">
                                                    <label class="form-check-label" for="delete_image_{{ $image->id }}">
                                                        Supprimer
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        
                        <!-- Add New Images -->
                        <div class="mb-4">
                            <label for="images" class="form-label">Ajouter des images</label>
                            <input type="file" class="form-control @error('images.*') is-invalid @enderror" id="images" name="images[]" accept="image/*" multiple>
                            @error('images.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Formats acceptés: JPG, PNG, GIF. Taille max: 2MB par image.</small>
                            <div id="image-previews" class="row mt-3"></div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('user.annonces') }}" class="btn btn-outline-secondary">Annuler</a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-1"></i> Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/image-preview.js') }}"></script>
@endsection