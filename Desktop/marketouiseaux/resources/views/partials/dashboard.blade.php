@extends('layouts.app')

@section('title', 'Administration')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Administration</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-tachometer-alt me-2"></i> Tableau de bord
                    </a>
                    <a href="{{ route('admin.annonces') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-list me-2"></i> Annonces
                    </a>
                    <a href="{{ route('admin.users') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-users me-2"></i> Utilisateurs
                    </a>
                    <a href="{{ route('admin.categories') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-tags me-2"></i> Catégories
                    </a>
                    <a href="{{ route('admin.villes') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-map-marker-alt me-2"></i> Villes
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-9">
            <h1 class="h3 mb-4">Tableau de bord</h1>
            
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mb-4">
                <div class="col">
                    <div class="card h-100 border-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title text-muted mb-0">Utilisateurs</h6>
                                    <h2 class="my-2">{{ $totalUsers }}</h2>
                                </div>
                                <div class="bg-light rounded-circle p-3">
                                    <i class="fas fa-users text-primary"></i>
                                </div>
                            </div>
                            <a href="{{ route('admin.users') }}" class="text-decoration-none">Voir détails</a>
                        </div>
                    </div>
                </div>
                
                <div class="col">
                    <div class="card h-100 border-success">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title text-muted mb-0">Annonces</h6>
                                    <h2 class="my-2">{{ $totalAnnonces }}</h2>
                                </div>
                                <div class="bg-light rounded-circle p-3">
                                    <i class="fas fa-list text-success"></i>
                                </div>
                            </div>
                            <a href="{{ route('admin.annonces') }}" class="text-decoration-none">Voir détails</a>
                        </div>
                    </div>
                </div>
                
                <div class="col">
                    <div class="card h-100 border-warning">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title text-muted mb-0">En attente</h6>
                                    <h2 class="my-2">{{ $pendingAnnonces }}</h2>
                                </div>
                                <div class="bg-light rounded-circle p-3">
                                    <i class="fas fa-clock text-warning"></i>
                                </div>
                            </div>
                            <a href="{{ route('admin.annonces') }}?status=pending" class="text-decoration-none">Voir détails</a>
                        </div>
                    </div>
                </div>
                
                <div class="col">
                    <div class="card h-100 border-info">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title text-muted mb-0">Catégories</h6>
                                    <h2 class="my-2">{{ $totalCategories }}</h2>
                                </div>
                                <div class="bg-light rounded-circle p-3">
                                    <i class="fas fa-tags text-info"></i>
                                </div>
                            </div>
                            <a href="{{ route('admin.categories') }}" class="text-decoration-none">Voir détails</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Dernières annonces</h5>
                            <a href="{{ route('admin.annonces') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                @foreach(App\Models\Annonce::with(['user', 'categorie'])->latest()->take(5)->get() as $annonce)
                                    <a href="{{ route('annonces.show', $annonce->id) }}" class="list-group-item list-group-item-action">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1">{{ $annonce->titre }}</h6>
                                                <small class="text-muted">
                                                    Par {{ $annonce->user->prenom }} {{ $annonce->user->nom }} - {{ $annonce->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                            <span class="badge bg-{{ $annonce->valider ? 'success' : 'warning text-dark' }}">
                                                {{ $annonce->valider ? 'Publiée' : 'En attente' }}
                                            </span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Derniers utilisateurs</h5>
                            <a href="{{ route('admin.users') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                @foreach(App\Models\User::with('ville')->latest()->take(5)->get() as $user)
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1">{{ $user->prenom }} {{ $user->nom }}</h6>
                                                <small class="text-muted">
                                                    {{ $user->email }} - {{ $user->ville->ville }} - Inscrit {{ $user->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                            <span class="badge bg-{{ $user->blockes ? 'danger' : 'success' }}">
                                                {{ $user->blockes ? 'Bloqué' : 'Actif' }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection