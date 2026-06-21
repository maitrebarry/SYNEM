@extends('layouts.site')

@section('title', 'À Propos - SYNEM')

@section('content')

{{-- Page Hero --}}
<section class="page-hero">
    <div class="page-hero-bg" style="background-image: url('https://i.pinimg.com/1200x/85/ca/7f/85ca7fafb53692c6bcd190a2f04eaa89.jpg');"></div>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content">
        <span class="page-label">Syndicat National des Enseignants du Mali</span>
        <h1>À Propos du SYNEM</h1>
        <div class="hero-divider"></div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="{{ route('accueil') }}">Accueil</a></li>
                <li class="breadcrumb-item active">À Propos</li>
            </ol>
        </nav>
    </div>
    <div class="page-hero-scroll"><i class="fa fa-chevron-down"></i></div>
</section>
<div class="page-header-accent"></div>

{{-- ── PRÉSENTATION ─────────────────────────────────────── --}}
<section class="about-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
                <p class="about-label">Qui sommes-nous</p>
                <h2 class="section-title mb-3">
                    Le <span style="color:var(--primary);">SYNEM</span>, votre syndicat
                </h2>
                <div class="section-divider"></div>
                <p class="text-muted mb-4" style="font-size:15px; line-height:1.8;">
                    {{ $about && $about->about_text ? $about->about_text : "Le Syndicat National des Enseignants du Mali (SYNEM) est une organisation professionnelle fondée en 1990, engagée dans la défense des droits, la valorisation du métier d'enseignant et la promotion d'une éducation de qualité pour tous. Le SYNEM rassemble des milliers de membres à travers le pays et œuvre pour le dialogue social et la formation continue." }}
                </p>
                <ul class="list-unstyled mb-4">
                    <li class="mb-3 d-flex align-items-start">
                        <i class="fa fa-check-circle text-danger mt-1 mr-3" style="font-size:18px;"></i>
                        <span>Défense des intérêts moraux et matériels des enseignants</span>
                    </li>
                    <li class="mb-3 d-flex align-items-start">
                        <i class="fa fa-check-circle text-danger mt-1 mr-3" style="font-size:18px;"></i>
                        <span>Dialogue social et négociation avec les autorités</span>
                    </li>
                    <li class="mb-3 d-flex align-items-start">
                        <i class="fa fa-check-circle text-danger mt-1 mr-3" style="font-size:18px;"></i>
                        <span>Formation continue et développement professionnel</span>
                    </li>
                    <li class="mb-3 d-flex align-items-start">
                        <i class="fa fa-check-circle text-danger mt-1 mr-3" style="font-size:18px;"></i>
                        <span>Promotion d'une éducation inclusive et équitable</span>
                    </li>
                </ul>
                <a href="{{ route('mission') }}" class="btn btn-primary px-4">
                    Notre Mission <i class="fa fa-arrow-right ml-2"></i>
                </a>
            </div>
            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="150">
                <div class="about-img-wrapper">
                    @php $aboutImg = $about && $about->image ? asset('storage/about/' . $about->image) : asset('template-siteweb/asset/img/ens10.jpeg'); @endphp
                    <img src="{{ $aboutImg }}" alt="SYNEM équipe" class="img-fluid w-100">
                    <div style="position:absolute; bottom:24px; left:-20px; background:var(--primary); color:#fff; padding:16px 24px; border-radius:4px; box-shadow:0 8px 25px rgba(200,16,46,0.4);">
                        <div style="font-family:'Montserrat',sans-serif; font-weight:900; font-size:2rem; line-height:1;">1990</div>
                        <div style="font-family:'Montserrat',sans-serif; font-size:11px; font-weight:600; letter-spacing:1px; text-transform:uppercase; opacity:.85;">Année de fondation</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── STATISTIQUES ─────────────────────────────────────── --}}
<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-6 col-lg-3" data-aos="zoom-in" data-aos-delay="0">
                <div class="stat-card">
                    <div class="stat-icon-wrap"><i class="fa fa-users"></i></div>
                    <div class="stat-number">
                        <span class="counter-number" data-target="{{ $about && $about->stats_members ? (int)filter_var($about->stats_members, FILTER_SANITIZE_NUMBER_INT) : 5000 }}">0</span><span class="plus">+</span>
                    </div>
                    <div class="stat-label">Membres Actifs</div>
                </div>
            </div>
            <div class="col-6 col-lg-3" data-aos="zoom-in" data-aos-delay="150">
                <div class="stat-card">
                    <div class="stat-icon-wrap"><i class="fa fa-history"></i></div>
                    <div class="stat-number">
                        <span class="counter-number" data-target="{{ $about && $about->stats_years ? (int)$about->stats_years : 34 }}">0</span><span class="plus">+</span>
                    </div>
                    <div class="stat-label">Années d'Expérience</div>
                </div>
            </div>
            <div class="col-6 col-lg-3" data-aos="zoom-in" data-aos-delay="300">
                <div class="stat-card">
                    <div class="stat-icon-wrap"><i class="fa fa-map-marker-alt"></i></div>
                    <div class="stat-number">
                        <span class="counter-number" data-target="{{ $about && $about->stats_regions ? (int)$about->stats_regions : 8 }}">0</span>
                    </div>
                    <div class="stat-label">Régions Couvertes</div>
                </div>
            </div>
            <div class="col-6 col-lg-3" data-aos="zoom-in" data-aos-delay="450">
                <div class="stat-card">
                    <div class="stat-icon-wrap"><i class="fa fa-eye"></i></div>
                    <div class="stat-number">
                        <span class="counter-number" data-target="{{ $visitorCount ?? 1200 }}">0</span><span class="plus">+</span>
                    </div>
                    <div class="stat-label">Visiteurs du Site</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── TIMELINE / HISTOIRE ──────────────────────────────── --}}
<section style="padding:90px 0; background:#fff;">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <p class="section-subtitle">Depuis 1990</p>
            <h2 class="section-title">Notre Histoire en Dates</h2>
            <div class="section-divider center"></div>
        </div>

        <div class="timeline" data-aos="fade-up" data-aos-delay="100">
            @if($about && is_array($about->timeline) && count($about->timeline))
                @foreach($about->timeline as $event)
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-date">{{ $event['year'] ?? '' }}</div>
                        <div class="timeline-title">{{ $event['title'] ?? '' }}</div>
                        <div class="timeline-body">{{ $event['text'] ?? '' }}</div>
                    </div>
                @endforeach
            @else
                @php
                    $events = [
                        ['year'=>'1990','title'=>'Création du SYNEM','text'=>'Fondation officielle du Syndicat National des Enseignants du Mali avec 500 membres fondateurs.'],
                        ['year'=>'1995','title'=>'Premier Congrès National','text'=>'Organisation du premier congrès national et adoption des statuts définitifs.'],
                        ['year'=>'2000','title'=>'Programme de Formation','text'=>'Lancement du premier programme national de formation continue pour les enseignants.'],
                        ['year'=>'2010','title'=>'Accord Historique','text'=>"Signature d'un accord historique avec le gouvernement pour l'amélioration des conditions enseignantes."],
                        ['year'=>'2020','title'=>'Digitalisation','text'=>"Lancement de la plateforme numérique pour une meilleure communication avec les membres."],
                    ];
                @endphp
                @foreach($events as $event)
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-date">{{ $event['year'] }}</div>
                        <div class="timeline-title">{{ $event['title'] }}</div>
                        <div class="timeline-body">{{ $event['text'] }}</div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>

{{-- ── BUREAU EXÉCUTIF ──────────────────────────────────── --}}
<section style="padding:90px 0; background:var(--light);">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <p class="section-subtitle">Leadership</p>
            <h2 class="section-title">Notre Bureau Exécutif</h2>
            <div class="section-divider center"></div>
        </div>
        <div class="row justify-content-center">
            @if($about && is_array($about->team) && count($about->team))
                @foreach($about->team as $idx => $member)
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ ($idx % 3) * 100 }}">
                        <div class="team-card">
                            <div class="team-img-wrap">
                                @if(!empty($member['photo']))
                                    <img src="{{ asset('storage/team/' . $member['photo']) }}" alt="{{ $member['name'] ?? '' }}">
                                @else
                                    <img src="{{ asset('template-siteweb/asset/img/team-1.jpg') }}" alt="{{ $member['name'] ?? '' }}">
                                @endif
                                <div class="team-social-overlay">
                                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                            <div class="team-body">
                                <h5 class="team-name">{{ $member['name'] ?? '' }}</h5>
                                <p class="team-role">{{ $member['role'] ?? '' }}</p>
                            </div>
                            <div class="team-bottom text-center">
                                <small style="color:rgba(255,255,255,0.5); font-size:11px; letter-spacing:1px; text-transform:uppercase; font-family:'Montserrat',sans-serif;">SYNEM — Bureau Exécutif</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                @php
                    $team = [
                        ['name'=>'Moussa Diallo','role'=>'Président National','img'=>'team-1.jpg'],
                        ['name'=>'Aminata Traoré','role'=>'Secrétaire Générale','img'=>'team-2.jpg'],
                        ['name'=>'Ibrahim Keita','role'=>'Trésorier National','img'=>'team-3.jpg'],
                    ];
                @endphp
                @foreach($team as $idx => $m)
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $idx * 100 }}">
                        <div class="team-card">
                            <div class="team-img-wrap">
                                <img src="{{ asset('template-siteweb/asset/img/' . $m['img']) }}" alt="{{ $m['name'] }}">
                                <div class="team-social-overlay">
                                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                            <div class="team-body">
                                <h5 class="team-name">{{ $m['name'] }}</h5>
                                <p class="team-role">{{ $m['role'] }}</p>
                            </div>
                            <div class="team-bottom text-center">
                                <small style="color:rgba(255,255,255,0.5); font-size:11px; letter-spacing:1px; text-transform:uppercase; font-family:'Montserrat',sans-serif;">SYNEM — Bureau Exécutif</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>

@endsection
