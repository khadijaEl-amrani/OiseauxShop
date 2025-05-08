<header class="bg-white shadow-sm">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <i class="fas fa-dove text-success me-2"></i>
                <span class="fw-bold">BirdFinder</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}?categorie_id=1">Perroquets</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}?categorie_id=2">Canaris</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}?categorie_id=3">Perruches</a>
                    </li>
                </ul>
                <div class="d-flex">
                    @auth
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->prenom }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                @if(Auth::user()->is_admin)
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Administration</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ route('profile') }}">Mon profil</a></li>
                                <li><a class="dropdown-item" href="{{ route('user.annonces') }}">Mes annonces</a></li>
                                <li><a class="dropdown-item" href="{{ route('favoris.index') }}">Mes favoris</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Déconnexion</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        <a href="{{ route('annonces.create') }}" class="btn btn-success ms-2">
                            <i class="fas fa-plus me-1"></i> Publier
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-success me-2">Connexion</a>
                        <a href="{{ route('register') }}" class="btn btn-success">Inscription</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
</header>