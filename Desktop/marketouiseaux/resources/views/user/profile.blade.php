@extends('layouts.app')

@section('title', 'Mon Profil')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Mon compte</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('profile') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-user me-2"></i> Mon profil
                    </a>
                    <a href="{{ route('user.annonces') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-list me-2"></i> Mes annonces
                    </a>
                    <a href="{{ route('favoris.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-heart me-2"></i> Mes favoris
                    </a>
                    <a href="{{ route('password.form') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-lock me-2"></i> Changer mot de passe
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Informations personnelles</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nom" class="form-label">Nom</label>
                                <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom', $user->nom) }}" required>
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="prenom" class="form-label">Prénom</label>
                                <input type="text" class="form-control @error('prenom') is-invalid @enderror" id="prenom" name="prenom" value="{{ old('prenom', $user->prenom) }}" required>
                                @error('prenom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="tele" class="form-label">Téléphone</label>
                            <input type="text" class="form-control @error('tele') is-invalid @enderror" id="tele" name="tele" value="{{ old('tele', $user->tele) }}" required>
                            @error('tele')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="id_ville" class="form-label">Ville</label>
                            <select class="form-select @error('id_ville') is-invalid @enderror" id="id_ville" name="id_ville" required>
                                @foreach($villes as $ville)
                                    <option value="{{ $ville->id }}" {{ old('id_ville', $user->id_ville) == $ville->id ? 'selected' : '' }}>
                                        {{ $ville->ville }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_ville')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="adresse" class="form-label">Adresse</label>
                            <textarea class="form-control @error('adresse') is-invalid @enderror" id="adresse" name="adresse" rows="3" required>{{ old('adresse', $user->adresse) }}</textarea>
                            @error('adresse')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-end">
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