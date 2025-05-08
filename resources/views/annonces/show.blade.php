@extends('layouts.app')

@section('title', $annonce->titre)

@section('content')
<div class="container">
    <div class="mb-4">
        <a href="{{ url()->previous() }}" class="text-decoration-none">
            <i class="fas fa-arrow-left me-1"></i> Retour aux annonces
        </a>
    </div>
    
    <div class="row">
        <div class="col-lg-8">
            <!-- Announcement Images -->
            <div class="card mb-4">
                <div class="card-body">
                    @if($annonce->images->count() > 0)
                        <div id="annonceCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($annonce->images as $key => $image)
                                    <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/' . $image->chemin_image) }}" class="d-block w-100 rounded" alt="{{ $annonce->titre }}" style="height: 400px; object-fit: contain;">
                                    </div>
                                @endforeach
                            </div>
                            @if($annonce->images->count() > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#annonceCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#annonceCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            @endif
                        </div>
                        
                        @if($annonce->images->count() > 1)
                            <div class="row mt-3">
                                @foreach($annonce->images as $key => $image)
                                    <div class="col-3 mb-3">
                                        <img src="{{ asset('storage/' . $image->chemin_image) }}" class="img-thumbnail" alt="Thumbnail" style="height: 80px; object-fit: cover; cursor: pointer;" onclick="$('#annonceCarousel').carousel({{ $key }})">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div class="bg-light d-flex justify-content-center align-items-center rounded" style="height: 400px;">
                            <i class="fas fa-dove fa-5x text-muted"></i>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Announcement Details -->
            <div class="card mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h1 class="h3 mb-0">{{ $annonce->titre }}</h1>
                    <span class="badge bg-success fs-5">{{ number_format($annonce->prix, 2, ',', ' ') }} €</span>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="d-flex mb-3">
                            <div class="me-4">
                                <small class="text-muted d-block">Catégorie</small>
                                <span>{{ $annonce->categorie->categorie }}</span>
                            </div>
                            <div class="me-4">
                                <small class="text-muted d-block">Localisation</small>
                                <span>{{ $annonce->ville->ville }}</span>
                            </div>
                            <div>
                                <small class="text-muted d-block">Publiée le</small>
                                <span>{{ $annonce->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                        
                        <div class="d-flex mb-3">
                            @auth
                                <form action="{{ route('favoris.toggle', $annonce->id) }}" method="POST" class="me-2">
                                    @csrf
                                    <button type="submit" class="btn {{ $isFavorite ? 'btn-danger' : 'btn-outline-danger' }}">
                                        <i class="fas fa-heart me-1"></i> 
                                        {{ $isFavorite ? 'Retirer des favoris' : 'Ajouter aux favoris' }}
                                    </button>
                                </form>
                            @endauth
                            <button class="btn btn-outline-secondary" onclick="shareAnnouncement()">
                                <i class="fas fa-share-alt me-1"></i> Partager
                            </button>
                        </div>
                    </div>
                    
                    <h5>Description</h5>
                    <div class="mb-4">
                        {!! nl2br(e($annonce->description)) !!}
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Seller Information -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Informations sur le vendeur</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-light rounded-circle p-3 me-3">
                            <i class="fas fa-user text-muted"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $annonce->user->prenom }} {{ $annonce->user->nom }}</h6>
                            <small class="text-muted">Membre depuis {{ $annonce->user->created_at->format('F Y') }}</small>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-phone text-muted me-2"></i>
                            <span>{{ $annonce->user->tele }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-map-marker-alt text-muted me-2"></i>
                            <span>{{ $annonce->ville->ville }}</span>
                        </div>
                    </div>
                    
                    <button class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#contactModal">
                        Contacter le vendeur
                    </button>
                </div>
            </div>
            
            <!-- Similar Announcements -->
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Annonces similaires</h5>
                </div>
                <div class="card-body">
                    @if($similarAnnonces->count() > 0)
                        @foreach($similarAnnonces as $similarAnnonce)
                            <div class="d-flex mb-3 {{ !$loop->last ? 'border-bottom pb-3' : '' }}">
                                <div class="me-3" style="width: 80px; height: 80px;">
                                    @if($similarAnnonce->images->count() > 0)
                                        <img src="{{ asset('storage/' . $similarAnnonce->images->first()->chemin_image) }}" class="img-fluid rounded" alt="{{ $similarAnnonce->titre }}" style="width: 80px; height: 80px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex justify-content-center align-items-center rounded" style="width: 80px; height: 80px;">
                                            <i class="fas fa-dove text-muted"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h6 class="mb-1">
                                        <a href="{{ route('annonces.show', $similarAnnonce->id) }}" class="text-decoration-none text-dark">
                                            {{ $similarAnnonce->titre }}
                                        </a>
                                    </h6>
                                    <div class="text-success fw-bold">{{ number_format($similarAnnonce->prix, 2, ',', ' ') }} €</div>
                                    <small class="text-muted">{{ $similarAnnonce->ville->ville }}</small>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted">Aucune annonce similaire trouvée.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Contact Modal -->
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contactModalLabel">Contacter {{ $annonce->user->prenom }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="message-subject" class="form-label">Sujet</label>
                        <input type="text" class="form-control" id="message-subject" value="À propos de : {{ $annonce->titre }}">
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="form-label">Message</label>
                        <textarea class="form-control" id="message-text" rows="5" placeholder="Écrivez votre message ici..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-success">Envoyer</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function shareAnnouncement() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $annonce->titre }}',
                text: 'Découvrez cette annonce sur BirdFinder: {{ $annonce->titre }}',
                url: window.location.href
            })
            .catch(error => console.log('Erreur de partage', error));
        } else {
            // Fallback pour les navigateurs qui ne supportent pas l'API Web Share
            alert('Copiez ce lien pour partager: ' + window.location.href);
        }
    }
</script>
@endsection