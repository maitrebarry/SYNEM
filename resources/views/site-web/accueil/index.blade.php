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
</style>
@endsection

@section('content')
    <!-- Carousel Start -->
    <div class="container-fluid p-0" style="margin-bottom: 90px;">
        <div id="header-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                @if($content && $content->carouselImages && count($content->carouselImages))
                    @foreach($content->carouselImages as $key => $img)
                        <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                            <img class="w-100" src="{{ asset('storage/carousel/' . $img->file) }}" alt="Carrousel {{ $key+1 }}">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 900px;">
                                    <h4 class="text-white text-uppercase mb-md-3">{{ $content->carousel_title ?? 'Syndicat National' }}</h4>
                                    <h1 class="display-1 text-white mb-md-4">{{ $content->carousel_subtitle ?? 'Défense des Droits des Enseignants' }}</h1>
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
                                         SELECT * FROM homepage_contents;                                        SELECT * FROM homepage_contents;                       <a href="{{ route('a-propos') }}" class="btn btn-primary py-md-3 px-md-5 mt-2">En savoir plus</a>
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
            <h1 class="display-4 text-uppercase text-center mb-5">Nos Domaines d'Intervention</h1>
            <div class="row">
                <!-- Défense des droits -->
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
                <!-- Formation -->
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
                <!-- Négociation -->
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
                @if(!empty($content->compte_rendu_title) && !empty($content->compte_rendu_content))
                    <div class="col-lg-4 col-md-6 mb-2">
                        <div class="rent-item mb-4">
                            @php
                                $crImages = is_array($content->compte_rendu_images) ? $content->compte_rendu_images : (json_decode($content->compte_rendu_images, true) ?: []);
                                $crImage = !empty($crImages) ? $crImages[0] : null;
                            @endphp
                            @if($crImage)
                                <img class="img-fluid mb-4" src="{{ asset('storage/compte_rendu/' . $crImage) }}" alt="Compte Rendu">
                            @endif
                            <h4 class="text-uppercase mb-4">{{ $content->compte_rendu_title }}</h4>
                            <button class="btn btn-primary px-3" data-toggle="modal" data-target="#compteRenduModal">Lire la suite</button>
                        </div>
                    </div>
                @else
                    <!-- Static Fallback Data -->
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
                            <img class="img-fluid mb-4" src="{{ asset('template-siteweb/asset/img/ens12.jpg') }}" alt="Actualité 2">
                            <h4 class="text-uppercase mb-4">Formation Pédagogique</h4>
                            <p class="mb-4">Nouveau programme de formation continue pour les enseignants du primaire...</p>
                            <a class="btn btn-primary px-3" href="#">Lire la suite</a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-2">
                        <div class="rent-item mb-4">
                            <img class="img-fluid mb-4" src="{{ asset('template-siteweb/asset/img/accord.jpg') }}" alt="Actualité 3">
                            <h4 class="text-uppercase mb-4">Accords Salariaux</h4>
                            <p class="mb-4">Signature d'un nouvel accord salarial avec le ministère de l'Éducation...</p>
                            <a class="btn btn-primary px-3" href="#">Lire la suite</a>
                        </div>
                    </div>
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

    <!-- Documents Administratifs Start -->
    <div class="container-fluid py-5">
        <div class="container pt-5 pb-3">
            <h1 class="display-1 text-primary text-center">04</h1>
            <h1 class="display-4 text-uppercase text-center mb-5">
                {{ ($content && $content->documents_title) ? $content->documents_title : 'Documents Administratifs' }}
            </h1>
            <div class="row">
                @if($content && $content->documents && count($content->documents))
                    @foreach($content->documents as $doc)
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
                    @endforeach
                @else
                    <!-- Fallback contenu statique -->
                    <div class="col-lg-4 col-md-6 mb-4 document-item">
                        <div class="card document-card h-100 border-0 shadow-sm">
                            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                <span class="badge badge-light">Congrès</span>
                                <span class="badge badge-warning">Nouveau</span>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-file-pdf text-danger fa-2x mr-3"></i>
                                    <div>
                                        <h5 class="card-title mb-1">Compte-rendu Congrès 2024</h5>
                                        <small class="text-muted">Publié le 15 Jan 2024</small>
                                    </div>
                                </div>
                                <p class="card-text">Rapport complet des résolutions et décisions du congrès annuel 2024.</p>
                                <div class="document-info">
                                    <small class="text-muted">
                                        <i class="fas fa-file-alt mr-1"></i>PDF - 2.4 MB
                                    </small>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <a href="{{ asset('storage/documents/congres-2024.pdf') }}" class="btn btn-primary btn-sm" download>
                                    <i class="fas fa-download mr-2"></i>Télécharger
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Bouton Voir Plus -->
            <div class="text-center mt-4">
                <a href="#" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-folder-open mr-2"></i>Voir tous les documents
                </a>
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

    <div class="modal fade" id="documentModal3" tabindex="-1" role="dialog" aria-labelledby="documentModal3Label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="documentModal3Label">Décision N°2024-001</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fas fa-file-pdf text-danger fa-5x mb-3"></i>
                        <p>Ce document est disponible en téléchargement.</p>
                        <p><strong>Taille :</strong> 856 KB</p>
                        <a href="{{ asset('storage/documents/decision-2024-001.pdf') }}" class="btn btn-primary" download>
                            <i class="fas fa-download mr-2"></i>Télécharger le PDF
                        </a>
                    </div>
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

        // Compter les téléchargements (exemple)
        $('a[download]').click(function() {
            let docTitle = $(this).closest('.document-card').find('.card-title').text();
            console.log('Document téléchargé : ' + docTitle);
            // Ici vous pouvez envoyer une requête AJAX pour tracker les téléchargements
        });
    });
</script>
@endsection