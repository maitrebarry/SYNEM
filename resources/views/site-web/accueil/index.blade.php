@extends('layouts.site')

@section('title', 'SYNEM - Accueil')

@section('styles')
<style>
    .document-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid #e9ecef;
    }
    
    .document-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .document-card .card-header {
        border-bottom: 2px solid rgba(255,255,255,0.2);
    }
    
    .document-info {
        border-top: 1px solid #e9ecef;
        padding-top: 10px;
        margin-top: 15px;
    }
    
    /* Animation pour les nouveaux documents */
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    .badge-warning {
        animation: pulse 2s infinite;
    }
    
    /* Filtres */
    .btn-group-toggle .btn {
        margin: 0 5px 5px 0;
    }
    
    .btn-group-toggle .btn.active {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
    }
    /* Uniform news/card sizing */
    .rent-item {
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .rent-item img {
        width: 100%;
        height: 160px;
        object-fit: cover;
    }
    .rent-item .content {
        flex: 1 1 auto;
    }
    .rent-item .read-btn {
        margin-top: auto;
    }
</style>
@endsection

@section('content')
    <!-- Carousel Start -->
    <div class="container-fluid p-0" style="margin-bottom: 90px;">
        <div id="header-carousel" class="carousel slide" data-ride="carousel" data-bs-ride="carousel" data-interval="3000" data-bs-interval="3000">
            <div class="carousel-inner">
                @if($content && $content->carouselImages && count($content->carouselImages))
                    @foreach($content->carouselImages as $key => $img)
                        @php
                            // support optional per-image text if present (legacy compatibility)
                            $imgTitle = $img->title ?? $img->caption ?? $img->label ?? null;
                            $imgText = $img->text ?? $img->description ?? null;
                            // fallback to global carousel title/subtitle
                            $displayTitle = $imgTitle ?: ($content->carousel_title ?? 'Syndicat National');
                            $displaySubtitle = $imgText ?: ($content->carousel_subtitle ?? 'Défense des Droits des Enseignants');
                        @endphp
                        <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                            <img class="w-100" src="{{ asset('storage/carousel/' . $img->file) }}" alt="Carrousel {{ $key+1 }}">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 900px;">
                                    <h4 class="text-white text-uppercase mb-md-3">{{ $displayTitle }}</h4>
                                    <h1 class="display-1 text-white mb-md-4">{{ $displaySubtitle }}</h1>
                                    <a href="{{ route('a-propos') }}" class="btn btn-primary py-md-3 px-md-5 mt-2">En savoir plus</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="carousel-item active">
                        <img class="w-100" src="{{ asset('template-siteweb/asset/img/ens8.jpeg') }}" alt="SYNEM Éducation">
                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3" style="max-width: 900px;">
                                <h4 class="text-white text-uppercase mb-md-3">Syndicat National</h4>
                                <h1 class="display-1 text-white mb-md-4">Défense des Droits des Enseignants</h1>
                                                          <a href="{{ route('a-propos') }}" class="btn btn-primary py-md-3 px-md-5 mt-2">En savoir plus</a>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="w-100" src="{{ asset('template-siteweb/asset/img/ens2.jpg') }}" alt="SYNEM Formation">
                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3" style="max-width: 900px;">
                                <h4 class="text-white text-uppercase mb-md-3">Formation Continue</h4>
                                <h1 class="display-1 text-white mb-md-4">Développement Professionnel des Enseignants</h1>
                                <a href="{{ route('mission') }}" class="btn btn-primary py-md-3 px-md-5 mt-2">Notre Mission</a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
                <div class="btn btn-dark" style="width: 45px; height: 45px;">
                    <span class="carousel-control-prev-icon mb-n2"></span>
                </div>
            </a>
            <a class="carousel-control-next" href="#header-carousel" data-slide="next">
                <div class="btn btn-dark" style="width: 45px; height: 45px;">
                    <span class="carousel-control-next-icon mb-n2"></span>
                </div>
            </a>
        </div>
    </div>
    <!-- Carousel End -->

    <!-- About Start -->
    <div class="container-fluid py-5">
        <div class="container pt-5 pb-3">
            <h1 class="display-1 text-primary text-center">01</h1>
            <h1 class="display-4 text-uppercase text-center mb-5">Bienvenue au <span class="text-primary">SYNEM</span></h1>
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <img class="w-75 mb-4" src="{{ asset('template-siteweb/asset/img/ens10.jpeg') }}" alt="À propos du SYNEM">
                    <p>Le Syndicat National des Enseignants du Mali (SYNEM) est l'organisation syndicale qui représente et défend les intérêts des enseignants maliens à tous les niveaux du système éducatif. Fort de plusieurs décennies d'engagement, le SYNEM œuvre pour l'amélioration des conditions de travail et de vie des enseignants, la défense de leurs droits professionnels et la promotion d'une éducation de qualité pour tous les enfants du Mali.</p>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-lg-4 mb-2">
                    <div class="d-flex align-items-center bg-light p-4 mb-4" style="height: 150px;">
                        <div class="d-flex align-items-center justify-content-center flex-shrink-0 bg-primary ml-n4 mr-4" style="width: 100px; height: 100px;">
                            <i class="fa fa-2x fa-users text-secondary"></i>
                        </div>
                        <h4 class="text-uppercase m-0">Représentation</h4>
                    </div>
                </div>
                <div class="col-lg-4 mb-2">
                    <div class="d-flex align-items-center bg-secondary p-4 mb-4" style="height: 150px;">
                        <div class="d-flex align-items-center justify-content-center flex-shrink-0 bg-primary ml-n4 mr-4" style="width: 100px; height: 100px;">
                            <i class="fa fa-2x fa-graduation-cap text-secondary"></i>
                        </div>
                        <h4 class="text-light text-uppercase m-0">Formation Continue</h4>
                    </div>
                </div>
                <div class="col-lg-4 mb-2">
                    <div class="d-flex align-items-center bg-light p-4 mb-4" style="height: 150px;">
                        <div class="d-flex align-items-center justify-content-center flex-shrink-0 bg-primary ml-n4 mr-4" style="width: 100px; height: 100px;">
                            <i class="fa fa-2x fa-handshake text-secondary"></i>
                        </div>
                        <h4 class="text-uppercase m-0">Dialogue Social</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- Services Start -->
    <div class="container-fluid py-5">
        <div class="container pt-5 pb-3">
            <h1 class="display-1 text-primary text-center">02</h1>
            <h1 class="display-4 text-uppercase text-center mb-5">{{ ($content && $content->services_title) ? $content->services_title : 'Nos Domaines d\'Intervention' }}</h1>
            <div class="row">
                @php
                    $servicesItems = [];
                    if (!empty($content->services_items)) {
                        $servicesItems = is_array($content->services_items) ? $content->services_items : (json_decode($content->services_items, true) ?: []);
                    }
                @endphp

                @if(count($servicesItems))
                    @foreach($servicesItems as $idx => $s)
                        @php
                            $number = str_pad($idx + 1, 2, '0', STR_PAD_LEFT);
                            $title = $s['title'] ?? ($s['label'] ?? 'Service');
                            $description = $s['text'] ?? ($s['description'] ?? ($s['content'] ?? ''));
                            $iconClass = $s['icon'] ?? ($s['fa'] ?? 'fa-briefcase');
                        @endphp
                        <div class="col-lg-4 col-md-6 mb-2">
                            <div class="service-item {{ $idx === 1 ? 'active' : '' }} d-flex flex-column justify-content-center px-4 mb-4">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="d-flex align-items-center justify-content-center bg-primary ml-n4" style="width: 80px; height: 80px;">
                                        <i class="fa fa-2x {{ $iconClass }} text-secondary"></i>
                                    </div>
                                    <h1 class="display-2 text-white mt-n2 m-0">{{ $number }}</h1>
                                </div>
                                <h4 class="text-uppercase mb-3">{{ $title }}</h4>
                                <p class="m-0">{{ $description }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Static fallback content -->
                    <div class="col-lg-4 col-md-6 mb-2">
                        <div class="service-item d-flex flex-column justify-content-center px-4 mb-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center justify-content-center bg-primary ml-n4" style="width: 80px; height: 80px;">
                                    <i class="fa fa-2x fa-balance-scale text-secondary"></i>
                                </div>
                                <h1 class="display-2 text-white mt-n2 m-0">01</h1>
                            </div>
                            <h4 class="text-uppercase mb-3">Défense des Droits</h4>
                            <p class="m-0">Protection des droits professionnels et amélioration des conditions de travail des enseignants.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-2">
                        <div class="service-item active d-flex flex-column justify-content-center px-4 mb-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center justify-content-center bg-primary ml-n4" style="width: 80px; height: 80px;">
                                    <i class="fa fa-2x fa-book text-secondary"></i>
                                </div>
                                <h1 class="display-2 text-white mt-n2 m-0">02</h1>
                            </div>
                            <h4 class="text-uppercase mb-3">Formation Continue</h4>
                            <p class="m-0">Programmes de formation pour le développement professionnel des enseignants.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-2">
                        <div class="service-item d-flex flex-column justify-content-center px-4 mb-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center justify-content-center bg-primary ml-n4" style="width: 80px; height: 80px;">
                                    <i class="fa fa-2x fa-comments text-secondary"></i>
                                </div>
                                <h1 class="display-2 text-white mt-n2 m-0">03</h1>
                            </div>
                            <h4 class="text-uppercase mb-3">Négociation Collective</h4>
                            <p class="m-0">Dialogue social avec les autorités pour de meilleures politiques éducatives.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Services End -->

    <!-- Dernières Actualités Start -->
    <div class="container-fluid py-5">
        <div class="container pt-5 pb-3">
            <h1 class="display-1 text-primary text-center">03</h1>
            <h1 class="display-4 text-uppercase text-center mb-5">Dernières Actualités</h1>
            <div class="row">
                @php
                    // Compte rendu card (if present) + news list
                    $hasCompteRendu = !empty($content->compte_rendu_title) && !empty($content->compte_rendu_content);
                    $crImages = [];
                    if ($hasCompteRendu && !empty($content->compte_rendu_images)) {
                        $crImages = is_array($content->compte_rendu_images) ? $content->compte_rendu_images : (json_decode($content->compte_rendu_images, true) ?: []);
                    }
                    $newsItems = collect(explode("\n", trim((string)($content->news_items ?? ''))))->map(fn($v)=>trim($v))->filter()->values();
                    $newsCount = $newsItems->count();
                @endphp

                @if($hasCompteRendu)
                    <div class="col-lg-4 col-md-6 mb-2">
                        <div class="rent-item mb-4">
                            @php $crImage = !empty($crImages) ? $crImages[0] : null; @endphp
                            @if($crImage)
                                <img class="img-fluid mb-4" src="{{ asset('storage/compte_rendu/' . $crImage) }}" alt="Compte Rendu">
                            @endif
                            <h4 class="text-uppercase mb-4">{{ $content->compte_rendu_title }}</h4>
                            <button class="btn btn-primary px-3" data-toggle="modal" data-target="#compteRenduModal">Lire la suite</button>
                        </div>
                    </div>
                    {{-- show up to 2 news items next to compte-rendu --}}
                    @foreach($newsItems->slice(0,2) as $it)
                        <div class="col-lg-4 col-md-6 mb-2">
                                    <div class="rent-item mb-4">
                                        <img class="img-fluid mb-4" src="{{ asset('template-siteweb/asset/img/ens5.jpeg') }}" alt="Actualité">
                                        <div class="content">
                                            <h4 class="text-uppercase mb-4">{{ \Illuminate\Support\Str::limit($it, 60) }}</h4>
                                            <p class="mb-4">{{ \Illuminate\Support\Str::limit($it, 120) }}</p>
                                        </div>
                                        <button type="button" class="btn btn-primary px-3 read-btn news-read-btn" data-news-text="{{ e($it) }}">Lire la suite</button>
                                    </div>
                        </div>
                    @endforeach

                    {{-- if less than 2 news items, fill with static fallbacks --}}
                    @if($newsCount < 2)
                        @for($i = 0; $i < 2 - $newsCount; $i++)
                            <div class="col-lg-4 col-md-6 mb-2">
                                <div class="rent-item mb-4">
                                    <img class="img-fluid mb-4" src="{{ asset('template-siteweb/asset/img/ens12.jpg') }}" alt="Actualité">
                                    <h4 class="text-uppercase mb-4">Formation Pédagogique</h4>
                                    <p class="mb-4">Nouveau programme de formation continue pour les enseignants du primaire...</p>
                                    <a class="btn btn-primary px-3" href="#">Lire la suite</a>
                                </div>
                            </div>
                        @endfor
                    @endif
                @else
                    {{-- No compte-rendu: show either news items or static three boxes --}}
                    @if($newsCount > 0)
                        @foreach($newsItems->slice(0,3) as $it)
                            <div class="col-lg-4 col-md-6 mb-2">
                                <div class="rent-item mb-4">
                                        <img class="img-fluid mb-4" src="{{ asset('template-siteweb/asset/img/ens5.jpeg') }}" alt="Actualité">
                                        <div class="content">
                                            <h4 class="text-uppercase mb-4">{{ \Illuminate\Support\Str::limit($it, 60) }}</h4>
                                            <p class="mb-4">{{ \Illuminate\Support\Str::limit($it, 120) }}</p>
                                        </div>
                                        <button type="button" class="btn btn-primary px-3 read-btn news-read-btn" data-news-text="{{ e($it) }}">Lire la suite</button>
                                    </div>
                            </div>
                        @endforeach
                    @else
                        {{-- Static Fallback Data --}}
                        <div class="col-lg-4 col-md-6 mb-2">
                            <div class="rent-item mb-4">
                                <img class="img-fluid mb-4" src="{{ asset('template-siteweb/asset/img/ens5.jpeg') }}" alt="Actualité 1">
                                <h4 class="text-uppercase mb-4">Assemblée Générale 2024</h4>
                                <p class="mb-4">L'assemblée générale annuelle du SYNEM s'est tenue le 15 janvier 2024...</p>
                                <a class="btn btn-primary px-3" href="#">Lire la suite</a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-2">
                                <div class="rent-item mb-4">
                                        <img class="img-fluid mb-4" src="{{ asset('template-siteweb/asset/img/ens12.jpg') }}" alt="Actualité">
                                        <div class="content">
                                            <h4 class="text-uppercase mb-4">Formation Pédagogique</h4>
                                            <p class="mb-4">Nouveau programme de formation continue pour les enseignants du primaire...</p>
                                        </div>
                                        <button type="button" class="btn btn-primary px-3 read-btn" data-news-text="Formation Pédagogique">Lire la suite</button>
                                    </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-2">
                                <div class="rent-item mb-4">
                                        <img class="img-fluid mb-4" src="{{ asset('template-siteweb/asset/img/accord.jpg') }}" alt="Actualité 3">
                                        <div class="content">
                                            <h4 class="text-uppercase mb-4">Accords Salariaux</h4>
                                            <p class="mb-4">Signature d'un nouvel accord salarial avec le ministère de l'Éducation...</p>
                                        </div>
                                        <button type="button" class="btn btn-primary px-3 read-btn" data-news-text="Accords Salariaux">Lire la suite</button>
                                    </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
    <!-- Dernières Actualités End -->

    @if(!empty($content->compte_rendu_title) && !empty($content->compte_rendu_content))
    <!-- Modal Compte Rendu -->
    <div class="modal fade" id="compteRenduModal" tabindex="-1" role="dialog" aria-labelledby="compteRenduModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title  text-white" id="compteRenduModalLabel">{{ $content->compte_rendu_title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! nl2br(e($content->compte_rendu_content)) !!}
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Modal for news items -->
    <div class="modal fade" id="newsModal" tabindex="-1" role="dialog" aria-labelledby="newsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="newsModalLabel">Actualité</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="newsModalBody">
                    <!-- filled by JS -->
                </div>
            </div>
        </div>
    </div>

    <!-- Documents Administratifs Start -->
    <div class="container-fluid py-5">
        <div class="container pt-5 pb-3">
            <h1 class="display-1 text-primary text-center">04</h1>
            <h1 class="display-4 text-uppercase text-center mb-5">
                {{ ($content && $content->documents_title) ? $content->documents_title : 'Documents Administratifs' }}
            </h1>
            <div class="row">
                @php
                    $displayedDocuments = 0;
                    $maxDocuments = 6;
                @endphp
                @if($content && $content->documents && count($content->documents))
                    @foreach($content->documents as $doc)
                        @if($displayedDocuments < $maxDocuments)
                            <div class="col-lg-4 col-md-6 mb-4 document-item">
                                <div class="card document-card h-100 border-0 shadow-sm">
                                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                        <span class="badge badge-light">{{ strtoupper($doc->type) }}</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            @if($doc->type === 'pdf')
                                                <i class="fas fa-file-pdf text-danger fa-2x mr-3"></i>
                                            @elseif($doc->type === 'word')
                                                <i class="fas fa-file-word text-primary fa-2x mr-3"></i>
                                            @elseif($doc->type === 'excel')
                                                <i class="fas fa-file-excel text-success fa-2x mr-3"></i>
                                            @else
                                                <i class="fas fa-file-alt fa-2x mr-3"></i>
                                            @endif
                                            <div>
                                                <h5 class="card-title mb-1">{{ $doc->title }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-transparent">
                                        <a href="{{ asset('storage/documents/' . $doc->file) }}" class="btn btn-primary btn-sm" download>
                                            <i class="fas fa-download mr-2"></i>Télécharger
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @php $displayedDocuments++; @endphp
                        @endif
                    @endforeach
                @else
                    <!-- Fallback contenu statique limité à 6 documents -->
                    @php
                        $fallbackDocuments = [
                            ['title' => 'Compte-rendu Congrès 2024', 'type' => 'pdf', 'size' => '2.4 MB', 'description' => 'Rapport complet des résolutions et décisions du congrès annuel 2024.'],
                            ['title' => 'Rapport d\'Activités 2023', 'type' => 'pdf', 'size' => '1.8 MB', 'description' => 'Bilan complet des activités de l\'année 2023.'],
                            ['title' => 'Convention Collective 2024', 'type' => 'pdf', 'size' => '3.2 MB', 'description' => 'Convention collective des enseignants du Mali.'],
                            ['title' => 'Guide du Militant', 'type' => 'pdf', 'size' => '1.5 MB', 'description' => 'Guide complet pour les militants actifs.'],
                            ['title' => 'Statuts SYNEM 2024', 'type' => 'pdf', 'size' => '2.1 MB', 'description' => 'Statuts officiels du Syndicat National des Enseignants du Mali.'],
                            ['title' => 'Règlement Intérieur', 'type' => 'pdf', 'size' => '1.9 MB', 'description' => 'Règlement intérieur de l\'organisation.']
                        ];
                    @endphp
                    @foreach(array_slice($fallbackDocuments, 0, $maxDocuments) as $index => $doc)
                        <div class="col-lg-4 col-md-6 mb-4 document-item">
                            <div class="card document-card h-100 border-0 shadow-sm">
                                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                    <span class="badge badge-light">{{ strtoupper($doc['type']) }}</span>
                                    @if($index === 0)
                                        <span class="badge badge-warning">Nouveau</span>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        @if($doc['type'] === 'pdf')
                                            <i class="fas fa-file-pdf text-danger fa-2x mr-3"></i>
                                        @elseif($doc['type'] === 'word')
                                            <i class="fas fa-file-word text-primary fa-2x mr-3"></i>
                                        @elseif($doc['type'] === 'excel')
                                            <i class="fas fa-file-excel text-success fa-2x mr-3"></i>
                                        @else
                                            <i class="fas fa-file-alt fa-2x mr-3"></i>
                                        @endif
                                        <div>
                                            <h5 class="card-title mb-1">{{ $doc['title'] }}</h5>
                                            <small class="text-muted">Publié récemment</small>
                                        </div>
                                    </div>
                                    <p class="card-text">{{ $doc['description'] }}</p>
                                    <div class="document-info">
                                        <small class="text-muted">
                                            <i class="fas fa-file-alt mr-1"></i>{{ strtoupper($doc['type']) }} - {{ $doc['size'] }}
                                        </small>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <button type="button" class="btn btn-primary btn-sm document-download-btn" data-document-title="{{ $doc['title'] }}">
                                        <i class="fas fa-download mr-2"></i>Télécharger
                                    </button>
                                </div>
                            </div>
                        </div>
                        @php $displayedDocuments++; @endphp
                    @endforeach
                @endif
            </div>

            <!-- Bouton Voir Tous les Documents avec Vérification Militant -->
            <div class="text-center mt-4">
                <button type="button" class="btn btn-outline-primary btn-lg" data-toggle="modal" data-target="#militantVerificationModal">
                    <i class="fas fa-folder-open mr-2"></i>Voir tous les documents
                </button>
            </div>
        </div>
    </div>
    <!-- Documents Administratifs End -->

    <!-- Modals pour aperçu des documents -->
    <div class="modal fade" id="documentModal1" tabindex="-1" role="dialog" aria-labelledby="documentModal1Label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="documentModal1Label">Compte-rendu Congrès 2024</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fas fa-file-pdf text-danger fa-5x mb-3"></i>
                        <p>Ce document est disponible en téléchargement.</p>
                        <p><strong>Taille :</strong> 2.4 MB</p>
                        <a href="{{ asset('storage/documents/congres-2024.pdf') }}" class="btn btn-primary" download>
                            <i class="fas fa-download mr-2"></i>Télécharger le PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="documentModal2" tabindex="-1" role="dialog" aria-labelledby="documentModal2Label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="documentModal2Label">Rapport d'Activités 2023</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fas fa-file-pdf text-danger fa-5x mb-3"></i>
                        <p>Ce document est disponible en téléchargement.</p>
                        <p><strong>Taille :</strong> 1.8 MB</p>
                        <a href="{{ asset('storage/documents/rapport-2023.pdf') }}" class="btn btn-primary" download>
                            <i class="fas fa-download mr-2"></i>Télécharger le PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Vérification Militant -->
    <div class="modal fade" id="militantVerificationModal" tabindex="-1" role="dialog" aria-labelledby="militantVerificationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="militantVerificationModalLabel">
                        <i class="fas fa-user-check me-2"></i>
                        Vérification du Statut Militant
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fermer">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="verificationForm">
                        <div class="text-center mb-4">
                            <i class="fas fa-shield-alt fa-3x text-primary mb-3"></i>
                            <h5>Accès aux Documents Complets</h5>
                            <p class="text-muted">
                                Pour accéder à tous les documents, veuillez confirmer votre statut de militant approuvé.
                            </p>
                        </div>

                        <form id="militantVerificationForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="verification_email" class="form-label">
                                        <i class="fas fa-envelope me-1"></i>Adresse Email *
                                    </label>
                                    <input type="email" class="form-control" id="verification_email" name="email" required
                                           placeholder="votre.email@example.com">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="verification_card_number" class="form-label">
                                        <i class="fas fa-id-card me-1"></i>Numéro de Carte *
                                    </label>
                                    <input type="text" class="form-control" id="verification_card_number" name="card_number" required
                                           placeholder="Votre numéro de carte">
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg" id="verifyBtn">
                                    <i class="fas fa-check-circle me-2"></i>
                                    Vérifier et Accéder
                                </button>
                            </div>
                        </form>
                    </div>

                    <div id="verificationResult" style="display: none;">
                        <!-- Résultat de la vérification sera affiché ici -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid py-5 bg-light">
        <div class="container pt-5 pb-3">
            <h1 class="display-1 text-primary text-center">05</h1>
            <h1 class="display-4 text-uppercase text-center mb-5">Espace Militant</h1>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card border-primary shadow">
                        <div class="card-header bg-primary text-white text-center">
                            <h4 class="mb-0">
                                <i class="fas fa-lock me-2"></i>
                                Documents Réservés aux Militants Approuvés
                            </h4>
                        </div>
                        <div class="card-body text-center">
                            <div class="mb-4">
                                <i class="fas fa-file-alt fa-4x text-primary mb-3"></i>
                                <p class="lead">
                                    Accédez à des documents exclusifs réservés aux militants approuvés du SYNEM :
                                </p>
                                <ul class="list-unstyled text-left d-inline-block">
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Statuts de l'organisation</li>
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Règlement intérieur</li>
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Convention collective</li>
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Guide du militant</li>
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Documents stratégiques</li>
                                </ul>
                            </div>

                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Accès sécurisé :</strong> Seuls les militants dont la demande a été approuvée peuvent accéder à ces documents.
                            </div>

                            <a href="{{ route('militant.documents.access') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Accéder aux Documents Réservés
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Documents Réservés Militants End -->

    <!-- Membership Submission Modal -->
    <div class="modal fade" id="membershipModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Soumettre ma demande de militant</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="membershipForm">
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <label class="form-label">Nom *</label>
                                <input name="nom" type="text" class="form-control" placeholder="Votre nom" required>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="form-label">Prénom *</label>
                                <input name="prenom" type="text" class="form-control" placeholder="Votre prénom" required>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="form-label">Email *</label>
                                <input name="email" type="email" class="form-control" placeholder="votre.email@example.com" required>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="form-label">Téléphone *</label>
                                <input name="tel" type="tel" class="form-control" placeholder="+223 XX XX XX XX" required>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="form-label">Numéro de carte *</label>
                                <input name="n_cartes_syndicale" type="text" class="form-control" placeholder="Votre numéro de carte" required>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="form-label">Coordination Locale</label>
                                <input name="coordinations" type="text" class="form-control" placeholder="Ville, Région">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Message (optionnel)</label>
                                <textarea name="message" class="form-control" rows="3" placeholder="Informations supplémentaires..."></textarea>
                            </div>

                            <!-- Photo de la carte de membre -->
                            <div class="col-12">
                                <label class="form-label">Photo de votre carte de membre *</label>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="text-center mb-3">
                                                    <button type="button" id="captureBtn" class="btn btn-primary">
                                                        <i class="fa fa-camera me-2"></i>Prendre une photo
                                                    </button>
                                                    <button type="button" id="uploadPhotoBtn" class="btn btn-outline-secondary btn-sm ms-2">
                                                        <i class="fa fa-image me-1"></i>Importer une photo
                                                    </button>
                                                    <p class="text-muted small mt-2">Utilisez votre caméra pour photographier votre carte de membre</p>
                                                    <p id="cameraFallbackHint" class="text-muted small mt-1 d-none"></p>
                                                    <input type="file" id="memberCardUpload" accept="image/*" capture="environment" class="d-none">
                                                </div>
                                                <div id="cameraContainer" class="d-none">
                                                    <video id="camera" class="w-100 border rounded" autoplay playsinline></video>
                                                    <div class="mt-2">
                                                        <button type="button" id="takePhotoBtn" class="btn btn-success btn-sm me-2">
                                                            <i class="fa fa-camera me-1"></i>Capturer
                                                        </button>
                                                        <button type="button" id="retakeBtn" class="btn btn-warning btn-sm d-none">
                                                            <i class="fa fa-refresh me-1"></i>Reprendre
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="photoPreview" class="d-none">
                                                    <h6>Aperçu de la photo :</h6>
                                                    <canvas id="photoCanvas" class="w-100 border rounded"></canvas>
                                                    <input type="hidden" name="member_card_photo" id="memberCardPhoto">
                                                </div>
                                                <div id="noPhotoMessage" class="text-center text-muted">
                                                    <i class="fa fa-camera fa-3x mb-3"></i>
                                                    <p>Cliquez sur "Prendre une photo" pour commencer</p>
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
                    <button type="button" class="btn btn-primary" id="submitMembershipBtn">Soumettre la demande</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Filtrage des documents par catégorie
        $('input[name="categories"]').change(function() {
            var selectedCategory = this.id;

            $('.document-item').hide();

            if (selectedCategory === 'tous') {
                $('.document-item').show();
            } else {
                $('.document-item[data-category="' + selectedCategory + '"]').show();
            }
        });

        // Notification de nouveaux documents
        function checkNewDocuments() {
            // Simuler une vérification de nouveaux documents
            setTimeout(function() {
                $('.alert').fadeIn();
            }, 3000);
        }

        // Vérifier les nouveaux documents au chargement
        checkNewDocuments();

        // Gestionnaire pour les boutons de téléchargement de documents
        $('.document-download-btn').on('click', function() {
            var documentTitle = $(this).data('document-title');
            checkMilitantAccess(documentTitle);
        });
    });

    // Fonction de vérification d'accès militant
    function checkMilitantAccess(documentTitle) {
        // Ouvrir le modal de vérification
        $('#militantVerificationModal').modal('show');

        // Reset du formulaire
        $('#militantVerificationForm')[0].reset();
        $('#verificationForm').show();
        $('#verificationResult').hide();
    }

    // Gestionnaire pour le formulaire de vérification
    $(document).on('submit', '#militantVerificationForm', function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        var submitBtn = $('#verifyBtn');
        var originalText = submitBtn.html();

        // Désactiver le bouton et afficher le loading
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Vérification...');

        $.ajax({
            url: '{{ route("militant.documents.verify") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    // Vérification réussie - rediriger vers la liste complète des documents
                    $('#verificationForm').hide();
                    $('#verificationResult').show().html(`
                        <div class="text-center">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <h5 class="text-success">Vérification Réussie !</h5>
                            <p>Vous allez être redirigé vers la liste complète des documents...</p>
                        </div>
                    `);

                    // Rediriger après 2 secondes
                    setTimeout(function() {
                        window.location.href = '{{ route("militant.documents.index") }}';
                    }, 2000);
                }
            },
            error: function(xhr) {
                var errorMessage = 'Une erreur est survenue lors de la vérification.';

                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    // Erreurs de validation
                    var errors = xhr.responseJSON.errors;
                    errorMessage = Object.values(errors).flat().join('<br>');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                $('#verificationForm').hide();
                $('#verificationResult').show().html(`
                    <div class="text-center">
                        <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                        <h5 class="text-warning">Vérification Échouée</h5>
                        <p>${errorMessage}</p>
                        <div class="mt-3">
                            <button type="button" class="btn btn-outline-primary me-2" onclick="showVerificationForm()">
                                <i class="fas fa-arrow-left me-1"></i>Réessayer
                            </button>
                            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#membershipModal">
                                <i class="fas fa-user-plus me-1"></i>Devenir Militant
                            </a>
                        </div>
                    </div>
                `);
            },
            complete: function() {
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });

    // Fonction pour revenir au formulaire de vérification
    function showVerificationForm() {
        $('#verificationResult').hide();
        $('#verificationForm').show();
        $('#militantVerificationForm')[0].reset();
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function(){
        // open news modal with full text
        document.querySelectorAll('.news-read-btn').forEach(function(btn){
            btn.addEventListener('click', function(){
                const txt = btn.getAttribute('data-news-text') || '';
                const modalLabel = document.getElementById('newsModalLabel');
                const modalBody = document.getElementById('newsModalBody');
                if(modalLabel) modalLabel.textContent = 'Actualité';
                if(modalBody) modalBody.innerHTML = '<p>' + txt.replace(/\n/g, '<br>') + '</p>';
                try{ $('#newsModal').modal('show'); } catch(e){
                    try{ new bootstrap.Modal(document.getElementById('newsModal')).show(); } catch(err){ console.warn('Modal show failed', err); }
                }
            });
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let stream = null;
    let canvas = document.getElementById('photoCanvas');
    let video = null;

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

    const stopCameraStream = () => {
        if (!stream) return;
        stream.getTracks().forEach(track => track.stop());
        stream = null;
    };

    const showFallbackMessage = (message) => {
        if (!fallbackHint) return;
        fallbackHint.textContent = message;
        fallbackHint.classList.remove('d-none');
    };

    const hideFallbackMessage = () => {
        if (fallbackHint) {
            fallbackHint.classList.add('d-none');
        }
    };

    const finalizePreview = (dataUrl) => {
        if (memberCardPhotoField) {
            memberCardPhotoField.value = dataUrl;
        }
        if (photoPreview) {
            photoPreview.classList.remove('d-none');
        }
        if (retakeBtn) {
            retakeBtn.classList.remove('d-none');
        }
        if (takePhotoBtn) {
            takePhotoBtn.classList.add('d-none');
        }
        if (noPhotoMessage) {
            noPhotoMessage.classList.add('d-none');
        }
        if (captureBtn) {
            captureBtn.classList.add('d-none');
        }
        hideFallbackMessage();
    };

    const drawUploadedImage = (dataUrl) => {
        if (!canvas) {
            canvas = document.getElementById('photoCanvas');
        }
        if (!canvas) return;

        const image = new Image();
        image.onload = function () {
            canvas.width = image.width;
            canvas.height = image.height;
            const context = canvas.getContext('2d');
            context.clearRect(0, 0, canvas.width, canvas.height);
            context.drawImage(image, 0, 0, canvas.width, canvas.height);
            const finalDataUrl = canvas.toDataURL('image/jpeg', 0.8);
            finalizePreview(finalDataUrl);
        };
        image.src = dataUrl;
    };

    const handleFileUpload = (file) => {
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function (event) {
            drawUploadedImage(event.target.result);
        };
        reader.readAsDataURL(file);
        stopCameraStream();
        if (cameraContainer) {
            cameraContainer.classList.add('d-none');
        }
    };

    const startCamera = async () => {
        hideFallbackMessage();

        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            showFallbackMessage('La caméra n\'est pas disponible dans ce navigateur. Importez une photo en utilisant le bouton ci-dessous.');
            return;
        }

        try {
            stream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: 'environment' },
                audio: false
            });

            video = document.getElementById('camera');
            canvas = canvas || document.getElementById('photoCanvas');

            if (video) {
                video.srcObject = stream;
            }

            if (cameraContainer) {
                cameraContainer.classList.remove('d-none');
            }
            if (noPhotoMessage) {
                noPhotoMessage.classList.add('d-none');
            }
            if (captureBtn) {
                captureBtn.classList.add('d-none');
            }
        } catch (error) {
            console.error('Error accessing camera:', error);
            showFallbackMessage('Impossible d\'accéder à la caméra. Importez une photo en utilisant le bouton ci-dessous.');
            stopCameraStream();
        }
    };

    if (captureBtn) {
        captureBtn.addEventListener('click', startCamera);
    }

    if (takePhotoBtn) {
        takePhotoBtn.addEventListener('click', function () {
            if (!canvas || !video) return;

            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            const dataUrl = canvas.toDataURL('image/jpeg', 0.8);
            finalizePreview(dataUrl);

            stopCameraStream();
            if (cameraContainer) {
                cameraContainer.classList.add('d-none');
            }
        });
    }
    if (retakeBtn) {
        retakeBtn.addEventListener('click', function () {
            if (photoPreview) {
                photoPreview.classList.add('d-none');
            }
            if (memberCardPhotoField) {
                memberCardPhotoField.value = '';
            }
            if (fileUploadInput) {
                fileUploadInput.value = '';
            }
            hideFallbackMessage();
            if (takePhotoBtn) {
                takePhotoBtn.classList.remove('d-none');
            }

            if (captureBtn) {
                captureBtn.classList.remove('d-none');
                captureBtn.click();
            }
            this.classList.add('d-none');
        });
    }
    if (uploadPhotoBtn) {
        uploadPhotoBtn.addEventListener('click', function () {
        if (fileUploadInput) {
            fileUploadInput.value = '';
            fileUploadInput.click();
        }
        });
    }

    if (fileUploadInput) {
        fileUploadInput.addEventListener('change', function () {
            const file = this.files && this.files[0];
            if (!file) return;
            handleFileUpload(file);
        });
    }

    $('#membershipModal').on('hidden.bs.modal', function () {
        stopCameraStream();
        if (cameraContainer) {
            cameraContainer.classList.add('d-none');
        }
        if (photoPreview) {
            photoPreview.classList.add('d-none');
        }
        if (captureBtn) {
            captureBtn.classList.remove('d-none');
        }
        if (retakeBtn) {
            retakeBtn.classList.add('d-none');
        }
        if (takePhotoBtn) {
            takePhotoBtn.classList.remove('d-none');
        }
        hideFallbackMessage();
        if (memberCardPhotoField) {
            memberCardPhotoField.value = '';
        }
        if (fileUploadInput) {
            fileUploadInput.value = '';
        }
    });

    document.getElementById('submitMembershipBtn').addEventListener('click', async function () {
        const form = document.getElementById('membershipForm');
        const formData = new FormData(form);

        // Validate required fields
        const nom = formData.get('nom');
        const prenom = formData.get('prenom');
        const email = formData.get('email');
        const phone = formData.get('tel');
        const photo = memberCardPhotoField ? memberCardPhotoField.value : '';

        if (!nom || !prenom || !email || !phone) {
            Swal.fire('Erreur', 'Veuillez remplir tous les champs obligatoires.', 'error');
            return;
        }

        if (!photo) {
            Swal.fire('Erreur', 'Veuillez prendre une photo de votre carte de membre.', 'error');
            return;
        }

        // Convert base64 photo to blob for FormData
        if (photo.startsWith('data:image')) {
            const response = await fetch(photo);
            const blob = await response.blob();
            formData.set('attachment', blob, 'member_card.jpg');
        }

        const submitBtn = this;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin me-2"></i>Envoi...';

        try {
            const url = '{{ route("contact.submit.membership") }}';
            const res = await fetch(url, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            });

            const data = await res.json();
            if (res.ok && data.success) {
                Swal.fire('Demande soumise', data.message || 'Nous vous contacterons bientôt.', 'success');
                form.reset();
                if (memberCardPhotoField) {
                    memberCardPhotoField.value = '';
                }
                if (photoPreview) {
                    photoPreview.classList.add('d-none');
                }
                hideFallbackMessage();
                if (fileUploadInput) {
                    fileUploadInput.value = '';
                }
                $('#membershipModal').modal('hide');
            } else {
                let msg = 'Erreur lors de la soumission.';
                if (data && data.errors) {
                    msg = Object.values(data.errors).map(v=>v.join(', ')).join('\n');
                } else if (data && data.message) {
                    msg = data.message;
                }
                Swal.fire('Erreur', msg, 'error');
            }
        } catch (e) {
            console.error('Submission error:', e);
            Swal.fire('Erreur', 'Erreur réseau. Veuillez réessayer.', 'error');
        }

        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Soumettre la demande';
    });
</script>
@endsection