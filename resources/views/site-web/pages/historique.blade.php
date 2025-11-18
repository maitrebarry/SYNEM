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
            <img src="{{ asset('template-siteweb/asset/img/historique-demo.jpg') }}" alt="Historique SYNEM" class="img-fluid rounded shadow">
        </div>
        <div class="col-lg-6">
            <h1 class="mb-3 text-primary">Historique</h1>
            <p class="lead mb-4">Depuis sa création, le SYNEM a marqué l’histoire de l’éducation au Mali par des actions fortes : organisation de congrès, négociations avec l’État, lancement de programmes de formation, et digitalisation des services pour ses membres.</p>
            <ul class="list-unstyled mb-4">
                <li class="mb-2"><i class="fa fa-check-circle text-primary me-2"></i>Organisation de congrès nationaux</li>
                <li class="mb-2"><i class="fa fa-check-circle text-primary me-2"></i>Négociations et accords historiques</li>
                <li class="mb-2"><i class="fa fa-check-circle text-primary me-2"></i>Programmes de formation continue</li>
                <li class="mb-2"><i class="fa fa-check-circle text-primary me-2"></i>Digitalisation des services</li>
            </ul>
        </div>
    </div>
</div>
                        <li>Premier bureau élu</li>
                        <li>Adoption des statuts initiaux</li>
                    </ul>
                </div>
            </div>

            <!-- 1992 -->
            <div class="history-item">
                <div class="history-year">1992</div>
                <div class="history-content">
                    <h3>Premières Négociations</h3>
                    <p>Engagement des premières négociations collectives avec le gouvernement pour l'amélioration des conditions salariales des enseignants.</p>
                </div>
            </div>

            <!-- 1995 -->
            <div class="history-item">
                <div class="history-year">1995</div>
                <div class="history-content">
                    <h3>Premier Congrès National</h3>
                    <p>Organisation du premier congrès national avec la participation de délégués de toutes les régions du Mali. Adoption des statuts définitifs et élection du nouveau bureau.</p>
                </div>
            </div>

            <!-- 2000 -->
            <div class="history-item">
                <div class="history-year">2000</div>
                <div class="history-content">
                    <h3>Lancement des Programmes de Formation</h3>
                    <p>Mise en place du premier programme national de formation continue pour les enseignants, marquant le début d'un engagement fort pour le développement professionnel.</p>
                </div>
            </div>

            <!-- 2005 -->
            <div class="history-item">
                <div class="history-year">2005</div>
                <div class="history-content">
                    <h3>Expansion Nationale</h3>
                    <p>Le SYNEM étend sa présence à toutes les régions du Mali, avec l'ouverture de bureaux régionaux et la mise en place de structures décentralisées.</p>
                </div>
            </div>

            <!-- 2010 -->
            <div class="history-item">
                <div class="history-year">2010</div>
                <div class="history-content">
                    <h3>Accord Historique</h3>
                    <p>Signature d'un accord historique avec le gouvernement pour l'amélioration des conditions de travail, la revalorisation salariale et la protection sociale des enseignants.</p>
                </div>
            </div>

            <!-- 2015 -->
            <div class="history-item">
                <div class="history-year">2015</div>
                <div class="history-content">
                    <h3>25ème Anniversaire</h3>
                    <p>Célébration des 25 ans d'existence avec l'organisation d'un congrès extraordinaire et le lancement de nouveaux programmes sociaux pour les membres.</p>
                </div>
            </div>

            <!-- 2020 -->
            <div class="history-item">
                <div class="history-year">2020</div>
                <div class="history-content">
                    <h3>Digitalisation et Modernisation</h3>
                    <p>Lancement de la plateforme numérique du SYNEM pour améliorer la communication avec les membres et moderniser les services syndicaux.</p>
                </div>
            </div>

            <!-- 2024 -->
            <div class="history-item">
                <div class="history-year">2024</div>
                <div class="history-content">
                    <h3>Nouvelle Vision 2030</h3>
                    <p>Adoption de la nouvelle vision stratégique 2030 avec un focus sur l'innovation éducative, la formation numérique et le renforcement du dialogue social.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- History End -->

<!-- Milestones Start -->
<div class="container-fluid py-5 bg-light">
    <div class="container py-5">
        <div class="section-title text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px;">
            <h1 class="mb-0">Nos Réalisations</h1>
        </div>
        <div class="row g-5">
            <!-- Réalisation 1 -->
            <div class="col-lg-3 col-md-6">
                <div class="milestone-card">
                    <div class="milestone-number">15K+</div>
                    <p>Enseignants Membres</p>
                </div>
            </div>
            <!-- Réalisation 2 -->
            <div class="col-lg-3 col-md-6">
                <div class="milestone-card">
                    <div class="milestone-number">34</div>
                    <p>Années de Service</p>
                </div>
            </div>
            <!-- Réalisation 3 -->
            <div class="col-lg-3 col-md-6">
                <div class="milestone-card">
                    <div class="milestone-number">500+</div>
                    <p>Formations Organisées</p>
                </div>
            </div>
            <!-- Réalisation 4 -->
            <div class="col-lg-3 col-md-6">
                <div class="milestone-card">
                    <div class="milestone-number">8</div>
                    <p>Régions Couvertes</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Milestones End -->

<!-- Archives Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="section-title text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px;">
            <h1 class="mb-0">Archives Historiques</h1>
        </div>
        <div class="row g-5">
            <!-- Archive 1 -->
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
            <!-- Archive 2 -->
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
            <!-- Archive 3 -->
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
        </div>
    </div>
</div>
<!-- Archives End -->
@endsection