@extends('layouts.site')

@section('title', 'Contact - SYNEM')

@section('styles')
<style>
    .contact-info {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        margin-bottom: 30px;
        transition: transform 0.3s ease;
    }
    
    .contact-info:hover {
        transform: translateY(-5px);
    }
    
    .contact-icon {
        width: 60px;
        height: 60px;
        background: #007bff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }
    
    .contact-icon i {
        font-size: 1.5rem;
        color: white;
    }
    
    .map-container {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }
</style>
@endsection

@section('content')
@php
    if ($carousels->isNotEmpty()) {
        $carouselImages = $carousels->map(fn($c) => asset('storage/contact/carousel/' . $c->image))->toArray();
        $carouselCaptions = $carousels->map(fn($c) => $c->caption ?: '')->toArray();
    } else {
        $carouselImages = [
            asset('template-siteweb/asset/img/gallery-6.jpg'),
            asset('template-siteweb/asset/img/gallery-2.jpg'),
            asset('template-siteweb/asset/img/gallery-3.jpg')
        ];
        $carouselCaptions = [
            'Une équipe à votre écoute',
            'Ensemble, construisons l avenir de l éducation',
            'Votre voix compte, contactez-nous'
        ];
    }
@endphp
<!-- Page Header Start -->
@include('site-web.partials.page-carousel', [
    'pageTitle' => 'Contactez-Nous',
    'breadcrumb' => 'Contact',
    'images' => $carouselImages,
    'captions' => $carouselCaptions
])
<!-- Page Header End -->

<!-- Contact Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="section-title text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px;">
            <h1 class="mb-0">Restons en Contact</h1>
            <p>Nous sommes à votre écoute pour toute question ou préoccupation</p>
            <div class="mt-3">
                <button class="btn btn-outline-primary" data-toggle="modal" data-target="#membershipModal">Je suis militant · Soumettre mes justificatifs</button>
            </div>
        </div>
        
        <div class="row g-5 mb-5">
            <!-- Information 1 -->
            @if($infos->isNotEmpty())
                @foreach($infos as $info)
                    <div class="col-lg-4 col-md-6">
                        <div class="contact-info text-center">
                            <div class="contact-icon mx-auto">
                                <i class="fa fa-{{ $info->type == 'address' ? 'map-marker-alt' : ($info->type == 'phone' ? 'phone-alt' : 'envelope') }}"></i>
                            </div>
                            <h4>{{ $info->label ?: ucfirst($info->type) }}</h4>
                            <p>{!! nl2br(e($info->value)) !!}</p>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-lg-4 col-md-6">
                    <div class="contact-info text-center">
                        <div class="contact-icon mx-auto">
                            <i class="fa fa-map-marker-alt"></i>
                        </div>
                        <h4>Notre Adresse</h4>
                        <p>Bamako, Mali<br>Rue 123, Quartier du Fleuve</p>
                    </div>
                </div>
                <!-- Information 2 -->
                <div class="col-lg-4 col-md-6">
                    <div class="contact-info text-center">
                        <div class="contact-icon mx-auto">
                            <i class="fa fa-phone-alt"></i>
                        </div>
                        <h4>Téléphone</h4>
                        <p>+223 92190993<br>+223 76543210</p>
                    </div>
                </div>
                <!-- Information 3 -->
                <div class="col-lg-4 col-md-6">
                    <div class="contact-info text-center">
                        <div class="contact-icon mx-auto">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <h4>Email</h4>
                        <p>contact@synem.ml<br>info@synem.ml</p>
                    </div>
                </div>
            @endif
        </div>
        
        <div class="row g-5">
            <!-- Formulaire de Contact -->
            <div class="col-lg-7">
                <div class="bg-light rounded p-5">
                    <form id="contactForm">
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <input type="text" class="form-control border-0" placeholder="Votre Nom" style="height: 55px;">
                            </div>
                            <div class="col-12 col-sm-6">
                                <input type="email" class="form-control border-0" placeholder="Votre Email" style="height: 55px;">
                            </div>
                            <div class="col-12">
                                <input type="text" class="form-control border-0" placeholder="Sujet" style="height: 55px;">
                            </div>
                            <div class="col-12">
                                <textarea class="form-control border-0" rows="5" placeholder="Message"></textarea>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="submit">Envoyer le Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Carte et Horaires -->
            <div class="col-lg-5">
                <div class="map-container mb-4">
                    @if($map)
                        {!! $map->value !!}
                    @else
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387190.279889365!2d-8.002889!3d12.639232!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xec173b7114984000%3A0x53825d6a9b4b8b0!2zQmFtYWtvLCBNYWxp!5e0!3m2!1sfr!2sml!4v1690000000000!5m2!1sfr!2sml" 
                                width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    @endif
                </div>
                
                <div class="bg-light rounded p-4">
                    <h4 class="mb-4">Heures d'Ouverture</h4>
                    @if($hours->isNotEmpty())
                        @foreach($hours as $hour)
                            <div class="d-flex justify-content-between {{ !$loop->last ? 'border-bottom' : '' }} py-2">
                                <h6 class="mb-0">{{ $hour->day }}</h6>
                                <p class="mb-0">{{ $hour->closed ? 'Fermé' : ($hour->open . ' - ' . $hour->close) }}</p>
                            </div>
                        @endforeach
                    @else
                        <div class="d-flex justify-content-between border-bottom py-2">
                            <h6 class="mb-0">Lundi - Vendredi</h6>
                            <p class="mb-0">8h00 - 17h00</p>
                        </div>
                        <div class="d-flex justify-content-between border-bottom py-2">
                            <h6 class="mb-0">Samedi</h6>
                            <p class="mb-0">9h00 - 13h00</p>
                        </div>
                        <div class="d-flex justify-content-between py-2">
                            <h6 class="mb-0">Dimanche</h6>
                            <p class="mb-0">Fermé</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact End -->

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
                                                <p class="text-muted small mt-2">Utilisez votre caméra pour photographier votre carte de membre</p>
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

<div class="container py-5">
    <div class="row align-items-center g-5">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <a data-pin-do="embedPin" data-pin-width="large" href="https://fr.pinterest.com/pin/197947346118532670/"></a>
            <script async defer src="//assets.pinterest.com/js/pinit.js"></script>
        </div>
        <div class="col-lg-6">
            <h1 class="mb-3 text-primary">Contact</h1>
            <p class="lead mb-4">Adresse : Bamako, Mali<br>Téléphone : +223 20 00 00 00<br>Email : contact@synem.ml<br>Le SYNEM est à l’écoute de tous les enseignants et partenaires pour toute question ou demande d’information.</p>
            <ul class="list-unstyled mb-4">
                <li class="mb-2"><i class="fa fa-check-circle text-primary me-2"></i>Accueil administratif</li>
                <li class="mb-2"><i class="fa fa-check-circle text-primary me-2"></i>Réponse rapide par email</li>
                <li class="mb-2"><i class="fa fa-check-circle text-primary me-2"></i>Support pour les enseignants</li>
                <li class="mb-2"><i class="fa fa-check-circle text-primary me-2"></i>Partenariats institutionnels</li>
            </ul>
        </div>
    </div>
</div>

<!-- FAQ Section - Full Width -->
<div class="container-fluid py-5 bg-light">
    <div class="container">
        <div class="section-title text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px;">
            <h2 class="mb-0 text-primary">Questions Fréquentes</h2>
            <p>Trouvez rapidement les réponses à vos questions les plus courantes</p>
        </div>

        <div class="row g-4">
            <!-- Card Aide Juridique -->
            <div class="col-12">
                <div class="card h-100 border-primary shadow-sm">
                    <div class="card-body text-center">
                        <button type="button" class="btn btn-primary btn-lg w-100 py-3 shadow-lg faq-btn" data-bs-toggle="collapse" data-bs-target="#legalAidCollapse" aria-expanded="false" aria-controls="legalAidCollapse" style="background: linear-gradient(45deg, #007bff, #0056b3); border: none; transition: all 0.3s ease;">
                            <i class="fa fa-gavel me-2"></i>
                            <strong >Comment obtenir de l'aide juridique ?</strong>
                            <i class="fa fa-chevron-down ms-2 toggle-icon"></i>
                        </button>
                        <div class="collapse mt-3" id="legalAidCollapse">
                            <div class="card border-primary shadow">
                                <div class="card-body">
                                    <div class="mb-4">
                                        <h4 class="text-primary mb-3">Consultation juridique gratuite</h4>
                                        <p class="lead">Tous les membres actifs du SYNEM peuvent bénéficier de consultations juridiques gratuites sur :</p>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item"><i class="fa fa-check-circle text-success me-2"></i>Droits et obligations des enseignants</li>
                                            <li class="list-group-item"><i class="fa fa-check-circle text-success me-2"></i>Problèmes contractuels</li>
                                            <li class="list-group-item"><i class="fa fa-check-circle text-success me-2"></i>Contentieux administratifs</li>
                                            <li class="list-group-item"><i class="fa fa-check-circle text-success me-2"></i>Conseils en carrière</li>
                                        </ul>
                                    </div>

                                    <div class="mb-4">
                                        <h4 class="text-primary mb-3">Comment prendre rendez-vous ?</h4>
                                        <p>Pour bénéficier de l'assistance juridique :</p>
                                        <ol class="list-group list-group-numbered">
                                            <li class="list-group-item">Contactez votre section régionale SYNEM</li>
                                            <li class="list-group-item">Présentez votre carte de membre</li>
                                            <li class="list-group-item">Expliquez brièvement votre situation</li>
                                            <li class="list-group-item">Un rendez-vous vous sera fixé dans les 48h</li>
                                        </ol>
                                    </div>

                                    <div class="mb-4">
                                        <h4 class="text-primary mb-3">Domaines d'intervention</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6 class="text-info"><i class="fa fa-briefcase me-2"></i>Droit du travail</h6>
                                                <ul class="list-unstyled">
                                                    <li><i class="fa fa-angle-right text-muted me-2"></i>Contrats de travail</li>
                                                    <li><i class="fa fa-angle-right text-muted me-2"></i>Licenciements</li>
                                                    <li><i class="fa fa-angle-right text-muted me-2"></i>Conditions de travail</li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <h6 class="text-info"><i class="fa fa-building me-2"></i>Droit administratif</h6>
                                                <ul class="list-unstyled">
                                                    <li><i class="fa fa-angle-right text-muted me-2"></i>Mutations</li>
                                                    <li><i class="fa fa-angle-right text-muted me-2"></i>Avancements</li>
                                                    <li><i class="fa fa-angle-right text-muted me-2"></i>Retraites</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bg-light p-3 rounded">
                                        <h5 class="text-primary mb-3">Contact Service Juridique</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="mb-2"><i class="fa fa-envelope text-primary me-2"></i><strong>Email:</strong> juridique@synem.ml</p>
                                                <p class="mb-2"><i class="fa fa-phone text-primary me-2"></i><strong>Téléphone:</strong> +223 92 19 09 93</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary me-2"></i><strong>Adresse:</strong> Siège national SYNEM, Bamako</p>
                                                <p class="mb-0"><i class="fa fa-clock text-primary me-2"></i><strong>Horaires:</strong> Lundi - Vendredi, 8h-17h</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <!-- Card Bureaux Régionaux -->
        <div  class="row g-4">
            <div class="col-12">
                <div class="card h-100 border-success shadow-sm">
                    <div class="card-body text-center">
                        <button type="button" class="btn btn-success btn-lg w-100 py-3 shadow-lg faq-btn" data-bs-toggle="collapse" data-bs-target="#regionalOfficesCollapse" aria-expanded="false" aria-controls="regionalOfficesCollapse" style="background: linear-gradient(45deg, #28a745, #1e7e34); border: none; transition: all 0.3s ease;">
                            <i class="fa fa-map-marker-alt me-2"></i>
                            <strong>Où se trouvent vos bureaux régionaux ?</strong>
                            <i class="fa fa-chevron-down ms-2 toggle-icon"></i>
                        </button>
                        <div class="collapse mt-3" id="regionalOfficesCollapse">
                            <div class="card border-success shadow">
                                <div class="card-body">
                                    <div class="alert alert-info mb-4">
                                        <h6><i class="fa fa-info-circle me-2"></i>Information importante</h6>
                                        <p class="mb-0">Le SYNEM est présent dans toutes les régions administratives du Mali pour être au plus près de ses membres. Pour toute demande spécifique ou rendez-vous, contactez d'abord votre section locale.</p>
                                    </div>

                                    <div class="row g-3">
                                        <!-- Bamako -->
                                        <div class="col-lg-6 col-xl-4">
                                            <div class="card h-100 border-primary">
                                                <div class="card-header bg-primary text-white text-center">
                                                    <i class="fa fa-building fa-2x mb-2"></i>
                                                    <h6 class="mb-0">Siège National</h6>
                                                    <small>Bamako - District</small>
                                                </div>
                                                <div class="card-body text-center">
                                                    <p class="card-text mb-3">
                                                        <i class="fa fa-map-marker-alt text-primary me-1"></i>Rue de l'Indépendance, Bamako<br>
                                                        <i class="fa fa-phone text-primary me-1"></i>+223 20 00 00 00<br>
                                                        <i class="fa fa-envelope text-primary me-1"></i>bamako@synem.ml
                                                    </p>
                                                    <a href="tel:+22320000000" class="btn btn-outline-primary btn-sm">Contacter</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Kayes -->
                                        <div class="col-lg-6 col-xl-4">
                                            <div class="card h-100 border-success">
                                                <div class="card-header bg-success text-white text-center">
                                                    <i class="fa fa-building fa-2x mb-2"></i>
                                                    <h6 class="mb-0">Région de Kayes</h6>
                                                </div>
                                                <div class="card-body text-center">
                                                    <p class="card-text mb-3">
                                                        <i class="fa fa-map-marker-alt text-success me-1"></i>Kayes, Quartier administratif<br>
                                                        <i class="fa fa-phone text-success me-1"></i>+223 21 00 00 00<br>
                                                        <i class="fa fa-envelope text-success me-1"></i>kayes@synem.ml
                                                    </p>
                                                    <a href="tel:+22321000000" class="btn btn-outline-success btn-sm">Contacter</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Sikasso -->
                                        <div class="col-lg-6 col-xl-4">
                                            <div class="card h-100 border-info">
                                                <div class="card-header bg-info text-white text-center">
                                                    <i class="fa fa-building fa-2x mb-2"></i>
                                                    <h6 class="mb-0">Région de Sikasso</h6>
                                                </div>
                                                <div class="card-body text-center">
                                                    <p class="card-text mb-3">
                                                        <i class="fa fa-map-marker-alt text-info me-1"></i>Sikasso, Centre-ville<br>
                                                        <i class="fa fa-phone text-info me-1"></i>+223 22 00 00 00<br>
                                                        <i class="fa fa-envelope text-info me-1"></i>sikasso@synem.ml
                                                    </p>
                                                    <a href="tel:+22322000000" class="btn btn-outline-info btn-sm">Contacter</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Ségou -->
                                        <div class="col-lg-6 col-xl-4">
                                            <div class="card h-100 border-warning">
                                                <div class="card-header bg-warning text-dark text-center">
                                                    <i class="fa fa-building fa-2x mb-2"></i>
                                                    <h6 class="mb-0">Région de Ségou</h6>
                                                </div>
                                                <div class="card-body text-center">
                                                    <p class="card-text mb-3">
                                                        <i class="fa fa-map-marker-alt text-warning me-1"></i>Ségou, Boulevard de l'Indépendance<br>
                                                        <i class="fa fa-phone text-warning me-1"></i>+223 23 00 00 00<br>
                                                        <i class="fa fa-envelope text-warning me-1"></i>segou@synem.ml
                                                    </p>
                                                    <a href="tel:+22323000000" class="btn btn-outline-warning btn-sm">Contacter</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Mopti -->
                                        <div class="col-lg-6 col-xl-4">
                                            <div class="card h-100 border-danger">
                                                <div class="card-header bg-danger text-white text-center">
                                                    <i class="fa fa-building fa-2x mb-2"></i>
                                                    <h6 class="mb-0">Région de Mopti</h6>
                                                </div>
                                                <div class="card-body text-center">
                                                    <p class="card-text mb-3">
                                                        <i class="fa fa-map-marker-alt text-danger me-1"></i>Mopti, Quartier Komoguel<br>
                                                        <i class="fa fa-phone text-danger me-1"></i>+223 24 00 00 00<br>
                                                        <i class="fa fa-envelope text-danger me-1"></i>mopti@synem.ml
                                                    </p>
                                                    <a href="tel:+22324000000" class="btn btn-outline-danger btn-sm">Contacter</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tombouctou -->
                                        <div class="col-lg-6 col-xl-4">
                                            <div class="card h-100 border-secondary">
                                                <div class="card-header bg-secondary text-white text-center">
                                                    <i class="fa fa-building fa-2x mb-2"></i>
                                                    <h6 class="mb-0 text-white">Région de Tombouctou</h6>
                                                </div>
                                                <div class="card-body text-center">
                                                    <p class="card-text mb-3">
                                                        <i class="fa fa-map-marker-alt text-secondary me-1"></i>Tombouctou, Centre culturel<br>
                                                        <i class="fa fa-phone text-secondary me-1"></i>+223 25 00 00 00<br>
                                                        <i class="fa fa-envelope text-secondary me-1"></i>tombouctou@synem.ml
                                                    </p>
                                                    <a href="tel:+22325000000" class="btn btn-outline-secondary btn-sm">Contacter</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Gao -->
                                        <div class="col-lg-6 col-xl-4">
                                            <div class="card h-100 border-dark">
                                                <div class="card-header bg-dark text-white text-center">
                                                    <i class="fa fa-building fa-2x mb-2"></i>
                                                    <h6 class="mb-0 text-white">Région de Gao</h6>
                                                </div>
                                                <div class="card-body text-center">
                                                    <p class="card-text mb-3">
                                                        <i class="fa fa-map-marker-alt text-dark me-1"></i>Gao, Boulevard de l'Indépendance<br>
                                                        <i class="fa fa-phone text-dark me-1"></i>+223 26 00 00 00<br>
                                                        <i class="fa fa-envelope text-dark me-1"></i>gao@synem.ml
                                                    </p>
                                                    <a href="tel:+22326000000" class="btn btn-outline-dark btn-sm">Contacter</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Kidal -->
                                        <div class="col-lg-6 col-xl-4">
                                            <div class="card h-100 border-primary">
                                                <div class="card-header bg-primary text-white text-center">
                                                    <i class="fa fa-building fa-2x mb-2"></i>
                                                    <h6 class="mb-0">Région de Kidal</h6>
                                                </div>
                                                <div class="card-body text-center">
                                                    <p class="card-text mb-3">
                                                        <i class="fa fa-map-marker-alt text-primary me-1"></i>Kidal, Centre administratif<br>
                                                        <i class="fa fa-phone text-primary me-1"></i>+223 27 00 00 00<br>
                                                        <i class="fa fa-envelope text-primary me-1"></i>kidal@synem.ml
                                                    </p>
                                                    <a href="tel:+22327000000" class="btn btn-outline-primary btn-sm">Contacter</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Koulikoro -->
                                        <div class="col-lg-6 col-xl-4">
                                            <div class="card h-100 border-success">
                                                <div class="card-header bg-success text-white text-center">
                                                    <i class="fa fa-building fa-2x mb-2"></i>
                                                    <h6 class="mb-0">Région de Koulikoro</h6>
                                                </div>
                                                <div class="card-body text-center">
                                                    <p class="card-text mb-3">
                                                        <i class="fa fa-map-marker-alt text-success me-1"></i>Koulikoro, Boulevard de l'Indépendance<br>
                                                        <i class="fa fa-phone text-success me-1"></i>+223 28 00 00 00<br>
                                                        <i class="fa fa-envelope text-success me-1"></i>koulikoro@synem.ml
                                                    </p>
                                                    <a href="tel:+22328000000" class="btn btn-outline-success btn-sm">Contacter</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($faqs->isNotEmpty())
            <div class="mt-5">
                <h5 class="text-primary mb-3 text-center">Autres questions fréquentes</h5>
                <div class="accordion" id="accordionExample2">
                    @foreach($faqs as $index => $faq)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $index + 3 }}">
                                <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index + 3 }}">
                                    {{ $faq->question }}
                                </button>
                            </h2>
                            <div id="collapse{{ $index + 3 }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" data-bs-parent="#accordionExample2">
                                <div class="accordion-body">
                                    {!! nl2br(e($faq->answer)) !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
<!-- FAQ End -->
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    .faq-btn {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .faq-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
    }
    .faq-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }
    .faq-btn:hover::before {
        left: 100%;
    }
    .toggle-icon {
        transition: transform 0.3s ease;
    }
    .faq-btn[aria-expanded="true"] .toggle-icon {
        transform: rotate(180deg);
    }
</style>
<script>
    $(document).ready(function() {
        // Gestion du formulaire de contact
        $('#contactForm').on('submit', function(e) {
            e.preventDefault();

            // Simulation d'envoi
            Swal.fire('Merci pour votre message !', 'Nous vous répondrons dans les plus brefs délais.', 'success');
            $(this).trigger('reset');
        });

        // Animation des éléments de contact
        $('.contact-info').each(function(i) {
            $(this).delay(i * 200).animate({
                opacity: 1,
                marginTop: 0
            }, 800);
        });

        // Animation des boutons FAQ
        $('.faq-btn').each(function(i) {
            $(this).delay(i * 100).animate({
                opacity: 1,
                marginTop: 0
            }, 600);
        });

        // Gestion des collapses FAQ
        $('.faq-btn').on('click', function() {
            var targetId = $(this).data('bs-target');
            var $collapse = $(targetId);

            // Fermer les autres collapses
            $('.collapse').not($collapse).collapse('hide');

            // Toggle le collapse actuel
            $collapse.collapse('toggle');
        });

        // Animation smooth pour les collapses
        $('.collapse').on('show.bs.collapse', function() {
            $(this).prev('.faq-btn').addClass('active');
        }).on('hide.bs.collapse', function() {
            $(this).prev('.faq-btn').removeClass('active');
        });
    });
</script>
<script>
    // Membership submission with camera functionality
    let stream = null;
    let canvas = null;
    let video = null;

    document.getElementById('captureBtn').addEventListener('click', async function() {
        try {
            stream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: 'environment' }, // Use back camera if available
                audio: false
            });

            video = document.getElementById('camera');
            canvas = document.getElementById('photoCanvas');

            video.srcObject = stream;
            document.getElementById('cameraContainer').classList.remove('d-none');
            document.getElementById('noPhotoMessage').classList.add('d-none');
            this.classList.add('d-none');
        } catch (error) {
            console.error('Error accessing camera:', error);
            Swal.fire('Erreur', 'Impossible d\'accéder à la caméra. Vérifiez les permissions.', 'error');
        }
    });

    document.getElementById('takePhotoBtn').addEventListener('click', function() {
        if (!canvas || !video) return;

        const context = canvas.getContext('2d');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        // Convert canvas to blob
        canvas.toBlob(function(blob) {
            const reader = new FileReader();
            reader.onload = function() {
                document.getElementById('memberCardPhoto').value = reader.result;
                document.getElementById('photoPreview').classList.remove('d-none');
                document.getElementById('retakeBtn').classList.remove('d-none');
                document.getElementById('takePhotoBtn').classList.add('d-none');
            };
            reader.readAsDataURL(blob);
        }, 'image/jpeg', 0.8);

        // Stop camera
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            document.getElementById('cameraContainer').classList.add('d-none');
        }
    });

    document.getElementById('retakeBtn').addEventListener('click', function() {
        document.getElementById('photoPreview').classList.add('d-none');
        document.getElementById('memberCardPhoto').value = '';
        document.getElementById('captureBtn').click();
        this.classList.add('d-none');
        document.getElementById('takePhotoBtn').classList.remove('d-none');
    });

    // Close camera when modal is closed
    $('#membershipModal').on('hidden.bs.modal', function() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }
        document.getElementById('cameraContainer').classList.add('d-none');
        document.getElementById('photoPreview').classList.add('d-none');
        document.getElementById('captureBtn').classList.remove('d-none');
        document.getElementById('retakeBtn').classList.add('d-none');
        document.getElementById('takePhotoBtn').classList.remove('d-none');
        document.getElementById('memberCardPhoto').value = '';
    });

    document.getElementById('submitMembershipBtn').addEventListener('click', async function () {
        const form = document.getElementById('membershipForm');
        const formData = new FormData(form);

        // Validate required fields
        const nom = formData.get('nom');
        const prenom = formData.get('prenom');
        const email = formData.get('email');
        const phone = formData.get('tel');
        const photo = document.getElementById('memberCardPhoto').value;

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
                document.getElementById('memberCardPhoto').value = '';
                document.getElementById('photoPreview').classList.add('d-none');
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
@endsection@endsection
