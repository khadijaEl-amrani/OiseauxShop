@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
<div class="container">
    <!-- Hero Section -->
    <section class="py-5 bg-light rounded-3 mb-4">
        <div class="container px-4">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="fw-bold mb-3">Trouvez votre oiseau idéal</h1>
                    <p class="lead mb-4">Parcourez des milliers d'annonces d'oiseaux de vendeurs de confiance à travers la France.</p>
                    <div class="d-flex justify-content-center">
                        <form action="{{ route('home') }}" method="GET" class="d-flex w-100 max-w-md">
                            <input type="text" name="search" class="form-control me-2" placeholder="Rechercher..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="row">
        <!-- Filters Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Filtres</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('home') }}" method="GET">
                        <!-- Category Filter -->
                        <div class="mb-3">
                            <label for="categorie_id" class="form-label fw-bold">Catégorie</label>
                            <select name="categorie_id" id="categorie_id" class="form-select">
                                <option value="">Toutes les catégories</option>
                                @foreach($categories as $categorie)
                                    <option value="{{ $categorie->id }}" {{ request('categorie_id') == $categorie->id ? 'selected' : '' }}>
                                        {{ $categorie->categorie }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- City Filter -->
                        <div class="mb-3">
                            <label for="ville_id" class="form-label fw-bold">Ville</label>
                            <select name="ville_id" id="ville_id" class="form-select">
                                <option value="">Toutes les villes</option>
                                @foreach($villes as $ville)
                                    <option value="{{ $ville->id }}" {{ request('ville_id') == $ville->id ? 'selected' : '' }}>
                                        {{ $ville->ville }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Price Range Filter -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Prix (€)</label>
                            <div class="row">
                                <div class="col-6">
                                    <input type="number" name="prix_min" class="form-control" placeholder="Min" value="{{ request('prix_min') }}">
                                </div>
                                <div class="col-6">
                                    <input type="number" name="prix_max" class="form-control" placeholder="Max" value="{{ request('prix_max') }}">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Appliquer les filtres</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Announcements List -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h4 mb-0">Annonces ({{ $annonces->total() }})</h2>
                <div class="d-flex align-items-center">
                    <label for="sort" class="me-2 text-nowrap">Trier par:</label>
                    <select id="sort" class="form-select form-select-sm" onchange="window.location.href=this.value">
                        <option value="{{ route('home', array_merge(request()->except('sort', 'page'), ['sort' => 'newest'])) }}" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>
                            Plus récentes
                        </option>
                        <option value="{{ route('home', array_merge(request()->except('sort', 'page'), ['sort' => 'price-low'])) }}" {{ request('sort') == 'price-low' ? 'selected' : '' }}>
                            Prix: croissant
                        </option>
                        <option value="{{ route('home', array_merge(request()->except('sort', 'page'), ['sort' => 'price-high'])) }}" {{ request('sort') == 'price-high' ? 'selected' : '' }}>
                            Prix: décroissant
                        </option>
                    </select>
                </div>
            </div>

            @if($annonces->count() > 0)
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    @foreach($annonces as $annonce)
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
                                
                                @auth
                                    <button class="btn btn-sm position-absolute top-0 end-0 m-2 bg-white rounded-circle p-2 favorite-btn" 
                                            data-annonce-id="{{ $annonce->id }}"
                                            data-is-favorite="{{ Auth::user()->annoncesFavorites()->where('annonce_id', $annonce->id)->exists() ? 'true' : 'false' }}">
                                        <i class="fas fa-heart {{ Auth::user()->annoncesFavorites()->where('annonce_id', $annonce->id)->exists() ? 'text-danger' : 'text-muted' }}"></i>
                                    </button>
                                @endauth
                                
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
                    {{ $annonces->appends(request()->except('page'))->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    Aucune annonce ne correspond à vos critères de recherche.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('.favorite-btn').click(function(e) {
            e.preventDefault();
            
            var button = $(this);
            var annonceId = button.data('annonce-id');
            
            $.ajax({
                url: '/favoris/' + annonceId,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status) {
                        button.find('i').removeClass('text-muted').addClass('text-danger');
                    } else {
                        button.find('i').removeClass('text-danger').addClass('text-muted');
                    }
                }
            });
        });
    });
</script>
@endsection