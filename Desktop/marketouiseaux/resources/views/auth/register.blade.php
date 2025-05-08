@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h1 class="h4 mb-0">Inscription</h1>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nom" class="form-label">Nom</label>
                                <input id="nom" type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" value="{{ old('nom') }}" required autocomplete="nom" autofocus>
                                @error('nom')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="prenom" class="form-label">Prénom</label>
                                <input id="prenom" type="text" class="form-control @error('prenom') is-invalid @enderror" name="prenom" value="{{ old('prenom') }}" required autocomplete="prenom">
                                @error('prenom')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="mot_de_passe" class="form-label">Mot de passe</label>
                                <input id="mot_de_passe" type="password" class="form-control @error('mot_de_passe') is-invalid @enderror" name="mot_de_passe" required autocomplete="new-password">
                                @error('mot_de_passe')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="mot_de_passe-confirm" class="form-label">Confirmer le mot de passe</label>
                                <input id="mot_de_passe-confirm" type="password" class="form-control" name="mot_de_passe_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="tele" class="form-label">Téléphone</label>
                            <input id="tele" type="text" class="form-control @error('tele') is-invalid @enderror" name="tele" value="{{ old('tele') }}" required>
                            @error('tele')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="id_ville" class="form-label">Ville</label>
                            <select id="id_ville" class="form-select @error('id_ville') is-invalid @enderror" name="id_ville" required>
                                <option value="">Sélectionnez une ville</option>
                                @foreach($villes as $ville)
                                    <option value="{{ $ville->id }}" {{ old('id_ville') == $ville->id ? 'selected' : '' }}>
                                        {{ $ville->ville }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_ville')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="adresse" class="form-label">Adresse</label>
                            <textarea id="adresse" class="form-control @error('adresse') is-invalid @enderror" name="adresse" required>{{ old('adresse') }}</textarea>
                            @error('adresse')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox" name="terms" id="terms" required>
                            <label class="form-check-label" for="terms">
                                J'accepte les <a href="#">conditions d'utilisation</a> et la <a href="#">politique de confidentialité</a>
                            </label>
                            @error('terms')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">
                                S'inscrire
                            </button>
                        </div>
                        
                        <div class="text-center mt-3">
                            <p>Vous avez déjà un compte ? <a href="{{ route('login') }}">Connectez-vous</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection