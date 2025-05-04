<footer class="bg-light py-4 mt-5 border-top">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4 mb-md-0">
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-dove text-success me-2"></i>
                    <span class="fw-bold">BirdFinder</span>
                </div>
                <p class="text-muted small">La plateforme de référence pour l'achat et la vente d'oiseaux en France.</p>
                <p class="text-muted small">&copy; {{ date('Y') }} BirdFinder. Tous droits réservés.</p>
            </div>
            <div class="col-md-2 mb-4 mb-md-0">
                <h5 class="fs-6 mb-3">Navigation</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a href="{{ route('home') }}" class="nav-link p-0 text-muted">Accueil</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Perroquets</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Canaris</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Perruches</a></li>
                </ul>
            </div>
            <div class="col-md-2 mb-4 mb-md-0">
                <h5 class="fs-6 mb-3">Informations</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">À propos</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Contact</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Conditions d'utilisation</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Politique de confidentialité</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5 class="fs-6 mb-3">Restez connecté</h5>
                <p class="text-muted small">Inscrivez-vous à notre newsletter pour recevoir nos dernières annonces et actualités.</p>
                <form>
                    <div class="d-flex w-100 gap-2">
                        <input type="email" class="form-control" placeholder="Adresse email">
                        <button class="btn btn-success" type="button">S'inscrire</button>
                    </div>
                </form>
                <div class="d-flex gap-3 mt-3">
                    <a href="#" class="text-muted"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-muted"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-muted"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>