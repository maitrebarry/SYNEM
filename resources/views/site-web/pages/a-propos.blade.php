@extends('layouts.site')

@section('title', 'À Propos - SYNEM')

@section('styles')
<style>
    .timeline {
        position: relative;
        padding: 20px 0;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 50%;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #007bff;
        transform: translateX(-50%);
    }
    
    .timeline-item {
        margin-bottom: 40px;
        position: relative;
    }
    
    .timeline-content {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        position: relative;
        width: 45%;
    }
    
    .timeline-item:nth-child(odd) .timeline-content {
        margin-left: auto;
    }
    
    .timeline-item:nth-child(even) .timeline-content {
        margin-right: auto;
    }
    
    .timeline-content::before {
        content: '';
        position: absolute;
        top: 20px;
        width: 20px;
        height: 20px;
        background: #007bff;
        border-radius: 50%;
    }
    
    .timeline-item:nth-child(odd) .timeline-content::before {
        left: -30px;
    }
    
    .timeline-item:nth-child(even) .timeline-content::before {
        right: -30px;
    }
    
    .stats-box {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
        padding: 30px;
        border-radius: 10px;
        text-align: center;
        margin-bottom: 30px;
    }
    
    .stats-number {
        font-size: 3rem;
        font-weight: bold;
        margin-bottom: 10px;
    }

    /* Team card: keep card dimensions consistent regardless of image size */
    .team-item {
        display: flex;
        flex-direction: column;
        height: 360px;
    }
    .team-item .team-img {
        height: 200px;
        overflow: hidden;
    }
    .team-item .team-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .team-item .text-center {
        padding-top: 16px;
        padding-bottom: 20px;
        flex: 1 0 auto;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
</style>
@endsection

@section('content')

@php
    $about = \App\Models\AboutPageContent::first();
@endphp

<!-- Présentation SYNEM ergonomique -->
<div class="container py-5">
    <div class="row align-items-center g-5">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <img src="{{ asset($about && $about->image ? 'storage/about/' . $about->image : 'template-siteweb/asset/img/ens10.jpeg') }}" alt="SYNEM équipe" class="img-fluid rounded shadow">
        </div>
        <div class="col-lg-6">
            <h1 class="mb-3 text-primary">À propos du SYNEM</h1>
            <p class="lead mb-4">{{ $about && $about->about_text ? $about->about_text : 'Le Syndicat National des Enseignants du Mali (SYNEM) est une organisation professionnelle fondée en 1990, engagée dans la défense des droits, la valorisation du métier d’enseignant et la promotion d’une éducation de qualité pour tous. Le SYNEM rassemble plus de 15 000 membres à travers le pays et œuvre pour le dialogue social et la formation continue.' }}</p>
            <ul class="list-unstyled mb-4">
                <li class="mb-2"><i class="fa fa-check-circle text-primary me-2"></i>Défense des intérêts moraux et matériels</li>
                <li class="mb-2"><i class="fa fa-check-circle text-primary me-2"></i>Dialogue social et négociation</li>
                <li class="mb-2"><i class="fa fa-check-circle text-primary me-2"></i>Formation continue des enseignants</li>
                <li class="mb-2"><i class="fa fa-check-circle text-primary me-2"></i>Promotion d’une éducation inclusive et équitable</li>
            </ul>
            <div class="d-flex align-items-center">
                <div class="bg-primary d-flex align-items-center justify-content-center rounded" style="width: 60px; height: 60px;">
                    <i class="fa fa-users text-white"></i>
                </div>
                <div class="ps-3">
                    <h4 class="text-primary mb-1">{{ $about && $about->stats_members ? $about->stats_members : '15 000+' }}</h4>
                    <p class="mb-0">Enseignants membres</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-3 col-md-6">
                <div class="stats-box">
                    <div class="stats-number">{{ $about && $about->stats_members ? $about->stats_members : '15K+' }}</div>
                    <p>Membres Actifs</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stats-box">
                    <div class="stats-number">{{ $about && $about->stats_years ? $about->stats_years : '34' }}</div>
                    <p>Années d'Expérience</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stats-box">
                    <div class="stats-number">{{ $about && $about->stats_regions ? $about->stats_regions : '8' }}</div>
                    <p>Régions Couvertes</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stats-box">
                    <div class="stats-number">{{ $about && $about->stats_trainings ? $about->stats_trainings : '500+' }}</div>
                    <p>Formations Organisées</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Statistics End -->

<!-- Timeline Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="section-title text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px;">
            <h1 class="mb-0">Notre Histoire en Dates</h1>
        </div>
        <div class="timeline">
            @if($about && is_array($about->timeline) && count($about->timeline))
                @foreach($about->timeline as $event)
                    <div class="timeline-item">
                        <div class="timeline-content">
                            <h3>{{ $event['year'] ?? '' }}</h3>
                            <h4>{{ $event['title'] ?? '' }}</h4>
                            <p>{{ $event['text'] ?? '' }}</p>
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Événement 1 -->
                <div class="timeline-item">
                    <div class="timeline-content">
                        <h3>1990</h3>
                        <h4>Création du SYNEM</h4>
                        <p>Fondation officielle du Syndicat National des Enseignants du Mali avec 500 membres fondateurs.</p>
                    </div>
                </div>
                <!-- Événement 2 -->
                <div class="timeline-item">
                    <div class="timeline-content">
                        <h3>1995</h3>
                        <h4>Premier Congrès National</h4>
                        <p>Organisation du premier congrès national et adoption des statuts définitifs.</p>
                    </div>
                </div>
                <!-- Événement 3 -->
                <div class="timeline-item">
                    <div class="timeline-content">
                        <h3>2000</h3>
                        <h4>Programme de Formation</h4>
                        <p>Lancement du premier programme national de formation continue pour les enseignants.</p>
                    </div>
                </div>
                <!-- Événement 4 -->
                <div class="timeline-item">
                    <div class="timeline-content">
                        <h3>2010</h3>
                        <h4>Accord Historique</h4>
                        <p>Signature d'un accord historique avec le gouvernement pour l'amélioration des conditions enseignantes.</p>
                    </div>
                </div>
                <!-- Événement 5 -->
                <div class="timeline-item">
                    <div class="timeline-content">
                        <h3>2020</h3>
                        <h4>Digitalisation</h4>
                        <p>Lancement de la plateforme numérique pour une meilleure communication avec les membres.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
<!-- Timeline End -->

<!-- Team Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="section-title text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px;">
            <h1 class="mb-0">Notre Bureau Exécutif</h1>
        </div>
        <div class="row g-5">
            @if($about && is_array($about->team) && count($about->team))
                @foreach($about->team as $member)
                    <div class="col-lg-4 col-md-6">
                        <div class="team-item bg-light rounded overflow-hidden">
                            <div class="team-img position-relative overflow-hidden">
                                @if(!empty($member['photo']))
                                    <img class="img-fluid w-100" src="{{ asset('storage/team/' . $member['photo']) }}" alt="{{ $member['name'] ?? '' }}">
                                @else
                                    <img class="img-fluid w-100" src="{{ asset('template-siteweb/asset/img/team-1.jpg') }}" alt="{{ $member['name'] ?? '' }}">
                                @endif
                            </div>
                            <div class="text-center py-4">
                                <h4 class="text-primary">{{ $member['name'] ?? '' }}</h4>
                                <p class="text-uppercase m-0">{{ $member['role'] ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Membre 1 -->
                <div class="col-lg-4 col-md-6">
                    <div class="team-item bg-light rounded overflow-hidden">
                        <div class="team-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="{{ asset('template-siteweb/asset/img/team-1.jpg') }}" alt="Président">
                        </div>
                        <div class="text-center py-4">
                            <h4 class="text-primary">Moussa Diallo</h4>
                            <p class="text-uppercase m-0">Président National</p>
                        </div>
                    </div>
                </div>
                <!-- Membre 2 -->
                <div class="col-lg-4 col-md-6">
                    <div class="team-item bg-light rounded overflow-hidden">
                        <div class="team-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="{{ asset('template-siteweb/asset/img/team-2.jpg') }}" alt="Secrétaire Général">
                        </div>
                        <div class="text-center py-4">
                            <h4 class="text-primary">Aminata Traoré</h4>
                            <p class="text-uppercase m-0">Secrétaire Générale</p>
                        </div>
                    </div>
                </div>
                <!-- Membre 3 -->
                <div class="col-lg-4 col-md-6">
                    <div class="team-item bg-light rounded overflow-hidden">
                        <div class="team-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="{{ asset('template-siteweb/asset/img/team-3.jpg') }}" alt="Trésorier">
                        </div>
                        <div class="text-center py-4">
                            <h4 class="text-primary">Ibrahim Keita</h4>
                            <p class="text-uppercase m-0">Trésorier National</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
<!-- Team End -->


@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Animation pour la timeline
        $('.timeline-item').each(function(i) {
            $(this).delay(i * 300).animate({
                opacity: 1,
                marginTop: 0
            }, 1000);
        });
    });
</script>
@endsection