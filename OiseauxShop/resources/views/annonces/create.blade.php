@extends('layouts.app')

@section('title', 'Publier une annonce')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h1 class="h3 mb-0">Publier une annonce</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('annonces.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Title -->
                        <div class="mb-3">
                            <label for="titre" class="form-label">Titre de l'annonce <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('titre') is-invalid @enderror" id="titre" name="titre" value="{{ old('titre') }}" required>
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
                                    <option value="{{ $categorie->id }}" {{ old('categorie_id') == $categorie->id ? 'selected' : '' }}>
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
                            <input type="number" step="0.01" min="0" class="form-control @error('prix') is-invalid @enderror" id="prix" name="prix" value="{{ old('prix') }}" required>
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
                                    <option value="{{ $ville->id }}" {{ old('ville_id') == $ville->id ? 'selected' : '' }}>
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
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="6" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Décrivez en détail l'oiseau (âge, sexe, couleur, comportement, etc.)</small>
                        </div>
                        
                        <!-- Images -->
                        <div class="mb-4">
                            <label for="images" class="form-label">Images (max 5) <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('images.*') is-invalid @enderror" id="images" name="images[]" accept="image/*" multiple>
                            @error('images.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Formats acceptés: JPG, PNG, GIF. Taille max: 2MB par image.</small>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">Annuler</a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-paper-plane me-1"></i> Publier l'annonce
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')@section('scripts')
<script src="{{ asset('js/image-preview.js') }}"></script>
@endsection
<script>
    // Preview images before upload
    document.getElementById('images').addEventListener('change', function(event) {
        // Remove existing previews
        const previewContainer = document.getElementById('image-previews');
        if (previewContainer) {
            previewContainer.remove();
        }
        
        // Create new preview container
        const newPreviewContainer = document.createElement('div');
        newPreviewContainer.id = 'image-previews';
        newPreviewContainer.className = 'row mt-3';
        
        // Insert after the file input
        this.parentNode.insertBefore(newPreviewContainer, this.nextSibling);
        
        // Add previews for each file
        for (const file of event.target.files) {
            if (file.type.match('image.*')) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const previewCol = document.createElement('div');
                    previewCol.className = 'col-4 col-md-3 mb-3';
                    
                    const previewImg = document.createElement('img');
                    previewImg.src = e.target.result;
                    previewImg.className = 'img-thumbnail';
                    previewImg.style = 'height: 150px; width: 100%; object-fit: cover;';
                    
                    previewCol.appendChild(previewImg);
                    newPreviewContainer.appendChild(previewCol);
                }
                
                reader.readAsDataURL(file);
            }
        }
    });
</script>


@endsection