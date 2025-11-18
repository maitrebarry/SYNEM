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
<!-- Page Header Start -->
@include('site-web.partials.page-carousel', [
    'pageTitle' => 'Contactez-Nous',
    'breadcrumb' => 'Contact',
    'images' => [
        asset('template-siteweb/asset/img/gallery-6.jpg'),
        asset('template-siteweb/asset/img/gallery-2.jpg'),
        asset('template-siteweb/asset/img/gallery-3.jpg')
    ],
    'captions' => [
        'Une équipe à votre écoute',
        'Ensemble, construisons l avenir de l éducation',
        'Votre voix compte, contactez-nous'
    ]
])
<!-- Page Header End -->

<!-- Contact Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="section-title text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px;">
            <h1 class="mb-0">Restons en Contact</h1>
            <p>Nous sommes à votre écoute pour toute question ou préoccupation</p>
        </div>
        
        <div class="row g-5 mb-5">
            <!-- Information 1 -->
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
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3859.527546643089!2d-7.986865724149911!3d12.639657185625498!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTLCsDM4JzIyLjgiTiA3wrA1OScwNy44Ilc!5e1!3m2!1sfr!2sml!4v1620000000000!5m2!1sfr!2sml" 
                            width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
                
                <div class="bg-light rounded p-4">
                    <h4 class="mb-4">Heures d'Ouverture</h4>
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
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact End -->

<div class="container py-5">
    <div class="row align-items-center g-5">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <img src="{{ asset('template-siteweb/asset/img/contact-demo.jpg') }}" alt="Contact SYNEM" class="img-fluid rounded shadow">
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
            <div class="col-lg-6">
                <div class="accordion" id="accordionExample2">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                Comment obtenir de l'aide juridique ?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample2">
                            <div class="accordion-body">
                                Notre service juridique est disponible pour tous les membres. Contactez-nous pour prendre rendez-vous.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                                Où se trouvent vos bureaux régionaux ?
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample2">
                            <div class="accordion-body">
                                Nous avons des bureaux dans les 8 régions administratives du Mali. Contactez-nous pour les adresses spécifiques.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FAQ End -->
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Gestion du formulaire de contact
        $('#contactForm').on('submit', function(e) {
            e.preventDefault();
            
            // Simulation d'envoi
            alert('Merci pour votre message ! Nous vous répondrons dans les plus brefs délais.');
            $(this).trigger('reset');
        });
        
        // Animation des éléments de contact
        $('.contact-info').each(function(i) {
            $(this).delay(i * 200).animate({
                opacity: 1,
                marginTop: 0
            }, 800);
        });
    });
</script>
@endsection