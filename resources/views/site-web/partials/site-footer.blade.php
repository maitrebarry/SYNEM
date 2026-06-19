<!-- Footer Top Bar -->
<div class="footer-top-bar">
    <div class="container">
        <p class="footer-org-name">Syndicat National des Enseignants du Mali — SYNEM</p>
    </div>
</div>

<!-- Footer Main -->
<footer class="site-footer">
    <div class="container">
        <div class="row">
            <!-- Col 1 : À propos -->
            <div class="col-lg-4 col-md-6 mb-5">
                <a href="{{ route('accueil') }}" class="footer-logo">
                    <span class="brand-sy">SY</span><span class="brand-ne">NE</span><span class="brand-m">M</span>
                </a>
                <p class="footer-desc">
                    {{ $sharedFooter->footer_description ?? "Le Syndicat National des Enseignants du Mali défend les droits des enseignants et œuvre pour une éducation de qualité pour tous les enfants du Mali." }}
                </p>
                <div class="footer-social">
                    @if($sharedFooter->twitter_url ?? null)
                        <a href="{{ $sharedFooter->twitter_url }}" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    @else
                        <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    @endif
                    @if($sharedFooter->facebook_url ?? null)
                        <a href="{{ $sharedFooter->facebook_url }}" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    @else
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    @endif
                    @if($sharedFooter->linkedin_url ?? null)
                        <a href="{{ $sharedFooter->linkedin_url }}" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    @else
                        <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    @endif
                    @if($sharedFooter->instagram_url ?? null)
                        <a href="{{ $sharedFooter->instagram_url }}" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    @endif
                </div>
            </div>

            <!-- Col 2 : Liens Rapides -->
            <div class="col-lg-2 col-md-6 mb-5">
                <h5 class="footer-heading">Liens Rapides</h5>
                <a href="{{ route('accueil') }}" class="footer-link"><i class="fa fa-angle-right"></i> Accueil</a>
                <a href="{{ route('a-propos') }}" class="footer-link"><i class="fa fa-angle-right"></i> À propos</a>
                <a href="{{ route('mission') }}" class="footer-link"><i class="fa fa-angle-right"></i> Notre Mission</a>
                <a href="{{ route('historique') }}" class="footer-link"><i class="fa fa-angle-right"></i> Historique</a>
                <a href="{{ route('contact') }}" class="footer-link"><i class="fa fa-angle-right"></i> Contact</a>
            </div>

            <!-- Col 3 : Galerie -->
            <div class="col-lg-3 col-md-6 mb-5">
                <h5 class="footer-heading">Galerie</h5>
                <div class="footer-gallery-grid">
                    @for($i = 1; $i <= 6; $i++)
                        @php
                            $imageField = 'gallery_image_' . $i;
                            $imagePath = $sharedFooter->$imageField ?? null;
                        @endphp
                        <div class="gallery-thumb">
                            @if($imagePath)
                                <img src="{{ asset('storage/' . $imagePath) }}" alt="Galerie {{ $i }}">
                            @else
                                <img src="{{ asset('template-siteweb/asset/img/gallery-' . min($i, 3) . '.jpg') }}" alt="Galerie {{ $i }}">
                            @endif
                        </div>
                    @endfor
                </div>
            </div>

            <!-- Col 4 : Contact + Newsletter -->
            <div class="col-lg-3 col-md-6 mb-5">
                <h5 class="footer-heading">Contactez-nous</h5>
                <div class="footer-contact-item">
                    <i class="fa fa-map-marker-alt"></i>
                    <span>{{ $sharedFooter->address ?? 'Bamako, Mali' }}</span>
                </div>
                <div class="footer-contact-item">
                    <i class="fa fa-phone-alt"></i>
                    <span>{{ $sharedFooter->phone ?? '+223 92190993' }}</span>
                </div>
                <div class="footer-contact-item">
                    <i class="fa fa-envelope"></i>
                    <span>{{ $sharedFooter->email ?? 'contact@synem.ml' }}</span>
                </div>

                <h5 class="footer-heading mt-4">Newsletter</h5>
                <div class="footer-newsletter">
                    <div class="input-wrap">
                        <input type="email" placeholder="Votre adresse email">
                        <button type="button">OK</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <p>{{ $sharedFooter->copyright_text ?? '© ' . date('Y') . ' SYNEM — Syndicat National des Enseignants du Mali. Tous droits réservés.' }}</p>
        </div>
    </div>
</footer>
