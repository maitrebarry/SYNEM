<!-- Footer Start -->
<div class="container-fluid bg-secondary py-5 px-sm-3 px-md-5" style="margin-top: 90px;">
    <div class="row pt-5">
        <div class="col-lg-3 col-md-6 mb-5">
            <h4 class="text-uppercase text-light mb-4">Contactez-nous</h4>
            <p class="mb-2"><i class="fa fa-map-marker-alt text-white mr-3"></i>Bamako, Mali</p>
            <p class="mb-2"><i class="fa fa-phone-alt text-white mr-3"></i>+223 92190993</p>
            <p><i class="fa fa-envelope text-white mr-3"></i>contact@synem.ml</p>
            <h6 class="text-uppercase text-white py-2">Suivez-nous</h6>
            <div class="d-flex justify-content-start">
                <a class="btn btn-lg btn-dark btn-lg-square mr-2" href="#"><i class="fab fa-twitter"></i></a>
                <a class="btn btn-lg btn-dark btn-lg-square mr-2" href="#"><i class="fab fa-facebook-f"></i></a>
                <a class="btn btn-lg btn-dark btn-lg-square mr-2" href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-5">
            <h4 class="text-uppercase text-light mb-4">Liens Rapides</h4>
            <div class="d-flex flex-column justify-content-start">
                <a class="text-body mb-2" href="{{ route('accueil') }}"><i class="fa fa-angle-right text-white mr-2"></i>Accueil</a>
                <a class="text-body mb-2" href="{{ route('a-propos') }}"><i class="fa fa-angle-right text-white mr-2"></i>À propos</a>
                <a class="text-body mb-2" href="{{ route('mission') }}"><i class="fa fa-angle-right text-white mr-2"></i>Notre mission</a>
                <a class="text-body mb-2" href="{{ route('historique') }}"><i class="fa fa-angle-right text-white mr-2"></i>Historique</a>
                <a class="text-body mb-2" href="{{ route('contact') }}"><i class="fa fa-angle-right text-white mr-2"></i>Contact</a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-5">
            <h4 class="text-uppercase text-light mb-4">Galerie</h4>
            <div class="row mx-n1">
                <div class="col-4 px-1 mb-2">
                    <a href=""><img class="w-100" src="{{ asset('template-siteweb/asset/img/gallery-1.jpg') }}" alt="Galerie 1"></a>
                </div>
                <div class="col-4 px-1 mb-2">
                    <a href=""><img class="w-100" src="{{ asset('template-siteweb/asset/img/gallery-2.jpg') }}" alt="Galerie 2"></a>
                </div>
                <div class="col-4 px-1 mb-2">
                    <a href=""><img class="w-100" src="{{ asset('template-siteweb/asset/img/gallery-3.jpg') }}" alt="Galerie 3"></a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-5">
            <h4 class="text-uppercase text-light mb-4">Newsletter</h4>
            <p class="mb-4">Inscrivez-vous pour recevoir les dernières actualités du SYNEM.</p>
            <div class="w-100 mb-3">
                <div class="input-group">
                    <input type="text" class="form-control bg-dark border-dark" style="padding: 25px;" placeholder="Votre email">
                    <div class="input-group-append">
                        <button class="btn btn-primary text-uppercase px-3">S'inscrire</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid bg-dark py-4 px-sm-3 px-md-5">
    <p class="mb-2 text-center text-body">&copy; <a href="#">SYNEM</a>. Tous droits réservés.</p>
    <p class="m-0 text-center text-body">Syndicat National des Enseignants du Mali</p>
</div>
<!-- Footer End -->