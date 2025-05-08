@extends('layouts.app')

@section('title', 'Mes annonces')

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
                    <a href="{{ route('user.annonces') }}" class="list-group-item list-group-item-action active">
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
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Mes annonces</h5>
                    <a href="{{ route('annonces.create') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-plus me-1"></i> Nouvelle annonce
                    </a>
                </div>
                <div class="card-body">
                    @if($annonces->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Titre</th>
                                        <th>Catégorie</th>
                                        <th>Prix</th>
                                        <th>Statut</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($annonces as $annonce)
                                        <tr>
                                            <td>
                                                <a href="{{ route('annonces.show', $annonce->id) }}" class="text-decoration-none">
                                                    {{ $annonce->titre }}
                                                </a>
                                            </td>
                                            <td>{{ $annonce->categorie->categorie }}</td>
                                            <td>{{ number_format($annonce->prix, 2, ',', ' ') }} €</td>
                                            <td>
                                                @if($annonce->valider)
                                                    <span class="badge bg-success">Publiée</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">En attente</span>
                                                @endif
                                            </td>
                                            <td>{{ $annonce->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('annonces.show', $annonce->id) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('annonces.edit', $annonce->id) }}" class="btn btn-sm btn-outline-secondary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $annonce->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                                
                                                <!-- Delete Modal -->
                                                <div class="modal fade" id="deleteModal{{ $annonce->id }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Confirmation de suppression</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Êtes-vous sûr de vouloir supprimer cette annonce ? Cette action est irréversible.
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                                <form action="{{ route('annonces.destroy', $annonce->id) }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $annonces->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-dove fa-3x text-muted mb-3"></i>
                            <p class="mb-3">Vous n'avez pas encore publié d'annonces.</p>
                            <a href="{{ route('annonces.create') }}" class="btn btn-success">
                                <i class="fas fa-plus me-1"></i> Publier une annonce
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection