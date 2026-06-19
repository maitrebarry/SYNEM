@extends('layouts.site')

@section('title', 'Notre Mission - SYNEM')

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div class="page-header-bg" data-bg="{{ asset('template-siteweb/asset/img/ens2.jpg') }}"></div>
    <div class="page-header-content">
        <span class="page-label">Notre Engagement</span>
        <h1>Notre Mission</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="{{ route('accueil') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Notre Mission</li>
            </ol>
        </nav>
    </div>
</div>
<div class="page-header-accent"></div>

{{-- Mission Intro --}}
<section style="padding:90px 0; background:#fff;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
                <p class="section-subtitle">Pourquoi nous existons</p>
                <h2 class="section-title mb-3">
                    Ensemble pour une<br><span style="color:var(--primary);">Éducation de Qualité</span>
                </h2>
                <div class="section-divider"></div>
                @php
                    $missionText = '';
                    if (!empty($missionPage->main_text ?? null)) $missionText = $missionPage->main_text;
                    elseif (!empty($missionPage->description ?? null)) $missionText = $missionPage->description;
                @endphp
                <p class="text-muted mb-4" style="font-size:15px; line-height:1.8;">
                    {{ $missionText ?: "Le SYNEM s'est fixé pour mission de défendre les droits et intérêts des enseignants maliens, de promouvoir la qualité de l'éducation et de créer un environnement propice à l'épanouissement professionnel de chaque enseignant. Notre action repose sur le dialogue, la solidarité et l'engagement collectif." }}
                </p>
                <a href="{{ route('contact') }}" class="btn btn-primary px-4">
                    Nous rejoindre <i class="fa fa-arrow-right ml-2"></i>
                </a>
            </div>
            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="150">
                <img src="{{ asset('template-siteweb/asset/img/ens2.jpg') }}" alt="Mission SYNEM" class="img-fluid w-100" style="border-radius:4px; box-shadow:0 12px 40px rgba(0,0,0,0.18);">
            </div>
        </div>
    </div>
</section>

{{-- Mission Cards --}}
<section style="padding:90px 0; background:var(--light);">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <p class="section-subtitle">Nos Axes d'Action</p>
            <h2 class="section-title">Domaines de Mission</h2>
            <div class="section-divider center"></div>
        </div>
        <div class="row">
            @php
                $missionItems = [];
                if (!empty($missionItems_data ?? null) && is_array($missionItems_data)) $missionItems = $missionItems_data;
                $defaultMissions = [
                    ['icon'=>'fa-balance-scale','title'=>'Défense des Droits','text'=>"Protéger les droits professionnels et améliorer les conditions de travail et de vie des enseignants maliens."],
                    ['icon'=>'fa-graduation-cap','title'=>'Formation Continue','text'=>"Développer des programmes de formation pour améliorer les compétences pédagogiques des enseignants."],
                    ['icon'=>'fa-comments','title'=>'Dialogue Social','text'=>"Maintenir un dialogue constructif avec les autorités éducatives pour des politiques enseignantes favorables."],
                    ['icon'=>'fa-users','title'=>'Solidarité','text'=>"Renforcer la cohésion et la solidarité entre tous les enseignants maliens, quelle que soit leur région."],
                    ['icon'=>'fa-shield-alt','title'=>'Protection Sociale','text'=>"Veiller à la protection sociale des enseignants, y compris la retraite, la santé et les avantages sociaux."],
                    ['icon'=>'fa-book-open','title'=>'Qualité Éducative','text'=>"Promouvoir des standards élevés d'éducation pour offrir la meilleure chance à chaque élève malien."],
                ];
            @endphp
            @php $missions = count($missionItems) ? $missionItems : $defaultMissions; @endphp
            @foreach($missions as $idx => $m)
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ ($idx % 3) * 100 }}">
                    <div class="mission-card">
                        <div class="mission-icon">
                            <i class="fa {{ $m['icon'] ?? ($m->icon ?? 'fa-star') }}"></i>
                        </div>
                        <h5 class="mission-title">{{ $m['title'] ?? ($m->title ?? '') }}</h5>
                        <p class="mission-text">{{ $m['text'] ?? ($m->text ?? ($m->description ?? '')) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Valeurs --}}
<section class="stats-section">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <p class="section-subtitle" style="color:rgba(255,255,255,0.5);">Ce qui nous guide</p>
            <h2 class="section-title" style="color:#fff;">Nos Valeurs Fondamentales</h2>
            <div class="section-divider center"></div>
        </div>
        <div class="row">
            @php
                $values = [
                    ['icon'=>'fa-handshake','label'=>'Solidarité'],
                    ['icon'=>'fa-star','label'=>'Excellence'],
                    ['icon'=>'fa-balance-scale','label'=>'Justice'],
                    ['icon'=>'fa-lightbulb','label'=>'Innovation'],
                ];
            @endphp
            @foreach($values as $idx => $v)
                <div class="col-6 col-lg-3" data-aos="zoom-in" data-aos-delay="{{ $idx * 150 }}">
                    <div class="stat-card">
                        <div class="stat-icon-wrap">
                            <i class="fa {{ $v['icon'] }}"></i>
                        </div>
                        <div class="stat-label mt-3" style="font-size:14px; letter-spacing:2px;">{{ $v['label'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section style="padding:80px 0; background:#fff;">
    <div class="container">
        <div class="row justify-content-center text-center" data-aos="zoom-in">
            <div class="col-lg-7">
                <p class="section-subtitle">Rejoignez-nous</p>
                <h2 class="section-title mb-3">Ensemble, faisons la différence</h2>
                <div class="section-divider center mb-4"></div>
                <p class="text-muted mb-5" style="font-size:15px;">Rejoignez le SYNEM et participez activement à la défense des droits des enseignants et à l'amélioration de l'éducation au Mali.</p>
                <div class="d-flex justify-content-center flex-wrap" style="gap:16px;">
                    <a href="{{ route('contact') }}" class="btn btn-primary px-5">
                        <i class="fa fa-user-plus mr-2"></i>Devenir Membre
                    </a>
                    <a href="{{ route('a-propos') }}" class="btn btn-outline-primary px-5">
                        En savoir plus
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
