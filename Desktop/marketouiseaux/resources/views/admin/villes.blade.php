@extends('layouts.app')

@section('title', 'Gestion des villes')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Administration</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action">
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
                    <a href="{{ route('admin.villes') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-map-marker-alt me-2"></i> Villes
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-9">
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Ajouter une ville</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.villes.store') }}" method="POST">
                        @csrf
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label for="ville" class="col-form-label">Nom de la ville</label>
                            </div>
                            <div class="col">
                                <input type="text" id="ville" name="ville" class="form-control @error('ville') is-invalid @enderror" required>
                                @error('ville')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-success">Ajouter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Liste des villes</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Nombre d'annonces</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($villes as $ville)
                                    <tr>
                                        <td>{{ $ville->id }}</td>
                                        <td>{{ $ville->ville }}</td>
                                        <td>{{ $ville->annonces_count }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $ville->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    
                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $ville->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Modifier la ville</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('admin.villes.update', $ville->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="ville{{ $ville->id }}" class="form-label">Nom de la ville</label>
                                                            <input type="text" class="form-control" id="ville{{ $ville->id }}" name="ville" value="{{ $ville->ville }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center mt-4">
                        {{ $villes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection