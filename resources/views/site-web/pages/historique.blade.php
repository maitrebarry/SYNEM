@extends('layouts.site')

@section('title', 'Historique - SYNEM')

@section('content')

@include('site-web.partials.page-hero-carousel', [
    'heroId' => 'historyHeroCarousel',
    'heroSlides' => $heroSlides,
    'fallbackImages' => [asset('template-siteweb/asset/img/avenir_mali.png')],
    'heroLabel' => 'Depuis 1990',
    'heroTitle' => 'Notre Historique',
    'heroBreadcrumb' => 'Historique',
])

{{-- Intro --}}
<section style="padding:90px 0; background:#fff;">
    <div class="container">
        <div class="row justify-content-center align-items-center mb-5">
            <div class="{{ !empty($main?->image) ? 'col-lg-7' : 'col-lg-9 text-center' }}" data-aos="fade-up">
                <p class="section-subtitle">Notre Parcours</p>
                <h2 class="section-title mb-3">34 Ans de Combat pour l'Éducation</h2>
                <div class="section-divider center mb-4"></div>
                <p class="text-muted" style="font-size:15px; line-height:1.8;">
                    @php $histText = $main->text ?? ''; @endphp
                    {{ $histText ?: "Depuis sa création en 1990, le SYNEM a traversé des moments forts et a su s'adapter aux évolutions du secteur éducatif malien. Découvrez l'histoire de notre organisation à travers ses grandes étapes." }}
                </p>
            </div>
            @if(!empty($main?->image))
                <div class="col-lg-5" data-aos="fade-left">
                    <img src="{{ $main->image_url }}" alt="Historique du SYNEM" class="img-fluid w-100" style="border-radius:4px;box-shadow:0 12px 40px rgba(0,0,0,.18)">
                </div>
            @endif
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
                            @if(!empty($archive['image']))<img src="{{ $archive['image'] }}" alt="" class="w-100" style="height:170px;object-fit:cover">@else<span class="doc-badge">ARCHIVE</span>@endif
                        </div>
                        <div class="doc-body">
                            <div class="d-flex align-items-center">
                                <div class="doc-icon-wrap doc-icon-pdf">
                                    <i class="fas fa-file-pdf text-danger fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="doc-title">{{ $archive['title'] ?? '' }}</h6>
                                    <span class="doc-meta">{{ $archive['text'] ?? '' }}</span>
                                </div>
                            </div>
                        </div>
                        @if(!empty($archive['link']))
                        <div class="doc-footer">
                            <a href="{{ $archive['link'] }}" class="btn-download" target="_blank" rel="noopener">
                                <i class="fas fa-external-link-alt"></i> Consulter
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

{{-- Réalisations administrées --}}
<section class="stats-section">
    <div class="container">
        <div class="row">
            @php
                $historyStats = !empty($milestones) ? $milestones : [
                    ['number' => '34', 'label' => "Années d'Histoire", 'icon' => 'fa fa-calendar-alt', 'description' => ''],
                    ['number' => '15', 'label' => 'Accords Signés', 'icon' => 'fa fa-handshake', 'description' => ''],
                    ['number' => '9', 'label' => 'Congrès Nationaux', 'icon' => 'fa fa-trophy', 'description' => ''],
                    ['number' => '5000', 'label' => 'Membres Actuels', 'icon' => 'fa fa-users', 'description' => ''],
                ];
            @endphp
            @foreach($historyStats as $index => $stat)
                <div class="col-6 col-lg-3" data-aos="zoom-in" data-aos-delay="{{ ($index % 4) * 150 }}">
                    <div class="stat-card">
                        <div class="stat-icon-wrap"><i class="{{ $stat['icon'] ?: 'fa fa-star' }}"></i></div>
                        <div class="stat-number"><span class="counter-number" data-target="{{ (int) filter_var($stat['number'], FILTER_SANITIZE_NUMBER_INT) }}">0</span><span class="plus">+</span></div>
                        <div class="stat-label">{{ $stat['label'] }}</div>
                        @if(!empty($stat['description']))<p class="small mt-2">{{ $stat['description'] }}</p>@endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
