@extends('layouts.site')

@section('title', 'Notre Mission - SYNEM')

@section('content')

{{-- Page Hero Carousel --}}
<section class="page-hero page-hero-carousel">

    {{-- Carousel images --}}
    <div id="missionHeroCarousel" class="carousel slide" data-ride="carousel" data-interval="5500">
        <div class="carousel-inner">
            @foreach($carouselImages as $index => $image)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <div class="page-hero-bg" style="background-image: url('{{ $image }}');"></div>
                </div>
            @endforeach
        </div>
        {{-- Indicateurs --}}
        <ol class="carousel-indicators">
            @foreach($carouselImages as $index => $image)
                <li data-target="#missionHeroCarousel" data-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"></li>
            @endforeach
        </ol>
    </div>

    <div class="page-hero-overlay"></div>

    <div class="page-hero-content">
        <span class="page-label">Notre Engagement</span>
        <h1>Notre Mission</h1>
        <div class="hero-divider"></div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="{{ route('accueil') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Notre Mission</li>
            </ol>
        </nav>
    </div>

    <div class="page-hero-scroll"><i class="fa fa-chevron-down"></i></div>
</section>
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
                <p class="text-muted mb-4" style="font-size:15px; line-height:1.8;">
                    {{ $missionMain }}
                </p>
                <a href="{{ route('contact') }}" class="btn btn-primary px-4">
                    Nous rejoindre <i class="fa fa-arrow-right ml-2"></i>
                </a>
            </div>
            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="150">
                <img src="{{ $missionImage }}" alt="Mission SYNEM" class="img-fluid w-100" style="border-radius:4px; box-shadow:0 12px 40px rgba(0,0,0,0.18);">
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
            @foreach($values as $idx => $v)
                <div class="col-6 col-lg-3" data-aos="zoom-in" data-aos-delay="{{ $idx * 150 }}">
                    <div class="stat-card">
                        <div class="stat-icon-wrap">
                            <i class="{{ $v['icon'] }}"></i>
                        </div>
                        <div class="stat-label mt-3" style="font-size:14px; letter-spacing:2px;">{{ $v['title'] }}</div>
                        @if(!empty($v['text']))<p class="small mt-2 mb-0" style="color:rgba(255,255,255,.75)">{{ $v['text'] }}</p>@endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@if($missionDocuments->isNotEmpty())
<section style="padding:80px 0;background:var(--light)">
    <div class="container">
        <div class="text-center mb-5"><p class="section-subtitle">Ressources</p><h2 class="section-title">Documents de mission</h2><div class="section-divider center"></div></div>
        <div class="row justify-content-center">
            @foreach($missionDocuments as $document)
                <div class="col-lg-4 col-md-6 mb-3">
                    <a href="{{ asset('storage/mission_documents/' . $document->file) }}" class="document-card d-block p-4 h-100" target="_blank" rel="noopener">
                        <i class="fas fa-file-alt fa-2x text-danger mb-3"></i>
                        <h6>{{ $document->title ?: $document->file }}</h6>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- CTA --}}
<section style="padding:80px 0; background:#fff;">
    <div class="container">
        <div class="row justify-content-center text-center" data-aos="zoom-in">
            <div class="col-lg-7">
                <p class="section-subtitle">Rejoignez-nous</p>
                <h2 class="section-title mb-3">{{ $cta['title'] }}</h2>
                <div class="section-divider center mb-4"></div>
                <p class="text-muted mb-5" style="font-size:15px;">{{ $cta['subtitle'] }}</p>
                <div class="d-flex justify-content-center flex-wrap" style="gap:16px;">
                    <a href="{{ $cta['link'] }}" class="btn btn-primary px-5">
                        <i class="fa fa-user-plus mr-2"></i>{{ $cta['button_text'] }}
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
