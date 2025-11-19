@extends('layouts.site')

@section('title', 'Historique - SYNEM')

@section('styles')
<style>
    .history-section {
        position: relative;
        padding: 80px 0;
    }
    
    .history-item {
        position: relative;
        margin-bottom: 50px;
    }
    
    .history-year {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        background: #007bff;
        color: white;
        padding: 10px 20px;
        border-radius: 25px;
        font-weight: bold;
        z-index: 2;
    }
    
    .history-content {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        margin-top: 40px;
        position: relative;
    }
    
    .history-content::before {
        content: '';
        position: absolute;
        top: -10px;
        left: 50%;
        transform: translateX(-50%) rotate(45deg);
        width: 20px;
        height: 20px;
        background: white;
    }
    
    .milestone-card {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
        padding: 30px;
        border-radius: 10px;
        text-align: center;
        margin-bottom: 30px;
        min-height: 200px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    .milestone-number {
        font-size: 3rem;
        font-weight: bold;
        margin-bottom: 10px;
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="row align-items-center g-5">
        <div class="col-lg-6 mb-4 mb-lg-0">
            @if(!empty($main) && !empty($main->image))
                <img src="{{ $main->image_url }}" alt="Historique SYNEM" class="img-fluid rounded shadow">
            @else
                <img src="{{ asset('template-siteweb/asset/img/historique-demo.jpg') }}" alt="Historique SYNEM" class="img-fluid rounded shadow">
            @endif
        </div>
        <div class="col-lg-6">
            <h1 class="mb-3 text-primary">Historique</h1>
            @if(!empty($main) && !empty($main->text))
                <p class="lead mb-4">{{ $main->text }}</p>
            @else
                <p class="lead mb-4">Depuis sa création, le SYNEM a marqué l’histoire de l’éducation au Mali par des actions fortes : organisation de congrès, négociations avec l’État, lancement de programmes de formation, et digitalisation des services pour ses membres.</p>
                <ul class="list-unstyled mb-4">
                    <li class="mb-2"><i class="fa fa-check-circle text-primary me-2"></i>Organisation de congrès nationaux</li>
                    <li class="mb-2"><i class="fa fa-check-circle text-primary me-2"></i>Négociations et accords historiques</li>
                    <li class="mb-2"><i class="fa fa-check-circle text-primary me-2"></i>Programmes de formation continue</li>
                    <li class="mb-2"><i class="fa fa-check-circle text-primary me-2"></i>Digitalisation des services</li>
                </ul>
            @endif
        </div>
    </div>
</div>

<!-- Key Moments Start -->
<div class="container py-5">
    <div class="section-title text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 700px;">
        <h2 class="mb-0">Moments clés</h2>
        <p class="text-muted mt-2">Points marquants de l'histoire du SYNEM</p>
    </div>
    <div class="row g-4">
    @php $events = $events ?? [] ; @endphp
    @foreach($events as $ev)
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 border-0 shadow-sm overflow-hidden">
                    @if(!empty($ev['image']))
                        <img src="{{ $ev['image'] }}" class="card-img-top" style="height:160px;object-fit:cover;" alt="{{ $ev['title'] }}">
                    @elseif(!empty($ev['icon']))
                        <div class="p-4 text-center bg-primary bg-gradient text-white">
                            <i class="{{ $ev['icon'] }} fa-2x"></i>
                        </div>
                    @else
                        <div class="p-4 text-center bg-secondary bg-gradient text-white">
                            <i class="fa fa-history fa-2x"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <div class="me-3">
                                <span class="badge bg-primary text-white rounded-pill py-2 px-3">{{ $ev['year'] ?? '' }}</span>
                            </div>
                            <div>
                                <h5 class="card-title mb-1">{{ $ev['title'] ?? '' }}</h5>
                                <p class="card-text text-muted small mb-0">{{ $ev['text'] ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-end small text-muted">
                        Ordre: <strong>{{ $ev['ordering'] ?? 0 }}</strong>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<!-- Key Moments End -->

<!-- Milestones Start (kept) -->
<div class="container-fluid py-5 bg-light">
    <div class="container py-5">
        <div class="section-title text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px;">
            <h1 class="mb-0">Nos Réalisations</h1>
        </div>
        <div class="row g-5">
            @if(!empty($milestones) && is_array($milestones))
                @foreach($milestones as $m)
                    <div class="col-lg-3 col-md-6">
                        <div class="milestone-card">
                            <div class="milestone-number">{{ $m['number'] ?? '' }}</div>
                            <p>{{ $m['label'] ?? '' }}</p>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-lg-3 col-md-6">
                    <div class="milestone-card">
                        <div class="milestone-number">15K+</div>
                        <p>Enseignants Membres</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="milestone-card">
                        <div class="milestone-number">34</div>
                        <p>Années de Service</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="milestone-card">
                        <div class="milestone-number">500+</div>
                        <p>Formations Organisées</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="milestone-card">
                        <div class="milestone-number">8</div>
                        <p>Régions Couvertes</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
<!-- Milestones End -->

<!-- Archives Start (kept) -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="section-title text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px;">
            <h1 class="mb-0">Archives Historiques</h1>
        </div>
        <div class="row g-5">
            @if(!empty($archives) && is_array($archives))
                @foreach($archives as $a)
                    <div class="col-lg-4 col-md-6">
                        <div class="card border-0 shadow-sm">
                            @if(!empty($a['image']))
                                <img src="{{ $a['image'] }}" class="card-img-top" alt="{{ $a['title'] ?? 'Archive' }}">
                            @else
                                <img src="{{ asset('template-siteweb/asset/img/gallery-1.jpg') }}" class="card-img-top" alt="Archive">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $a['title'] ?? 'Archive' }}</h5>
                                <p class="card-text">{{ Str::limit($a['text'] ?? '', 140) }}</p>
                                @if(!empty($a['link']))
                                    <a href="{{ $a['link'] }}" class="btn btn-primary">Voir</a>
                                @else
                                    <a href="#" class="btn btn-primary">Voir</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm">
                        <img src="{{ asset('template-siteweb/asset/img/gallery-1.jpg') }}" class="card-img-top" alt="Archive 1990">
                        <div class="card-body">
                            <h5 class="card-title">Photos des Débuts</h5>
                            <p class="card-text">Collection photographique des premières années du SYNEM (1990-1995).</p>
                            <a href="#" class="btn btn-primary">Voir l'Album</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm">
                        <img src="{{ asset('template-siteweb/asset/img/gallery-2.jpg') }}" class="card-img-top" alt="Archive Congrès">
                        <div class="card-body">
                            <h5 class="card-title">Congrès Mémorables</h5>
                            <p class="card-text">Documents et photos des congrès nationaux depuis 1995.</p>
                            <a href="#" class="btn btn-primary">Explorer</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm">
                        <img src="{{ asset('template-siteweb/asset/img/gallery-3.jpg') }}" class="card-img-top" alt="Archive Accords">
                        <div class="card-body">
                            <h5 class="card-title">Accords Signés</h5>
                            <p class="card-text">Collection numérique des accords et conventions signés.</p>
                            <a href="#" class="btn btn-primary">Consulter</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
<!-- Archives End -->
@endsection