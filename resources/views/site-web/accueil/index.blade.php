@extends('layouts.site')

@section('title', 'SYNEM - Syndicat National des Enseignants du Mali')

@section('styles')
<style>
/* Hero margin override for fixed nav */
body { padding-top: 0 !important; }
.topbar + #mainNav + .hero-section { margin-top: 0; }
</style>
@endsection

@section('content')

{{-- ╔══════════════════════════════════════════════════════╗ --}}
{{--   HERO CAROUSEL                                         --}}
{{-- ╚══════════════════════════════════════════════════════╝ --}}
<section class="hero-section">
    <div id="heroCarousel" class="carousel slide" data-ride="carousel" data-interval="5000">

        {{-- Slides --}}
        <div class="carousel-inner" style="height:100%;">
            @if($content && $content->carouselImages && count($content->carouselImages))
                @foreach($content->carouselImages as $key => $img)
                    @php
                        $imgTitle    = trim((string)($img->title ?? $img->caption ?? $img->label ?? ''));
                        $imgText     = trim((string)($img->text ?? $img->description ?? ''));
                        $globalTitle = trim((string)($content->carousel_title ?? ''));
                        $globalSub   = trim((string)($content->carousel_subtitle ?? ''));
                        $displayTitle = $imgTitle !== '' ? $imgTitle : ($globalTitle !== '' ? $globalTitle : 'Défense des Droits des Enseignants');
                        $displaySub   = $imgText  !== '' ? $imgText  : ($globalSub  !== '' ? $globalSub  : null);
                    @endphp
                    <div class="carousel-item {{ $key === 0 ? 'active' : '' }}" style="height:100%;">
                        <img src="{{ asset('storage/carousel/' . $img->file) }}" alt="Carrousel {{ $key+1 }}">
                        <div class="hero-overlay"></div>
                        <div class="hero-caption">
                            <span class="hero-badge">Syndicat National des Enseignants du Mali</span>
                            <h1>{{ $displayTitle }}</h1>
                            @if($displaySub)
                                <p>{{ $displaySub }}</p>
                            @endif
                            <div class="hero-btns">
                                <a href="{{ route('a-propos') }}" class="btn-hero-primary">Découvrir le SYNEM</a>
                                <a href="{{ route('contact') }}" class="btn-hero-outline">Nous Contacter</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="carousel-item active" style="height:100%;">
                    <img src="{{ asset('template-siteweb/asset/img/ens8.jpeg') }}" alt="SYNEM Éducation">
                    <div class="hero-overlay"></div>
                    <div class="hero-caption">
                        <span class="hero-badge">Syndicat National des Enseignants du Mali</span>
                        <h1>Défense des Droits des Enseignants</h1>
                        <p>Ensemble, nous construisons une éducation de qualité pour tous les enfants du Mali.</p>
                        <div class="hero-btns">
                            <a href="{{ route('a-propos') }}" class="btn-hero-primary">Découvrir le SYNEM</a>
                            <a href="{{ route('contact') }}" class="btn-hero-outline">Nous Contacter</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" style="height:100%;">
                    <img src="{{ asset('template-siteweb/asset/img/ens2.jpg') }}" alt="SYNEM Formation">
                    <div class="hero-overlay"></div>
                    <div class="hero-caption">
                        <span class="hero-badge">Formation Continue</span>
                        <h1>Développement Professionnel des Enseignants</h1>
                        <p>Des programmes de formation adaptés aux besoins des enseignants maliens.</p>
                        <div class="hero-btns">
                            <a href="{{ route('mission') }}" class="btn-hero-primary">Notre Mission</a>
                            <a href="{{ route('contact') }}" class="btn-hero-outline">Rejoindre</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" style="height:100%;">
                    <img src="{{ asset('template-siteweb/asset/img/solidarite_synem.png') }}" alt="SYNEM Solidarité">
                    <div class="hero-overlay"></div>
                    <div class="hero-caption">
                        <span class="hero-badge">Syndicat National des Enseignants du Mali</span>
                        <h1>Unis et Solidaires pour Nos Droits</h1>
                        <p>Ensemble, nous défendons les droits et les intérêts de tous les enseignants du Mali.</p>
                        <div class="hero-btns">
                            <a href="{{ route('a-propos') }}" class="btn-hero-primary">Découvrir le SYNEM</a>
                            <a href="{{ route('contact') }}" class="btn-hero-outline">Nous Rejoindre</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" style="height:100%;">
                    <img src="{{ asset('template-siteweb/asset/img/avenir_mali.png') }}" alt="SYNEM Avenir Mali">
                    <div class="hero-overlay"></div>
                    <div class="hero-caption">
                        <span class="hero-badge">Éducation · Mali</span>
                        <h1>Construisons l'Avenir de la Nation</h1>
                        <p>Pour une éducation de qualité accessible à tous les enfants du Mali.</p>
                        <div class="hero-btns">
                            <a href="{{ route('mission') }}" class="btn-hero-primary">Notre Mission</a>
                            <a href="{{ route('contact') }}" class="btn-hero-outline">Contact</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" style="height:100%;">
                    <img src="{{ asset('template-siteweb/asset/img/voix_enseignants.png') }}" alt="SYNEM Voix Enseignants">
                    <div class="hero-overlay"></div>
                    <div class="hero-caption">
                        <span class="hero-badge">Engagement · Syndicat</span>
                        <h1>SYNEM — La Voix des Enseignants</h1>
                        <p>Au service de l'éducation et du progrès pour toutes les régions du Mali.</p>
                        <div class="hero-btns">
                            <a href="{{ route('a-propos') }}" class="btn-hero-primary">En Savoir Plus</a>
                            <a href="{{ route('contact') }}" class="btn-hero-outline">Nous Contacter</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Controls --}}
        <a class="carousel-control-prev" href="#heroCarousel" data-slide="prev">
            <i class="fa fa-chevron-left"></i>
        </a>
        <a class="carousel-control-next" href="#heroCarousel" data-slide="next">
            <i class="fa fa-chevron-right"></i>
        </a>
        <ol class="carousel-indicators">
            @if($content && $content->carouselImages && count($content->carouselImages))
                @foreach($content->carouselImages as $key => $img)
                    <li data-target="#heroCarousel" data-slide-to="{{ $key }}" class="{{ $key === 0 ? 'active' : '' }}"></li>
                @endforeach
            @else
                <li data-target="#heroCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#heroCarousel" data-slide-to="1"></li>
                <li data-target="#heroCarousel" data-slide-to="2"></li>
                <li data-target="#heroCarousel" data-slide-to="3"></li>
                <li data-target="#heroCarousel" data-slide-to="4"></li>
            @endif
        </ol>
    </div>
</section>

{{-- ╔══════════════════════════════════════════════════════╗ --}}
{{--   ABOUT / BIENVENUE                                     --}}
{{-- ╚══════════════════════════════════════════════════════╝ --}}
<section class="about-section">
    <div class="container">
        <div class="row align-items-center">
            {{-- Texte --}}
            <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
                <p class="about-label">Qui sommes-nous</p>
                @php
                    $aboutTitle = trim((string)($content->about_title ?? ''));
                    $aboutText  = trim((string)($content->about_text  ?? ''));
                @endphp
                <h2 class="section-title mb-3">
                    {{ $aboutTitle !== '' ? $aboutTitle : 'Bienvenue au ' }}
                    <span style="color:var(--primary);">SYNEM</span>
                </h2>
                <div class="section-divider"></div>
                <p class="text-muted mb-4" style="font-size:15px; line-height:1.8;">
                    {{ $aboutText !== '' ? $aboutText : "Le Syndicat National des Enseignants du Mali (SYNEM) est l'organisation syndicale qui représente et défend les intérêts des enseignants maliens à tous les niveaux du système éducatif. Fort de plusieurs décennies d'engagement, le SYNEM œuvre pour l'amélioration des conditions de travail et de vie des enseignants, la défense de leurs droits professionnels et la promotion d'une éducation de qualité pour tous les enfants du Mali." }}
                </p>

                {{-- Mini-stats --}}
                <div class="row mt-4">
                    <div class="col-sm-4 mb-3">
                        <div class="about-mini-stat">
                            <span class="stat-number">5K+</span>
                            <span class="stat-label">Membres<br>Actifs</span>
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <div class="about-mini-stat">
                            <span class="stat-number">30+</span>
                            <span class="stat-label">Années<br>d'Existence</span>
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <div class="about-mini-stat">
                            <span class="stat-number">8</span>
                            <span class="stat-label">Régions<br>Couvertes</span>
                        </div>
                    </div>
                </div>

                <a href="{{ route('a-propos') }}" class="btn btn-primary mt-3 px-4">
                    En savoir plus <i class="fa fa-arrow-right ml-2"></i>
                </a>
            </div>

            {{-- Image --}}
            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="150">
                <div class="about-img-wrapper" style="position:relative;">
                    <img src="{{ asset('template-siteweb/asset/img/ens10.jpeg') }}" alt="SYNEM" class="img-fluid w-100" style="border-radius:4px; box-shadow:0 12px 40px rgba(0,0,0,0.18);">
                    {{-- Badge flottant --}}
                    <div style="position:absolute; bottom:24px; left:-20px; background:var(--primary); color:#fff; padding:16px 24px; border-radius:4px; box-shadow:0 8px 25px rgba(200,16,46,0.4);">
                        <div style="font-family:'Montserrat',sans-serif; font-weight:900; font-size:2rem; line-height:1;">30+</div>
                        <div style="font-family:'Montserrat',sans-serif; font-size:11px; font-weight:600; letter-spacing:1px; text-transform:uppercase; opacity:.85;">Années de combat</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ╔══════════════════════════════════════════════════════╗ --}}
{{--   DOMAINES D'INTERVENTION                              --}}
{{-- ╚══════════════════════════════════════════════════════╝ --}}
<section class="domains-section">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <p class="section-subtitle">Nos Engagements</p>
            @php
                $servicesItems = [];
                if (!empty($content->services_items)) {
                    $servicesItems = is_array($content->services_items)
                        ? $content->services_items
                        : (json_decode($content->services_items, true) ?: []);
                }
                $servicesTitle = trim((string)($content->services_title ?? ''));
            @endphp
            <h2 class="section-title">{{ $servicesTitle !== '' ? $servicesTitle : 'Domaines d\'Intervention' }}</h2>
            <div class="section-divider center"></div>
        </div>

        <div class="row">
            @if(count($servicesItems))
                @foreach($servicesItems as $idx => $s)
                    @php
                        $title       = $s['title'] ?? ($s['label'] ?? 'Service');
                        $description = $s['text'] ?? ($s['description'] ?? ($s['content'] ?? ''));
                        $iconClass   = $s['icon'] ?? ($s['fa'] ?? 'fa-briefcase');
                        $bgImages    = ['ens8.jpeg','ens2.jpg','ens5.jpeg','ens10.jpeg','ens12.jpg'];
                        $bgImg       = $bgImages[$idx % count($bgImages)];
                        $delays      = [0, 100, 200, 300, 400, 500];
                    @endphp
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $delays[$idx % 6] }}">
                        <div class="domain-card">
                            <div class="domain-bg" data-bg="{{ asset('template-siteweb/asset/img/' . $bgImg) }}"></div>
                            <div class="domain-overlay"></div>
                            <div class="domain-content">
                                <div class="domain-icon">
                                    <i class="fa {{ $iconClass }}"></i>
                                </div>
                                <h5 class="domain-title">{{ $title }}</h5>
                                <p class="domain-desc">{{ $description }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                {{-- Fallback statique --}}
                @php
                    $fallbackDomains = [
                        ['icon'=>'fa-balance-scale','title'=>'Défense des Droits','desc'=>'Protection des droits professionnels et amélioration des conditions de travail des enseignants.','bg'=>'ens8.jpeg'],
                        ['icon'=>'fa-graduation-cap','title'=>'Formation Continue','desc'=>'Programmes de formation pour le développement professionnel et pédagogique des enseignants.','bg'=>'ens2.jpg'],
                        ['icon'=>'fa-comments','title'=>'Négociation Collective','desc'=>'Dialogue social avec les autorités pour de meilleures politiques éducatives au Mali.','bg'=>'ens5.jpeg'],
                    ];
                @endphp
                @foreach($fallbackDomains as $idx => $d)
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $idx * 100 }}">
                        <div class="domain-card">
                            <div class="domain-bg" data-bg="{{ asset('template-siteweb/asset/img/' . $d['bg']) }}"></div>
                            <div class="domain-overlay"></div>
                            <div class="domain-content">
                                <div class="domain-icon">
                                    <i class="fa {{ $d['icon'] }}"></i>
                                </div>
                                <h5 class="domain-title">{{ $d['title'] }}</h5>
                                <p class="domain-desc">{{ $d['desc'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>

{{-- ╔══════════════════════════════════════════════════════╗ --}}
{{--   STATISTIQUES (section sombre type UM6P)              --}}
{{-- ╚══════════════════════════════════════════════════════╝ --}}
<section class="stats-section">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <p class="section-subtitle" style="color:rgba(255,255,255,0.5);">Nos Chiffres</p>
            <h2 class="section-title" style="color:#fff;">Le SYNEM en Chiffres</h2>
            <div class="section-divider center"></div>
        </div>
        <div class="row align-items-center">
            <div class="col-6 col-lg-3" data-aos="zoom-in" data-aos-delay="0">
                <div class="stat-card">
                    <div class="stat-icon-wrap">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="stat-number">
                        <span class="counter-number" data-target="5000">0</span><span class="plus">+</span>
                    </div>
                    <div class="stat-label">Membres Actifs</div>
                </div>
            </div>
            <div class="col-6 col-lg-3" data-aos="zoom-in" data-aos-delay="150">
                <div class="stat-card">
                    <div class="stat-icon-wrap">
                        <i class="fa fa-history"></i>
                    </div>
                    <div class="stat-number">
                        <span class="counter-number" data-target="30">0</span><span class="plus">+</span>
                    </div>
                    <div class="stat-label">Années d'Existence</div>
                </div>
            </div>
            <div class="col-6 col-lg-3" data-aos="zoom-in" data-aos-delay="300">
                <div class="stat-card">
                    <div class="stat-icon-wrap">
                        <i class="fa fa-map-marker-alt"></i>
                    </div>
                    <div class="stat-number">
                        <span class="counter-number" data-target="8">0</span>
                    </div>
                    <div class="stat-label">Sections Régionales</div>
                </div>
            </div>
            <div class="col-6 col-lg-3" data-aos="zoom-in" data-aos-delay="450">
                <div class="stat-card">
                    <div class="stat-icon-wrap">
                        <i class="fa fa-handshake"></i>
                    </div>
                    <div class="stat-number">
                        <span class="counter-number" data-target="15">0</span><span class="plus">+</span>
                    </div>
                    <div class="stat-label">Accords Signés</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ╔══════════════════════════════════════════════════════╗ --}}
{{--   ACTUALITÉS                                            --}}
{{-- ╚══════════════════════════════════════════════════════╝ --}}
<section class="news-section">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <p class="section-subtitle">Restez Informés</p>
            @php
                $hasCompteRendu = !empty($content->compte_rendu_title) && !empty($content->compte_rendu_content);
                $crImages = [];
                if ($hasCompteRendu && !empty($content->compte_rendu_images)) {
                    $crImages = is_array($content->compte_rendu_images)
                        ? $content->compte_rendu_images
                        : (json_decode($content->compte_rendu_images, true) ?: []);
                }
                $newsItems = collect(explode("\n", trim((string)($content->news_items ?? ''))))->map(fn($v)=>trim($v))->filter()->values();
                $newsTitle = trim((string)($content->news_title ?? ''));
            @endphp
            <h2 class="section-title">{{ $newsTitle !== '' ? $newsTitle : 'Dernières Actualités' }}</h2>
            <div class="section-divider center"></div>
        </div>

        <div class="row">
            @if($hasCompteRendu)
                {{-- Compte-rendu --}}
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="0">
                    <div class="news-card">
                        <div class="news-img-wrap">
                            @php $crImage = !empty($crImages) ? $crImages[0] : null; @endphp
                            @if($crImage)
                                <img src="{{ asset('storage/compte_rendu/' . $crImage) }}" alt="Compte Rendu">
                            @else
                                <img src="{{ asset('template-siteweb/asset/img/ens5.jpeg') }}" alt="Compte Rendu">
                            @endif
                            <span class="news-category">Compte Rendu</span>
                        </div>
                        <div class="news-body">
                            <div class="news-date"><i class="fa fa-calendar-alt"></i> {{ \Carbon\Carbon::now()->format('d M Y') }}</div>
                            <h5 class="news-title">{{ \Illuminate\Support\Str::limit($content->compte_rendu_title, 65) }}</h5>
                            <p class="news-excerpt">{{ \Illuminate\Support\Str::limit(strip_tags($content->compte_rendu_content), 110) }}</p>
                            <button class="news-btn" data-toggle="modal" data-target="#compteRenduModal">
                                Lire la suite <i class="fa fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @foreach($newsItems->slice(0,2) as $idx => $it)
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ ($idx+1) * 100 }}">
                        <div class="news-card">
                            <div class="news-img-wrap">
                                @php $newsImg = file_exists(public_path('template-siteweb/asset/img/ens' . ($idx+5) . '.jpeg')) ? asset('template-siteweb/asset/img/ens' . ($idx+5) . '.jpeg') : asset('template-siteweb/asset/img/ens5.jpeg'); @endphp
                                <img src="{{ $newsImg }}" alt="Actualité" class="img-fluid-cover">
                                <span class="news-category">Actualité</span>
                            </div>
                            <div class="news-body">
                                <div class="news-date"><i class="fa fa-calendar-alt"></i> {{ \Carbon\Carbon::now()->format('d M Y') }}</div>
                                <h5 class="news-title">{{ \Illuminate\Support\Str::limit($it, 65) }}</h5>
                                <p class="news-excerpt">{{ \Illuminate\Support\Str::limit($it, 110) }}</p>
                                <button class="news-btn news-read-btn" data-news-text="{{ e($it) }}">
                                    Lire la suite <i class="fa fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @elseif($newsItems->count() > 0)
                @foreach($newsItems->slice(0,3) as $idx => $it)
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $idx * 100 }}">
                        <div class="news-card">
                            <div class="news-img-wrap">
                                <img src="{{ asset('template-siteweb/asset/img/ens5.jpeg') }}" alt="Actualité">
                                <span class="news-category">Actualité</span>
                            </div>
                            <div class="news-body">
                                <div class="news-date"><i class="fa fa-calendar-alt"></i> {{ \Carbon\Carbon::now()->format('d M Y') }}</div>
                                <h5 class="news-title">{{ \Illuminate\Support\Str::limit($it, 65) }}</h5>
                                <p class="news-excerpt">{{ \Illuminate\Support\Str::limit($it, 110) }}</p>
                                <button class="news-btn news-read-btn" data-news-text="{{ e($it) }}">
                                    Lire la suite <i class="fa fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                {{-- Fallback statique --}}
                @php
                    $fallbackNews = [
                        ['img'=>'ens5.jpeg','cat'=>'Assemblée','title'=>'Assemblée Générale 2024','excerpt'=>"L'assemblée générale annuelle du SYNEM s'est tenue avec la participation de l'ensemble des sections régionales du Mali.",'text'=>"L'assemblée générale annuelle du SYNEM s'est tenue le 15 janvier 2024 avec la participation de représentants de toutes les régions."],
                        ['img'=>'ens12.jpg','cat'=>'Formation','title'=>'Nouveau Programme de Formation Pédagogique','excerpt'=>"Nouveau programme de formation continue pour les enseignants du primaire, en partenariat avec le Ministère de l'Éducation.",'text'=>"Un nouveau programme de formation continue a été lancé pour les enseignants du primaire."],
                        ['img'=>'accord.jpg','cat'=>'Accords','title'=>'Signature d\'Accords Salariaux','excerpt'=>"Signature d'un nouvel accord salarial avec le Ministère de l'Éducation nationale après plusieurs mois de négociations.",'text'=>"Un nouvel accord salarial a été signé avec le Ministère de l'Éducation nationale."],
                    ];
                @endphp
                @foreach($fallbackNews as $idx => $n)
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $idx * 100 }}">
                        <div class="news-card">
                            <div class="news-img-wrap">
                                @php $nImg = file_exists(public_path('template-siteweb/asset/img/' . $n['img'])) ? asset('template-siteweb/asset/img/' . $n['img']) : asset('template-siteweb/asset/img/ens5.jpeg'); @endphp
                                <img src="{{ $nImg }}" alt="{{ $n['title'] }}">
                                <span class="news-category">{{ $n['cat'] }}</span>
                            </div>
                            <div class="news-body">
                                <div class="news-date"><i class="fa fa-calendar-alt"></i> {{ now()->format('d M Y') }}</div>
                                <h5 class="news-title">{{ $n['title'] }}</h5>
                                <p class="news-excerpt">{{ $n['excerpt'] }}</p>
                                <button class="news-btn news-read-btn" data-news-text="{{ e($n['text']) }}">
                                    Lire la suite <i class="fa fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        {{-- ── Lettres publiées (Communiqués SYNEM) ── --}}
        @if($lettresPubliees && $lettresPubliees->count())
        <div class="text-center mb-4 mt-3" data-aos="fade-up">
            <p class="section-subtitle">Communiqués officiels</p>
            <h3 class="section-title" style="font-size:1.6rem">Lettres &amp; Communiqués du SYNEM</h3>
            <div class="section-divider center"></div>
        </div>

        <div class="row">
            @foreach($lettresPubliees as $idx => $lettre)
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $idx * 100 }}">
                <div class="document-card h-100">
                    <div class="doc-header">
                        <span class="doc-badge">PDF</span>
                        <small style="color:rgba(255,255,255,.5);font-size:11px">{{ $lettre->date_lettre->format('d M Y') }}</small>
                    </div>
                    <div class="doc-body">
                        <div class="d-flex align-items-center">
                            <div class="doc-icon-wrap" style="background:rgba(220,53,69,0.1);">
                                <i class="fas fa-file-pdf text-danger fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="doc-title">{{ $lettre->numero }}</h6>
                                <span class="doc-meta">{{ \Illuminate\Support\Str::limit($lettre->objet, 60) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="doc-footer">
                        @if($lettre->est_telechargeable)
                        <a href="{{ route('lettres.public.telecharger', $lettre) }}" class="btn-download" download>
                            <i class="fas fa-download"></i> Télécharger
                        </a>
                        @else
                        <span style="font-size:11px;color:#aaa;font-weight:600;letter-spacing:.5px;text-transform:uppercase"><i class="fas fa-lock mr-1"></i> Confidentiel</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

    </div>
</section>

{{-- Modal Compte Rendu --}}
@if(!empty($content->compte_rendu_title) && !empty($content->compte_rendu_content))
<div class="modal fade" id="compteRenduModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header modal-header-red">
                <h5 class="modal-title">{{ $content->compte_rendu_title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer"><span>&times;</span></button>
            </div>
            <div class="modal-body p-4" style="line-height:1.8; font-size:15px;">
                {!! nl2br(e($content->compte_rendu_content)) !!}
            </div>
        </div>
    </div>
</div>
@endif

{{-- Modal Actualités --}}
<div class="modal fade" id="newsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header modal-header-dark">
                <h5 class="modal-title" id="newsModalLabel">Actualité</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer"><span>&times;</span></button>
            </div>
            <div class="modal-body p-4" id="newsModalBody" style="line-height:1.8; font-size:15px;"></div>
        </div>
    </div>
</div>

{{-- ╔══════════════════════════════════════════════════════╗ --}}
{{--   DOCUMENTS ADMINISTRATIFS                             --}}
{{-- ╚══════════════════════════════════════════════════════╝ --}}
<section class="documents-section">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <p class="section-subtitle">Ressources</p>
            @php
                $documentsTitle = trim((string)($content->documents_title ?? ''));
            @endphp
            <h2 class="section-title">{{ $documentsTitle !== '' ? $documentsTitle : 'Documents Administratifs' }}</h2>
            <div class="section-divider center"></div>
        </div>

        <div class="row">
            @php $displayedDocuments = 0; $maxDocuments = 6; @endphp
            @if($content && $content->documents && count($content->documents))
                @foreach($content->documents as $doc)
                    @if($displayedDocuments < $maxDocuments)
                        <div class="col-lg-4 col-md-6 mb-4 document-item" data-aos="fade-up" data-aos-delay="{{ ($displayedDocuments % 3) * 100 }}">
                            <div class="document-card h-100">
                                <div class="doc-header">
                                    <span class="doc-badge">{{ strtoupper($doc->type) }}</span>
                                </div>
                                <div class="doc-body">
                                    <div class="d-flex align-items-center">
                                        <div class="doc-icon-wrap doc-icon-{{ $doc->type }}">
                                            @if($doc->type === 'pdf')
                                                <i class="fas fa-file-pdf text-danger fa-lg"></i>
                                            @elseif($doc->type === 'word')
                                                <i class="fas fa-file-word fa-lg" style="color:#0078d7"></i>
                                            @elseif($doc->type === 'excel')
                                                <i class="fas fa-file-excel text-success fa-lg"></i>
                                            @else
                                                <i class="fas fa-file-alt fa-lg text-secondary"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="doc-title">{{ $doc->title }}</h6>
                                            <span class="doc-meta">Publié récemment</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="doc-footer">
                                    <a href="{{ asset('storage/documents/' . $doc->file) }}" class="btn-download" download>
                                        <i class="fas fa-download"></i> Télécharger
                                    </a>
                                </div>
                            </div>
                        </div>
                        @php $displayedDocuments++; @endphp
                    @endif
                @endforeach
            @else
                @php
                    $fallbackDocuments = [
                        ['title'=>'Compte-rendu Congrès 2024','type'=>'pdf','size'=>'2.4 MB'],
                        ['title'=>"Rapport d'Activités 2023",'type'=>'pdf','size'=>'1.8 MB'],
                        ['title'=>'Convention Collective 2024','type'=>'pdf','size'=>'3.2 MB'],
                        ['title'=>'Guide du Militant','type'=>'pdf','size'=>'1.5 MB'],
                        ['title'=>'Statuts SYNEM 2024','type'=>'pdf','size'=>'2.1 MB'],
                        ['title'=>'Règlement Intérieur','type'=>'pdf','size'=>'1.9 MB'],
                    ];
                @endphp
                @foreach(array_slice($fallbackDocuments, 0, 6) as $idx => $doc)
                    <div class="col-lg-4 col-md-6 mb-4 document-item" data-aos="fade-up" data-aos-delay="{{ ($idx % 3) * 100 }}">
                        <div class="document-card h-100">
                            <div class="doc-header">
                                <span class="doc-badge">{{ strtoupper($doc['type']) }}</span>
                                @if($idx === 0)<span class="doc-badge-new">Nouveau</span>@endif
                            </div>
                            <div class="doc-body">
                                <div class="d-flex align-items-center">
                                    <div class="doc-icon-wrap" style="background:rgba(220,53,69,0.1);">
                                        <i class="fas fa-file-pdf text-danger fa-lg"></i>
                                    </div>
                                    <div>
                                        <h6 class="doc-title">{{ $doc['title'] }}</h6>
                                        <span class="doc-meta">PDF — {{ $doc['size'] }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="doc-footer">
                                <button type="button" class="btn-download document-download-btn" data-document-title="{{ $doc['title'] }}">
                                    <i class="fas fa-download"></i> Télécharger
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="text-center mt-4" data-aos="fade-up">
            <button type="button" class="btn btn-outline-primary btn-lg px-5" data-toggle="modal" data-target="#militantVerificationModal">
                <i class="fas fa-folder-open mr-2"></i>Voir tous les documents
            </button>
        </div>
    </div>
</section>

{{-- ╔══════════════════════════════════════════════════════╗ --}}
{{--   ESPACE MILITANT                                       --}}
{{-- ╚══════════════════════════════════════════════════════╝ --}}
<section class="militant-section">
    <div class="container" style="position:relative; z-index:1;">
        <div class="row justify-content-center">
            <div class="col-lg-7" data-aos="zoom-in">
                <div class="militant-card text-center">
                    <div class="militant-icon">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <h3 class="militant-title">Espace Militant</h3>
                    <p class="militant-desc">
                        Accédez à des documents exclusifs réservés aux militants approuvés du SYNEM.
                    </p>
                    <ul class="militant-list text-left d-inline-block">
                        <li><i class="fas fa-check-circle"></i> Statuts de l'organisation</li>
                        <li><i class="fas fa-check-circle"></i> Règlement intérieur</li>
                        <li><i class="fas fa-check-circle"></i> Convention collective</li>
                        <li><i class="fas fa-check-circle"></i> Guide du militant</li>
                        <li><i class="fas fa-check-circle"></i> Documents stratégiques</li>
                    </ul>
                    <div class="alert-militant">
                        <i class="fas fa-shield-alt mr-2"></i>
                        <strong>Accès sécurisé :</strong> Seuls les militants approuvés peuvent accéder à ces documents.
                    </div>
                    <a href="{{ route('militant.documents.access') }}" class="btn-militant">
                        <i class="fas fa-sign-in-alt mr-2"></i>Accéder aux Documents Réservés
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     MODALS
     ============================================================ --}}

{{-- Modal vérification militant --}}
<div class="modal fade" id="militantVerificationModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header modal-header-dark">
                <h5 class="modal-title"><i class="fas fa-user-check mr-2"></i>Vérification du Statut Militant</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer"><span>&times;</span></button>
            </div>
            <div class="modal-body p-4">
                <div id="verificationForm">
                    <div class="text-center mb-4">
                        <i class="fas fa-shield-alt fa-3x text-danger mb-3"></i>
                        <h5 class="font-weight-bold">Accès aux Documents Complets</h5>
                        <p class="text-muted">Pour accéder à tous les documents, veuillez confirmer votre statut de militant approuvé.</p>
                    </div>
                    <form id="militantVerificationForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Adresse Email *</label>
                                <input type="email" class="form-control" id="verification_email" name="email" required placeholder="votre.email@example.com">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Numéro de Carte *</label>
                                <input type="text" class="form-control" id="verification_card_number" name="card_number" required placeholder="Votre numéro de carte">
                            </div>
                        </div>
                        <div class="text-center mt-2">
                            <button type="submit" class="btn btn-primary btn-lg px-5" id="verifyBtn">
                                <i class="fas fa-check-circle mr-2"></i>Vérifier et Accéder
                            </button>
                        </div>
                    </form>
                </div>
                <div id="verificationResult" style="display:none;"></div>
            </div>
        </div>
    </div>
</div>

{{-- Modal adhésion --}}
<div class="modal fade" id="membershipModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header modal-header-dark">
                <h5 class="modal-title">Soumettre ma demande de militant</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
            </div>
            <div class="modal-body p-4">
                <form id="membershipForm">
                    <div class="row">
                        <div class="col-12 col-sm-6 mb-3">
                            <label>Nom *</label>
                            <input name="nom" type="text" class="form-control" placeholder="Votre nom" required>
                        </div>
                        <div class="col-12 col-sm-6 mb-3">
                            <label>Prénom *</label>
                            <input name="prenom" type="text" class="form-control" placeholder="Votre prénom" required>
                        </div>
                        <div class="col-12 col-sm-6 mb-3">
                            <label>Email *</label>
                            <input name="email" type="email" class="form-control" placeholder="votre.email@example.com" required>
                        </div>
                        <div class="col-12 col-sm-6 mb-3">
                            <label>Téléphone *</label>
                            <input name="tel" type="tel" class="form-control" placeholder="+223 XX XX XX XX" required>
                        </div>
                        <div class="col-12 col-sm-6 mb-3">
                            <label>Numéro de carte *</label>
                            <input name="n_cartes_syndicale" type="text" class="form-control" placeholder="Votre numéro de carte" required>
                        </div>
                        <div class="col-12 col-sm-6 mb-3">
                            <label>Division *</label>
                            <input name="division" type="text" class="form-control" placeholder="Ex : Section syndicale" required>
                        </div>
                        <div class="col-12 col-sm-6 mb-3">
                            <label>Coordination Locale *</label>
                            <input name="coordinations" type="text" class="form-control" placeholder="Ville, Région" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label>Message (optionnel)</label>
                            <textarea name="message" class="form-control" rows="3" placeholder="Informations supplémentaires..."></textarea>
                        </div>
                        <div class="col-12">
                            <label>Photo de votre carte de membre *</label>
                            <div class="card border" style="border-radius:4px;">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="text-center mb-3">
                                                <button type="button" id="captureBtn" class="btn btn-primary">
                                                    <i class="fa fa-camera mr-2"></i>Prendre une photo
                                                </button>
                                                <button type="button" id="uploadPhotoBtn" class="btn btn-outline-secondary btn-sm ml-2">
                                                    <i class="fa fa-image mr-1"></i>Importer
                                                </button>
                                                <p class="text-muted small mt-2">Photographiez votre carte de membre</p>
                                                <p id="cameraFallbackHint" class="text-muted small mt-1 d-none"></p>
                                                <input type="file" id="memberCardUpload" accept="image/*" capture="environment" class="d-none">
                                            </div>
                                            <div id="cameraContainer" class="d-none">
                                                <video id="camera" class="w-100 border rounded" autoplay playsinline></video>
                                                <div class="mt-2">
                                                    <button type="button" id="takePhotoBtn" class="btn btn-success btn-sm mr-2">
                                                        <i class="fa fa-camera mr-1"></i>Capturer
                                                    </button>
                                                    <button type="button" id="retakeBtn" class="btn btn-warning btn-sm d-none">
                                                        <i class="fa fa-redo mr-1"></i>Reprendre
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div id="photoPreview" class="d-none">
                                                <h6>Aperçu :</h6>
                                                <canvas id="photoCanvas" class="w-100 border rounded"></canvas>
                                                <input type="hidden" name="member_card_photo" id="memberCardPhoto">
                                            </div>
                                            <div id="noPhotoMessage" class="text-center text-muted pt-4">
                                                <i class="fa fa-camera fa-3x mb-3"></i>
                                                <p>Cliquez sur "Prendre une photo"</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary px-4" id="submitMembershipBtn">Soumettre la demande</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // News modal
    document.querySelectorAll('.news-read-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const txt = btn.getAttribute('data-news-text') || '';
            const body = document.getElementById('newsModalBody');
            if (body) body.innerHTML = '<p>' + txt.replace(/\n/g, '<br>') + '</p>';
            try { $('#newsModal').modal('show'); } catch (e) { }
        });
    });

    // Militant verification form
    $(document).on('submit', '#militantVerificationForm', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var btn = $('#verifyBtn');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Vérification...');
        $.ajax({
            url: '{{ route("militant.documents.verify") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                if (res.success) {
                    $('#verificationForm').hide();
                    $('#verificationResult').show().html('<div class="text-center"><i class="fas fa-check-circle fa-3x text-success mb-3"></i><h5 class="text-success">Vérification Réussie !</h5><p>Redirection en cours...</p></div>');
                    setTimeout(function () { window.location.href = '{{ route("militant.documents.index") }}'; }, 2000);
                }
            },
            error: function (xhr) {
                var msg = 'Une erreur est survenue.';
                if (xhr.responseJSON && xhr.responseJSON.errors) msg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                else if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                $('#verificationForm').hide();
                $('#verificationResult').show().html('<div class="text-center"><i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i><h5 class="text-warning">Vérification Échouée</h5><p>' + msg + '</p><div class="mt-3"><button class="btn btn-outline-primary mr-2" onclick="showVerificationForm()"><i class="fas fa-arrow-left mr-1"></i>Réessayer</button><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#membershipModal"><i class="fas fa-user-plus mr-1"></i>Devenir Militant</a></div></div>');
            },
            complete: function () { btn.prop('disabled', false).html('<i class="fas fa-check-circle mr-2"></i>Vérifier et Accéder'); }
        });
    });
    function showVerificationForm() {
        $('#verificationResult').hide();
        $('#verificationForm').show();
        $('#militantVerificationForm')[0].reset();
    }
    window.showVerificationForm = showVerificationForm;

    // Document download
    $('.document-download-btn').on('click', function () {
        $('#militantVerificationModal').modal('show');
        $('#militantVerificationForm')[0].reset();
        $('#verificationForm').show();
        $('#verificationResult').hide();
    });
});
</script>
<script>
// Camera / photo
let stream = null;
let canvas = document.getElementById('photoCanvas');
const video = () => document.getElementById('camera');
const captureBtn = document.getElementById('captureBtn');
const takePhotoBtn = document.getElementById('takePhotoBtn');
const retakeBtn = document.getElementById('retakeBtn');
const uploadPhotoBtn = document.getElementById('uploadPhotoBtn');
const fileUploadInput = document.getElementById('memberCardUpload');
const fallbackHint = document.getElementById('cameraFallbackHint');
const cameraContainer = document.getElementById('cameraContainer');
const noPhotoMessage = document.getElementById('noPhotoMessage');
const photoPreview = document.getElementById('photoPreview');
const memberCardPhotoField = document.getElementById('memberCardPhoto');

const stopCameraStream = () => { if (stream) { stream.getTracks().forEach(t => t.stop()); stream = null; } };
const showFallback = (msg) => { if (fallbackHint) { fallbackHint.textContent = msg; fallbackHint.classList.remove('d-none'); } };
const hideFallback = () => { if (fallbackHint) fallbackHint.classList.add('d-none'); };

const finalizePreview = (dataUrl) => {
    if (memberCardPhotoField) memberCardPhotoField.value = dataUrl;
    if (photoPreview) photoPreview.classList.remove('d-none');
    if (retakeBtn) retakeBtn.classList.remove('d-none');
    if (takePhotoBtn) takePhotoBtn.classList.add('d-none');
    if (noPhotoMessage) noPhotoMessage.classList.add('d-none');
    if (captureBtn) captureBtn.classList.add('d-none');
    hideFallback();
};
const drawUploadedImage = (dataUrl) => {
    if (!canvas) canvas = document.getElementById('photoCanvas');
    if (!canvas) return;
    const img = new Image();
    img.onload = function () {
        canvas.width = img.width; canvas.height = img.height;
        canvas.getContext('2d').drawImage(img, 0, 0);
        finalizePreview(canvas.toDataURL('image/jpeg', 0.8));
    };
    img.src = dataUrl;
};
const handleFileUpload = (file) => {
    if (!file) return;
    const reader = new FileReader();
    reader.onload = (e) => drawUploadedImage(e.target.result);
    reader.readAsDataURL(file);
    stopCameraStream();
    if (cameraContainer) cameraContainer.classList.add('d-none');
};
const startCamera = async () => {
    hideFallback();
    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        showFallback("La caméra n'est pas disponible. Importez une photo.");
        return;
    }
    try {
        stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' }, audio: false });
        const v = video();
        if (v) v.srcObject = stream;
        if (cameraContainer) cameraContainer.classList.remove('d-none');
        if (noPhotoMessage) noPhotoMessage.classList.add('d-none');
        if (captureBtn) captureBtn.classList.add('d-none');
    } catch (err) {
        showFallback("Impossible d'accéder à la caméra. Importez une photo.");
        stopCameraStream();
    }
};
if (captureBtn) captureBtn.addEventListener('click', startCamera);
if (takePhotoBtn) takePhotoBtn.addEventListener('click', function () {
    const v = video();
    if (!canvas || !v) return;
    canvas.width = v.videoWidth; canvas.height = v.videoHeight;
    canvas.getContext('2d').drawImage(v, 0, 0);
    finalizePreview(canvas.toDataURL('image/jpeg', 0.8));
    stopCameraStream();
    if (cameraContainer) cameraContainer.classList.add('d-none');
});
if (retakeBtn) retakeBtn.addEventListener('click', function () {
    if (photoPreview) photoPreview.classList.add('d-none');
    if (memberCardPhotoField) memberCardPhotoField.value = '';
    if (fileUploadInput) fileUploadInput.value = '';
    hideFallback();
    if (takePhotoBtn) takePhotoBtn.classList.remove('d-none');
    if (captureBtn) { captureBtn.classList.remove('d-none'); captureBtn.click(); }
    this.classList.add('d-none');
});
if (uploadPhotoBtn) uploadPhotoBtn.addEventListener('click', () => { if (fileUploadInput) { fileUploadInput.value = ''; fileUploadInput.click(); } });
if (fileUploadInput) fileUploadInput.addEventListener('change', function () { handleFileUpload(this.files && this.files[0]); });
$('#membershipModal').on('hidden.bs.modal', function () {
    stopCameraStream();
    if (cameraContainer) cameraContainer.classList.add('d-none');
    if (photoPreview) photoPreview.classList.add('d-none');
    if (captureBtn) captureBtn.classList.remove('d-none');
    if (retakeBtn) retakeBtn.classList.add('d-none');
    if (takePhotoBtn) takePhotoBtn.classList.remove('d-none');
    hideFallback();
    if (memberCardPhotoField) memberCardPhotoField.value = '';
    if (fileUploadInput) fileUploadInput.value = '';
});

document.getElementById('submitMembershipBtn').addEventListener('click', async function () {
    const form = document.getElementById('membershipForm');
    const formData = new FormData(form);
    const nom = formData.get('nom'), prenom = formData.get('prenom'), email = formData.get('email'), phone = formData.get('tel');
    const cardNumber = formData.get('n_cartes_syndicale'), division = formData.get('division'), coordination = formData.get('coordinations');
    const photo = memberCardPhotoField ? memberCardPhotoField.value : '';
    if (!nom || !prenom || !email || !phone || !cardNumber || !division || !coordination) { Swal.fire('Erreur', 'Veuillez remplir tous les champs obligatoires.', 'error'); return; }
    if (!photo) { Swal.fire('Erreur', 'Veuillez prendre une photo de votre carte de membre.', 'error'); return; }
    if (photo.startsWith('data:image')) { const r = await fetch(photo); const blob = await r.blob(); formData.set('attachment', blob, 'member_card.jpg'); }
    this.disabled = true;
    this.innerHTML = '<i class="fa fa-spinner fa-spin mr-2"></i>Envoi...';
    try {
        const res = await fetch('{{ route("contact.submit.membership") }}', {
            method: 'POST',
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
            body: formData
        });
        const data = await res.json();
        if (res.ok && data.success) {
            Swal.fire('Demande soumise', data.message || 'Nous vous contacterons bientôt.', 'success');
            form.reset();
            if (memberCardPhotoField) memberCardPhotoField.value = '';
            if (photoPreview) photoPreview.classList.add('d-none');
            hideFallback();
            if (fileUploadInput) fileUploadInput.value = '';
            $('#membershipModal').modal('hide');
        } else {
            let msg = 'Erreur lors de la soumission.';
            if (data && data.errors) msg = Object.values(data.errors).map(v => v.join(', ')).join('\n');
            else if (data && data.message) msg = data.message;
            Swal.fire('Erreur', msg, 'error');
        }
    } catch (e) { Swal.fire('Erreur', 'Erreur réseau. Veuillez réessayer.', 'error'); }
    this.disabled = false;
    this.innerHTML = 'Soumettre la demande';
});
</script>
@endsection
