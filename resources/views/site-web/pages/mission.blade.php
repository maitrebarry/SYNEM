@extends('layouts.site')

@section('title', 'Notre Mission - SYNEM')

@section('styles')
<style>
    .mission-card {
        transition: transform 0.3s ease;
        border: none;
        border-radius: 15px;
        overflow: hidden;
        margin-bottom: 30px;
    }
    
    .mission-card:hover {
        transform: translateY(-10px);
    }
    
    .mission-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #007bff, #0056b3);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }
    
    .mission-icon i {
        font-size: 2rem;
        color: white;
    }
    
    .value-item {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        margin-bottom: 30px;
        text-align: center;
        transition: transform 0.3s ease;
    }
    
    .value-item:hover {
        transform: translateY(-5px);
    }
    
    .value-icon {
        font-size: 3rem;
        color: #007bff;
        margin-bottom: 20px;
    }
</style>
@endsection

@section('content')
<!-- Page Header Start -->
@php
    // Use dynamic carousel images/captions when provided by controller, fallback to static ones
    $carouselImages = $carouselImages ?? [
        asset('template-siteweb/asset/img/bg.jpg'),
        asset('template-siteweb/asset/img/gallery-2.jpg'),
        asset('template-siteweb/asset/img/gallery-3.jpg')
    ];
    $carouselCaptions = $carouselCaptions ?? [
        'Défendre les droits des enseignants maliens',
        'Promouvoir une éducation de qualité pour tous',
        'Œuvrer pour le développement professionnel'
    ];
@endphp

@include('site-web.partials.page-carousel', [
    'pageTitle' => 'Notre Mission',
    'breadcrumb' => 'Mission',
    'images' => $carouselImages,
    'captions' => $carouselCaptions,
])
<!-- Page Header End -->

<div class="container py-5">
    <div class="row align-items-center g-5">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <img src="{{ $missionImage ?? asset('template-siteweb/asset/img/mission-demo.jpg') }}" alt="Mission SYNEM" class="img-fluid rounded shadow">
        </div>
        <div class="col-lg-6">
            <h1 class="mb-3 text-primary">Notre Mission</h1>
            <p class="lead mb-4">{{ $missionMain ?? 'La mission du SYNEM est de défendre les intérêts moraux et matériels des enseignants, d’améliorer leurs conditions de travail, et de promouvoir le respect et la reconnaissance du métier. Le syndicat agit pour une école inclusive, équitable et performante au Mali.' }}</p>
            <ul class="list-unstyled mb-4">
                @if(!empty($missions) && is_array($missions))
                    @foreach($missions as $m)
                        <li class="mb-2"><i class="fa fa-check-circle text-primary me-2"></i>{{ $m['title'] ?? '' }}</li>
                    @endforeach
                @else
                    <li class="mb-2"><i class="fa fa-check-circle text-primary me-2"></i>Défense des droits et intérêts</li>
                    <li class="mb-2"><i class="fa fa-check-circle text-primary me-2"></i>Amélioration des conditions de travail</li>
                    <li class="mb-2"><i class="fa fa-check-circle text-primary me-2"></i>Respect et valorisation du métier</li>
                    <li class="mb-2"><i class="fa fa-check-circle text-primary me-2"></i>Éducation inclusive et performante</li>
                @endif
            </ul>
        </div>
    </div>
</div>
    </div>
</div>
<!-- Mission End -->

<!-- Missions Grid Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="section-title text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px;">
            <h1 class="mb-0">Nos Missions Principales</h1>
        </div>
        <div class="row g-5">
            @if(!empty($missions) && is_array($missions))
                @foreach($missions as $m)
                    <div class="col-lg-4 col-md-6">
                        <div class="mission-card bg-light text-center p-5">
                            <div class="mission-icon"><i class="{{ $m['icon'] ?? 'fa fa-circle' }}"></i></div>
                            <h4 class="text-uppercase mb-3">{{ $m['title'] ?? '' }}</h4>
                            <p>{{ $m['text'] ?? '' }}</p>
                        </div>
                    </div>
                @endforeach
            @else
                <!-- fallback static items -->
                <div class="col-lg-4 col-md-6">
                    <div class="mission-card bg-light text-center p-5">
                        <div class="mission-icon">
                            <i class="fa fa-balance-scale"></i>
                        </div>
                        <h4 class="text-uppercase mb-3">Défense des Droits</h4>
                        <p>Protéger les droits professionnels, sociaux et économiques des enseignants à tous les niveaux.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="mission-card bg-light text-center p-5">
                        <div class="mission-icon">
                            <i class="fa fa-graduation-cap"></i>
                        </div>
                        <h4 class="text-uppercase mb-3">Formation Continue</h4>
                        <p>Organiser des programmes de formation pour le développement professionnel des enseignants.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="mission-card bg-light text-center p-5">
                        <div class="mission-icon">
                            <i class="fa fa-handshake"></i>
                        </div>
                        <h4 class="text-uppercase mb-3">Dialogue Social</h4>
                        <p>Faciliter le dialogue entre les enseignants, l'administration et les autorités éducatives.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="mission-card bg-light text-center p-5">
                        <div class="mission-icon">
                            <i class="fa fa-chart-line"></i>
                        </div>
                        <h4 class="text-uppercase mb-3">Promotion de l'Éducation</h4>
                        <p>Contribuer à l'amélioration de la qualité de l'éducation au Mali.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="mission-card bg-light text-center p-5">
                        <div class="mission-icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <h4 class="text-uppercase mb-3">Représentation</h4>
                        <p>Représenter les enseignants dans toutes les instances décisionnelles.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="mission-card bg-light text-center p-5">
                        <div class="mission-icon">
                            <i class="fa fa-shield-alt"></i>
                        </div>
                        <h4 class="text-uppercase mb-3">Protection Sociale</h4>
                        <p>Assurer la protection sociale et la sécurité des enseignants.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
<!-- Missions Grid End -->

<!-- Values Start -->
<div class="container-fluid py-5 bg-light">
    <div class="container py-5">
        <div class="section-title text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px;">
            <h1 class="mb-0">Nos Valeurs</h1>
        </div>
        <div class="row g-5">
            <!-- Valeur 1 -->
            <div class="col-lg-3 col-md-6">
                <div class="value-item">
                    <div class="value-icon">
                        <i class="fa fa-star"></i>
                    </div>
                    <h4>Excellence</h4>
                    <p>Nous visons l'excellence dans tous nos services et actions.</p>
                </div>
            </div>
            <!-- Valeur 2 -->
            <div class="col-lg-3 col-md-6">
                <div class="value-item">
                    <div class="value-icon">
                        <i class="fa fa-hand-holding-heart"></i>
                    </div>
                    <h4>Solidarité</h4>
                    <p>La solidarité entre enseignants est au cœur de notre action.</p>
                </div>
            </div>
            <!-- Valeur 3 -->
            <div class="col-lg-3 col-md-6">
                <div class="value-item">
                    <div class="value-icon">
                        <i class="fa fa-scale-balanced"></i>
                    </div>
                    <h4>Équité</h4>
                    <p>Nous promouvons l'équité et la justice pour tous les enseignants.</p>
                </div>
            </div>
            <!-- Valeur 4 -->
            <div class="col-lg-3 col-md-6">
                <div class="value-item">
                    <div class="value-icon">
                        <i class="fa fa-eye"></i>
                    </div>
                    <h4>Transparence</h4>
                    <p>Nous agissons avec transparence dans toutes nos décisions.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Values End -->

<!-- Call to Action Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="bg-primary rounded py-5 px-4">
            <div class="row g-5 align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 text-white mb-3">Rejoignez Notre Mission</h1>
                    <p class="text-white mb-4">Ensemble, construisons un avenir meilleur pour l'éducation au Mali.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a class="btn btn-dark py-3 px-5" href="{{ route('contact') }}">Nous Rejoindre</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Call to Action End -->
@endsection