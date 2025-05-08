@extends('layouts.app')

@section('title', 'Mes favoris')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Mon compte</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('profile') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-user me-2"></i> Mon profil
                    </a>
                    <a href="{{ route('user.annonces') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-list me-2"></i> Mes annonces
                    </a>
                    <a href="{{ route('favoris.index') }}" class="list-group-item list-group-item-action active">
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
                    <h5 class="mb-0">Mes annonces favorites</h5>
                </div>
                <div class="card-body">
                    @if($favoris->count() > 0)
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                            @foreach($favoris as $annonce)
                                <div class="col">
                                    <div class="card h-100 position-relative">
                                        <a href="{{ route('annonces.show', $annonce->id) }}" class="text-decoration-none">
                                            @if($annonce->images->count() > 0)
                                                <img src="{{ asset('storage/' . $annonce->images->first()->chemin_image) }}" class="card-img-top" alt="{{ $annonce->titre }}" style="height: 200px; object-fit: cover;">
                                            @else
                                                <div class="bg-light d-flex justify-content-center align-items-center" style="height: 200px;">
                                                    <i class="fas fa-dove fa-3x text-muted"></i>
                                                </div>
                                            @endif
                                        </a>
                                        
                                        <form action="{{ route('favoris.toggle', $annonce->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm position-absolute top-0 end-0 m-2 bg-white rounded-circle p-2">
                                                <i class="fas fa-heart text-danger"></i>
                                            </button>
                                        </form>
                                        
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <a href="{{ route('annonces.show', $annonce->id) }}" class="text-decoration-none text-dark">
                                                    {{ $annonce->titre }}
                                                </a>
                                            </h5>
                                            <p class="card-text text-success fw-bold">{{ number_format($annonce->prix, 2, ',', ' ') }} €</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">
                                                    <i class="fas fa-map-marker-alt me-1"></i> {{ $annonce->ville->ville }}
                                                </small>
                                                <small class="text-muted">
                                                    {{ $annonce->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white">
                                            <a href="{{ route('annonces.show', $annonce->id) }}" class="btn btn-outline-success w-100">Voir détails</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $favoris->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-heart fa-3x text-muted mb-3"></i>
                            <p class="mb-3">Vous n'avez pas encore d'annonces favorites.</p>
                            <a href="{{ route('home') }}" class="btn btn-success">
                                <i class="fas fa-search me-1"></i> Parcourir les annonces
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection