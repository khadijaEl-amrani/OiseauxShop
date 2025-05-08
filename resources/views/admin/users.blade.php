@extends('layouts.app')

@section('title', 'Gestion des utilisateurs')

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
                    <a href="{{ route('admin.users') }}" class="list-group-item list-group-item-action active">
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
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Liste des utilisateurs</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                    <th>Ville</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->prenom }} {{ $user->nom }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->tele }}</td>
                                        <td>{{ $user->ville->ville }}</td>
                                        <td>
                                            @if($user->is_admin)
                                                <span class="badge bg-info">Admin</span>
                                            @elseif($user->blockes)
                                                <span class="badge bg-danger">Bloqué</span>
                                            @else
                                                <span class="badge bg-success">Actif</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!$user->is_admin)
                                                <form action="{{ route('admin.users.toggle-block', $user->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm {{ $user->blockes ? 'btn-outline-success' : 'btn-outline-danger' }}">
                                                    <i class="fas {{ $user->blockes ? 'fa-unlock' : 'fa-ban' }}"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection