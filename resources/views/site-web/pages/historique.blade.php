@extends('layouts.site')

@section('title', 'Historique - SYNEM')

@section('content')

{{-- Page Hero --}}
<section class="page-hero">
    <div class="page-hero-bg" style="background-image: url('{{ asset('template-siteweb/asset/img/avenir_mali.png') }}');"></div>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content">
        <span class="page-label">Depuis 1990</span>
        <h1>Notre Historique</h1>
        <div class="hero-divider"></div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="{{ route('accueil') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Historique</li>
            </ol>
        </nav>
    </div>
    <div class="page-hero-scroll"><i class="fa fa-chevron-down"></i></div>
</section>
<div class="page-header-accent"></div>

{{-- Intro --}}
<section style="padding:90px 0; background:#fff;">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-7 text-center" data-aos="fade-up">
                <p class="section-subtitle">Notre Parcours</p>
                <h2 class="section-title mb-3">34 Ans de Combat pour l'Éducation</h2>
                <div class="section-divider center mb-4"></div>
                <p class="text-muted" style="font-size:15px; line-height:1.8;">
                    @php $histText = isset($historique) ? ($historique->main_text ?? $historique->description ?? '') : ''; @endphp
                    {{ $histText ?: "Depuis sa création en 1990, le SYNEM a traversé des moments forts et a su s'adapter aux évolutions du secteur éducatif malien. Découvrez l'histoire de notre organisation à travers ses grandes étapes." }}
                </p>
            </div>
        </div>

        {{-- Timeline --}}
        <div class="timeline" data-aos="fade-up">
            @php
                $timelineItems = [];
                if (!empty($events ?? null) && count($events)) $timelineItems = $events;
                elseif (!empty($historique->events ?? null)) $timelineItems = $historique->events;
                $defaultEvents = [
                    ['year'=>'1990','title'=>'Fondation du SYNEM','description'=>"Création officielle du Syndicat National des Enseignants du Mali par un groupe d'enseignants visionnaires. Le SYNEM commence avec 500 membres fondateurs à Bamako."],
                    ['year'=>'1992','title'=>'Reconnaissance Officielle','description'=>"Le SYNEM obtient sa reconnaissance officielle du gouvernement malien et s'impose comme représentant des enseignants."],
                    ['year'=>'1995','title'=>'Premier Congrès National','description'=>"Organisation du premier congrès national à Bamako. Adoption des statuts définitifs et élection du premier bureau exécutif."],
                    ['year'=>'2000','title'=>'Programme National de Formation','description'=>"Lancement du premier programme national de formation continue pour les enseignants en partenariat avec le Ministère de l'Éducation."],
                    ['year'=>'2005','title'=>'Expansion Régionale','description'=>"Création de sections régionales dans toutes les régions du Mali. Le SYNEM devient véritablement un syndicat national."],
                    ['year'=>'2010','title'=>'Accord Historique','description'=>"Signature d'un accord historique avec le gouvernement pour l'amélioration des salaires et des conditions de travail des enseignants."],
                    ['year'=>'2015','title'=>"25 Ans d'Engagement",'description'=>"Célébration du 25ème anniversaire avec plus de 10 000 membres. Lancement d'un programme de soutien aux enseignants en zones rurales."],
                    ['year'=>'2020','title'=>'Transformation Numérique','description'=>"Lancement de la plateforme numérique du SYNEM pour améliorer la communication et les services aux membres."],
                    ['year'=>'2024','title'=>'SYNEM Aujourd\'hui','description'=>"Le SYNEM continue de croître et de défendre les droits des enseignants maliens avec plus de 5 000 membres actifs à travers tout le pays."],
                ];
            @endphp
            @php $items = count($timelineItems) ? $timelineItems : $defaultEvents; @endphp
            @foreach($items as $idx => $item)
                @php
                    $year  = $item['year']  ?? ($item->year  ?? '');
                    $title = $item['title'] ?? ($item->title ?? ($item->event_title ?? ''));
                    $desc  = $item['description'] ?? ($item->description ?? ($item->text ?? ($item->event_text ?? '')));
                @endphp
                <div class="timeline-item" data-aos="fade-up" data-aos-delay="{{ min($idx * 60, 400) }}">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">{{ $year }}</div>
                    <div class="timeline-title">{{ $title }}</div>
                    <div class="timeline-body">{{ $desc }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Archives --}}
@if(!empty($archives ?? null) && count($archives))
<section style="padding:80px 0; background:var(--light);">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <p class="section-subtitle">Documentation</p>
            <h2 class="section-title">Archives</h2>
            <div class="section-divider center"></div>
        </div>
        <div class="row">
            @foreach($archives as $idx => $archive)
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ ($idx % 3) * 100 }}">
                    <div class="document-card">
                        <div class="doc-header">
                            <span class="doc-badge">ARCHIVE</span>
                        </div>
                        <div class="doc-body">
                            <div class="d-flex align-items-center">
                                <div class="doc-icon-wrap doc-icon-pdf">
                                    <i class="fas fa-file-pdf text-danger fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="doc-title">{{ $archive->title ?? $archive['title'] ?? '' }}</h6>
                                    <span class="doc-meta">{{ $archive->year ?? $archive['year'] ?? '' }}</span>
                                </div>
                            </div>
                        </div>
                        @if(!empty($archive->file ?? $archive['file'] ?? null))
                        <div class="doc-footer">
                            <a href="{{ asset('storage/archives/' . ($archive->file ?? $archive['file'])) }}" class="btn-download" download>
                                <i class="fas fa-download"></i> Télécharger
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Stats banner --}}
<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-6 col-lg-3" data-aos="zoom-in" data-aos-delay="0">
                <div class="stat-card">
                    <div class="stat-icon-wrap"><i class="fa fa-calendar-alt"></i></div>
                    <div class="stat-number"><span class="counter-number" data-target="34">0</span><span class="plus">+</span></div>
                    <div class="stat-label">Années d'Histoire</div>
                </div>
            </div>
            <div class="col-6 col-lg-3" data-aos="zoom-in" data-aos-delay="150">
                <div class="stat-card">
                    <div class="stat-icon-wrap"><i class="fa fa-handshake"></i></div>
                    <div class="stat-number"><span class="counter-number" data-target="15">0</span><span class="plus">+</span></div>
                    <div class="stat-label">Accords Signés</div>
                </div>
            </div>
            <div class="col-6 col-lg-3" data-aos="zoom-in" data-aos-delay="300">
                <div class="stat-card">
                    <div class="stat-icon-wrap"><i class="fa fa-trophy"></i></div>
                    <div class="stat-number"><span class="counter-number" data-target="9">0</span></div>
                    <div class="stat-label">Congrès Nationaux</div>
                </div>
            </div>
            <div class="col-6 col-lg-3" data-aos="zoom-in" data-aos-delay="450">
                <div class="stat-card">
                    <div class="stat-icon-wrap"><i class="fa fa-users"></i></div>
                    <div class="stat-number"><span class="counter-number" data-target="5000">0</span><span class="plus">+</span></div>
                    <div class="stat-label">Membres Actuels</div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
