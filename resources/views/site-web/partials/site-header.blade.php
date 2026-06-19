<!-- Topbar -->
<div class="topbar d-none d-lg-block">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <a href="tel:{{ $sharedTopbar->phone ?? '+22392190993' }}">
                    <i class="fa fa-phone-alt mr-2"></i>{{ $sharedTopbar->phone ?? '+223 92190993' }}
                </a>
                <span class="separator">|</span>
                <a href="mailto:{{ $sharedTopbar->email ?? 'contact@synem.ml' }}">
                    <i class="fa fa-envelope mr-2"></i>{{ $sharedTopbar->email ?? 'contact@synem.ml' }}
                </a>
            </div>
            <div class="d-flex align-items-center">
                @if($sharedTopbar->facebook_url ?? null)
                    <a href="{{ $sharedTopbar->facebook_url }}" class="ml-3"><i class="fab fa-facebook-f"></i></a>
                @endif
                @if($sharedTopbar->twitter_url ?? null)
                    <a href="{{ $sharedTopbar->twitter_url }}" class="ml-3"><i class="fab fa-twitter"></i></a>
                @endif
                @if($sharedTopbar->linkedin_url ?? null)
                    <a href="{{ $sharedTopbar->linkedin_url }}" class="ml-3"><i class="fab fa-linkedin-in"></i></a>
                @endif
                @if($sharedTopbar->instagram_url ?? null)
                    <a href="{{ $sharedTopbar->instagram_url }}" class="ml-3"><i class="fab fa-instagram"></i></a>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Main Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="{{ route('accueil') }}">
            <span class="brand-sy">SY</span><span class="brand-ne">NE</span><span class="brand-m">M</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav ml-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('accueil') ? 'active' : '' }}" href="{{ route('accueil') }}">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('a-propos') ? 'active' : '' }}" href="{{ route('a-propos') }}">À Propos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('mission') ? 'active' : '' }}" href="{{ route('mission') }}">Notre Mission</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('historique') ? 'active' : '' }}" href="{{ route('historique') }}">Historique</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
                </li>

                @auth
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-user mr-1"></i>{{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu">
                            <a href="{{ route('administration.tableau-de-bord') }}" class="dropdown-item">
                                <i class="fa fa-tachometer-alt mr-2"></i>Administration
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fa fa-sign-out-alt mr-2"></i>Déconnexion
                                </button>
                            </form>
                        </div>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="#" class="nav-link btn-nav-cta" data-toggle="modal" data-target="#membershipModal">
                            <i class="fa fa-user-plus mr-1"></i>Rejoindre
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

@if(!request()->routeIs('accueil'))
    {{-- Spacer for fixed navbar on inner pages --}}
    <div style="height: 70px;"></div>
@endif
