<!-- Footer Start -->
<div class="container-fluid bg-secondary py-5 px-sm-3 px-md-5" style="margin-top: 90px;">
    <div class="row pt-5">
        <div class="col-lg-3 col-md-6 mb-5">
            <h4 class="text-uppercase text-light mb-4">Contactez-nous</h4>
            <p class="mb-2"><i class="fa fa-map-marker-alt text-white mr-3"></i>{{ $sharedFooter->address ?? 'Bamako, Mali' }}</p>
            <p class="mb-2"><i class="fa fa-phone-alt text-white mr-3"></i>{{ $sharedFooter->phone ?? '+223 92190993' }}</p>
            <p><i class="fa fa-envelope text-white mr-3"></i>{{ $sharedFooter->email ?? 'contact@synem.ml' }}</p>
            <h6 class="text-uppercase text-white py-2">Suivez-nous</h6>
            <div class="d-flex justify-content-start">
                @if($sharedFooter->twitter_url ?? null)
                    <a class="btn btn-lg btn-dark btn-lg-square mr-2" href="{{ $sharedFooter->twitter_url }}"><i class="fab fa-twitter"></i></a>
                @endif
                @if($sharedFooter->facebook_url ?? null)
                    <a class="btn btn-lg btn-dark btn-lg-square mr-2" href="{{ $sharedFooter->facebook_url }}"><i class="fab fa-facebook-f"></i></a>
                @endif
                @if($sharedFooter->linkedin_url ?? null)
                    <a class="btn btn-lg btn-dark btn-lg-square mr-2" href="{{ $sharedFooter->linkedin_url }}"><i class="fab fa-linkedin-in"></i></a>
                @endif
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
                @for($i = 1; $i <= 3; $i++)
                <div class="col-4 px-1 mb-2">
                    @php
                        $imageField = 'gallery_image_' . $i;
                        $imagePath = $sharedFooter->$imageField ?? null;
                    @endphp
                    <a href="" style="display:block;">
                        <div class="footer-gallery-card" style="position:relative; width:100%; padding-top:100%; overflow:hidden; border-radius:0.35rem; background:#000;">
                            @if($imagePath)
                                <img src="{{ asset('storage/' . $imagePath) }}" alt="Galerie {{ $i }}" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;">
                            @else
                                <img src="{{ asset('template-siteweb/asset/img/gallery-' . $i . '.jpg') }}" alt="Galerie {{ $i }}" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;">
                            @endif
                        </div>
                    </a>
                </div>
                @endfor
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-5">
            <h4 class="text-uppercase text-light mb-4">Newsletter</h4>
            <p class="mb-4">{{ $sharedFooter->newsletter_description ?? 'Inscrivez-vous pour recevoir les dernières actualités du SYNEM.' }}</p>
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
    <p class="mb-2 text-center text-body">{{ $sharedFooter->copyright_text ?? '&copy; SYNEM. Tous droits réservés.' }}</p>
    <p class="m-0 text-center text-body">{{ $sharedFooter->organization_name ?? 'Syndicat National des Enseignants du Mali' }}</p>
</div>
<!-- Footer End -->