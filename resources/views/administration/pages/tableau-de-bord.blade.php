@extends('layouts.administration')

@section('title', 'Tableau de bord')

@section('content')
<!-- Header avec statistiques principales -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('administration.tableau-de-bord') }}">Tableau de bord</a></li>
        <li class="breadcrumb-item active" aria-current="page">Acceuil</li>
    </ol>
</nav>

<!-- Cartes de statistiques -->
<div class="row mb-4">
    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3">
        <div class="card h-100 border-0 shadow-sm radius-10 bg-primary bg-gradient">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-white">Utilisateurs</p>
                        <h4 class="my-1 text-white">{{ number_format($stats['utilisateurs_total']) }}</h4>
                    </div>
                    <div class="text-white ms-auto font-35"><i class='bx bx-user-pin'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3">
        <div class="card h-100 border-0 shadow-sm radius-10 bg-danger bg-gradient">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-white">Publications</p>
                        <h4 class="my-1 text-white">{{ number_format($stats['publications_total']) }}</h4>
                    </div>
                    <div class="text-white ms-auto font-35"><i class='bx bx-news'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3">
        <div class="card h-100 border-0 shadow-sm radius-10 bg-warning">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-dark">Documents</p>
                        <h4 class="text-dark my-1">{{ number_format($stats['documents_total']) }}</h4>
                    </div>
                    <div class="text-dark ms-auto font-35"><i class='bx bx-file'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3">
        <div class="card h-100 border-0 shadow-sm radius-10 bg-success bg-gradient">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-white">Messages</p>
                        <h4 class="my-1 text-white">{{ number_format($stats['soumissions_contact']) }}</h4>
                    </div>
                    <div class="text-white ms-auto font-35"><i class='bx bx-envelope'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3">
        <div class="card h-100 border-0 shadow-sm radius-10 bg-info">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-dark">Images</p>
                        <h4 class="my-1 text-dark">{{ number_format($stats['images_carousel']) }}</h4>
                        <p class="mb-0 font-13 text-dark"><i class="bx bxs-up-arrow align-middle"></i>Images actives</p>
                    </div>
                    <div class="widgets-icons bg-white text-dark ms-auto"><i class="bx bx-images"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3">
        <div class="card h-100 border-0 shadow-sm radius-10 bg-success">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-white">Événements</p>
                        <h4 class="my-1 text-white">{{ number_format($stats['evenements_historique']) }}</h4>
                        <p class="mb-0 font-13 text-white"><i class="bx bxs-up-arrow align-middle"></i>Historiques</p>
                    </div>
                    <div class="widgets-icons bg-white text-success ms-auto"><i class="bx bx-calendar-event"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section principale -->
<div class="row">
    <!-- Activités récentes -->
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex align-items-center">
                    <i class="bx bx-activity fs-4 text-primary me-2"></i>
                    <h5 class="mb-0 fw-bold">Activités Récentes</h5>
                </div>
            </div>
            <div class="card-body">
                @if(count($activites_recentes) > 0)
                    <div class="timeline">
                        @foreach($activites_recentes as $index => $activite)
                            <div class="timeline-item {{ $index < count($activites_recentes) - 1 ? 'mb-4' : '' }}">
                                <div class="timeline-marker bg-{{ $activite['type_color'] }}"></div>
                                <div class="timeline-content">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="bg-{{ $activite['type_color'] }} bg-opacity-10 rounded-circle p-2">
                                                <i class="{{ $activite['icon'] ?? 'bx bx-bell' }} fs-5 text-{{ $activite['type_color'] }}"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="mb-1 fw-medium">{{ $activite['description'] }}</p>
                                            <div class="d-flex align-items-center text-muted small">
                                                <i class="bx bx-user me-1"></i>
                                                <span>{{ $activite['utilisateur'] }}</span>
                                                <span class="mx-2">•</span>
                                                <i class="bx bx-time me-1"></i>
                                                <span>{{ \Carbon\Carbon::parse($activite['date'])->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bx bx-bell-off fs-1 text-muted mb-3"></i>
                        <p class="text-muted">Aucune activité récente</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Publications récentes -->
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex align-items-center">
                    <i class="bx bx-news fs-4 text-success me-2"></i>
                    <h5 class="mb-0 fw-bold">Publications Récentes</h5>
                </div>
            </div>
            <div class="card-body">
                @if(count($publications_recentes) > 0)
                    <div class="publications-list">
                        @foreach($publications_recentes as $pub)
                            <div class="publication-item mb-3 pb-3 border-bottom border-light">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0 me-2">
                                        <span class="badge bg-{{ $pub['statut_color'] }} rounded-pill px-2 py-1 small">{{ $pub['statut'] }}</span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 fw-semibold text-truncate">{{ $pub['titre'] }}</h6>
                                        <p class="mb-1 text-muted small">{{ $pub['contenu'] }}</p>
                                        <div class="text-muted small">
                                            <i class="bx bx-calendar me-1"></i>{{ $pub['date'] }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bx bx-news fs-1 text-muted mb-3"></i>
                        <p class="text-muted">Aucune publication récente</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Actions rapides -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex align-items-center">
                    <i class="bx bx-rocket fs-4 text-warning me-2"></i>
                    <h5 class="mb-0 fw-bold">Actions Rapides</h5>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3 col-sm-6">
                        <a href="{{ route('administration.pages.accueil.edit') }}" class="text-decoration-none">
                            <div class="action-card text-center p-3 rounded-3 border hover-shadow">
                                <i class="bx bx-home fs-2 text-primary mb-2"></i>
                                <h6 class="mb-1">Page d'accueil</h6>
                                <small class="text-muted">Modifier le contenu</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <a href="{{ route('administration.pages.contact.edit') }}" class="text-decoration-none">
                            <div class="action-card text-center p-3 rounded-3 border hover-shadow">
                                <i class="bx bx-envelope fs-2 text-success mb-2"></i>
                                <h6 class="mb-1">Contact</h6>
                                <small class="text-muted">Gérer les messages</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <a href="{{ route('administration.parametres.index') }}" class="text-decoration-none">
                            <div class="action-card text-center p-3 rounded-3 border hover-shadow">
                                <i class="bx bx-cog fs-2 text-info mb-2"></i>
                                <h6 class="mb-1">Paramètres</h6>
                                <small class="text-muted">Configuration</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <a href="{{ route('administration.pages.a-propos.edit') }}" class="text-decoration-none">
                            <div class="action-card text-center p-3 rounded-3 border hover-shadow">
                                <i class="bx bx-info-circle fs-2 text-warning mb-2"></i>
                                <h6 class="mb-1">À propos</h6>
                                <small class="text-muted">Informations</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.radius-10 {
    border-radius: 10px !important;
}

.font-35 {
    font-size: 35px !important;
}

.widgets-icons {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    font-size: 25px;
}

.bg-gradient {
    background-image: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.1) 100%) !important;
}

.hover-lift {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.hover-shadow {
    transition: box-shadow 0.3s ease;
}

.hover-shadow:hover {
    box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;
}

.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 8px;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 0 0 2px currentColor;
}

.timeline-content {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 12px 16px;
}

.action-card {
    transition: all 0.3s ease;
    background: #fff;
}

.action-card:hover {
    background: #f8f9fa;
    transform: translateY(-2px);
}

.publications-list {
    max-height: 400px;
    overflow-y: auto;
}

.publication-item:last-child {
    border-bottom: none !important;
    margin-bottom: 0 !important;
    padding-bottom: 0 !important;
}
</style>
@endsection