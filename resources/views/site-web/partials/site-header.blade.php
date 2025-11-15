<!-- Topbar Start -->
<div class="container-fluid bg-dark py-3 px-lg-5 d-none d-lg-block">
    <div class="row">
        <div class="col-md-6 text-center text-lg-left mb-2 mb-lg-0">
            <div class="d-inline-flex align-items-center">
                <a class="text-body pr-3" href=""><i class="fa fa-phone-alt mr-2"></i>+223 92190993</a>
                <span class="text-body">|</span>
                <a class="text-body px-3" href=""><i class="fa fa-envelope mr-2"></i>contact@synem.ml</a>
            </div>
        </div>
        <div class="col-md-6 text-center text-lg-right">
            <div class="d-inline-flex align-items-center">
                <a class="text-body px-3" href="">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a class="text-body px-3" href="">
                    <i class="fab fa-twitter"></i>
                </a>
                <a class="text-body px-3" href="">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a class="text-body px-3" href="">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- Topbar End -->

<!-- Navbar Start -->
<div class="container-fluid position-relative nav-bar p-0">
    <div class="position-relative px-lg-5" style="z-index: 9;">
        <nav class="navbar navbar-expand-lg bg-secondary navbar-dark py-3 py-lg-0 pl-3 pl-lg-5">
            <a href="{{ route('accueil') }}" class="navbar-brand">
                <h1 class="text-uppercase text-primary mb-1">SYNEM</h1>
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between px-3" id="navbarCollapse">
                <div class="navbar-nav ml-auto py-0">
                    <a href="{{ route('accueil') }}" class="nav-item nav-link {{ request()->routeIs('accueil') ? 'active' : '' }}">Accueil</a>
                    <a href="{{ route('a-propos') }}" class="nav-item nav-link {{ request()->routeIs('a-propos') ? 'active' : '' }}">À Propos</a>
                    <a href="{{ route('mission') }}" class="nav-item nav-link {{ request()->routeIs('mission') ? 'active' : '' }}">Notre Mission</a>
                    <a href="{{ route('historique') }}" class="nav-item nav-link {{ request()->routeIs('historique') ? 'active' : '' }}">Historique</a>
                    
                    <!-- Dropdown Publications (à activer plus tard) -->
                    {{-- <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Publications</a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="#" class="dropdown-item">Actualités</a>
                            <a href="#" class="dropdown-item">Documents</a>
                            <a href="#" class="dropdown-item">Rapports</a>
                        </div>
                    </div> --}}
                    
                    <!-- Dropdown Membres (à activer plus tard) -->
                    {{-- <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Membres</a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="#" class="dropdown-item">Bureau Syndical</a>
                            <a href="#" class="dropdown-item">Adhérer</a>
                        </div>
                    </div> --}}
                    
                    {{-- <a href="{{ route('evenements') }}" class="nav-item nav-link {{ request()->routeIs('evenements') ? 'active' : '' }}">Événements</a> --}}
                    <a href="{{ route('contact') }}" class="nav-item nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
                    
                    <!-- Authentification -->
                    <div class="nav-item dropdown">
                        @auth
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-user mr-1"></i>{{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu rounded-0 m-0">
                                <a href="{{ route('administration.tableau-de-bord') }}" class="dropdown-item">Administration</a>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Déconnexion</button>
                                </form>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="nav-link">Connexion</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </div>
</div>
<!-- Navbar End -->