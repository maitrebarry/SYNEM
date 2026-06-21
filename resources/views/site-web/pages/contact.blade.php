@extends('layouts.site')

@section('title', 'Contact - SYNEM')

@section('content')

@include('site-web.partials.page-hero-carousel', [
    'heroId' => 'contactHeroCarousel',
    'heroSlides' => $carousels,
    'fallbackImages' => [asset('template-siteweb/asset/img/voix_enseignants.png')],
    'heroLabel' => 'Syndicat National des Enseignants du Mali',
    'heroTitle' => 'Contactez-nous',
    'heroBreadcrumb' => 'Contact',
])

{{-- Info Cards --}}
<section style="padding:80px 0; background:#fff;">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <p class="section-subtitle">Nous Joindre</p>
            <h2 class="section-title">Informations de Contact</h2>
            <div class="section-divider center"></div>
        </div>

        <div class="row mb-5">
            @php
                $defaultInfos = [
                    ['icon'=>'fa-map-marker-alt','label'=>'Adresse','value'=> ($sharedFooter->address ?? 'Bamako, Mali')],
                    ['icon'=>'fa-phone-alt','label'=>'Téléphone','value'=> ($sharedTopbar->phone ?? '+223 92190993')],
                    ['icon'=>'fa-envelope','label'=>'Email','value'=> ($sharedTopbar->email ?? 'contact@synem.ml')],
                    ['icon'=>'fa-clock','label'=>'Horaires','value'=>'Lun–Ven : 8h00–17h00'],
                ];
                $contactInfos = $infos->isNotEmpty()
                    ? $infos->map(function ($info) {
                        $icons = [
                            'address' => 'fa-map-marker-alt', 'adresse' => 'fa-map-marker-alt',
                            'phone' => 'fa-phone-alt', 'telephone' => 'fa-phone-alt', 'téléphone' => 'fa-phone-alt',
                            'email' => 'fa-envelope', 'hours' => 'fa-clock', 'horaires' => 'fa-clock',
                        ];
                        return [
                            'icon' => $icons[strtolower($info->type)] ?? 'fa-info-circle',
                            'label' => $info->label ?: ucfirst($info->type),
                            'value' => $info->value,
                        ];
                    })->all()
                    : $defaultInfos;
            @endphp
            @foreach($contactInfos as $idx => $info)
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $idx * 100 }}">
                    <div class="contact-info-card">
                        <div class="contact-icon">
                            <i class="fa {{ $info['icon'] }}"></i>
                        </div>
                        <h5 class="contact-label">{{ $info['label'] }}</h5>
                        <p class="contact-value">{{ $info['value'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row">
            {{-- Formulaire --}}
            <div class="col-lg-7 mb-5 mb-lg-0" data-aos="fade-right">
                <div class="contact-form-wrapper">
                    <p class="section-subtitle mb-2">Écrivez-nous</p>
                    <h3 class="section-title mb-3" style="font-size:1.6rem;">Envoyez-nous un Message</h3>
                    <div class="section-divider mb-4"></div>

                    @if(session('success'))
                        <div class="alert alert-success mb-4">{{ session('success') }}</div>
                    @endif

                    <div id="contactSuccess" class="alert alert-success d-none mb-4">
                        <i class="fas fa-check-circle mr-2"></i>
                        <strong>Message envoyé !</strong> Nous vous répondrons dans les plus brefs délais.
                    </div>
                    <form id="contactForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Nom *</label>
                                <input type="text" name="name" class="form-control" placeholder="Votre nom" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Email *</label>
                                <input type="email" name="email" class="form-control" placeholder="votre.email@example.com" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label>Sujet *</label>
                                <input type="text" name="subject" class="form-control" placeholder="Objet de votre message" required>
                            </div>
                            <div class="col-12 mb-4">
                                <label>Message *</label>
                                <textarea name="message" class="form-control" rows="6" placeholder="Votre message..." required></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary px-5" id="contactSubmitBtn">
                                    <i class="fa fa-paper-plane mr-2"></i>Envoyer le message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Horaires + Réseaux --}}
            <div class="col-lg-5" data-aos="fade-left" data-aos-delay="150">
                <div style="background:var(--dark); border-radius:6px; padding:36px; margin-bottom:24px;">
                    <h4 style="font-family:'Montserrat',sans-serif; font-weight:700; font-size:1rem; text-transform:uppercase; letter-spacing:1px; color:#fff; margin-bottom:24px;">
                        <i class="fa fa-clock mr-2" style="color:var(--primary);"></i>Heures d'Ouverture
                    </h4>
                    @php
                        $displayHours = [];
                        if ($hours->isNotEmpty()) {
                            $displayHours = $hours->map(fn ($hour) => [
                                'day' => $hour->day,
                                'time' => $hour->closed ? 'Fermé' : trim(($hour->open ?? '') . ' – ' . ($hour->close ?? ''), ' –'),
                                'open' => !$hour->closed,
                            ])->all();
                        } else {
                            $displayHours = [
                                ['day'=>'Lundi – Vendredi','time'=>'08h00 – 17h00','open'=>true],
                                ['day'=>'Samedi','time'=>'09h00 – 13h00','open'=>true],
                                ['day'=>'Dimanche','time'=>'Fermé','open'=>false],
                            ];
                        }
                    @endphp
                    @foreach($displayHours as $h)
                        @php
                            $day    = is_array($h) ? $h['day']  : ($h->day  ?? '');
                            $time   = is_array($h) ? $h['time'] : ($h->time ?? '');
                            $isOpen = is_array($h) ? ($h['open'] ?? true) : ($h->is_open ?? true);
                        @endphp
                        <div class="hour-row">
                            <span class="hour-day">{{ $day }}</span>
                            <span class="hour-time {{ $isOpen ? 'hour-open' : 'hour-closed' }}">{{ $time }}</span>
                        </div>
                    @endforeach
                </div>

                <div style="background:var(--light); border-radius:6px; padding:36px;">
                    <h4 style="font-family:'Montserrat',sans-serif; font-weight:700; font-size:1rem; text-transform:uppercase; letter-spacing:1px; color:var(--dark); margin-bottom:20px;">
                        Suivez-nous
                    </h4>
                    <div style="display:flex; gap:12px; flex-wrap:wrap;">
                        @if($sharedTopbar->facebook_url ?? null)
                            <a href="{{ $sharedTopbar->facebook_url }}" target="_blank" rel="noopener" style="width:44px;height:44px;background:#3b5998;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:16px;text-decoration:none;"><i class="fab fa-facebook-f"></i></a>
                        @else
                            <a href="#" style="width:44px;height:44px;background:#3b5998;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:16px;text-decoration:none;"><i class="fab fa-facebook-f"></i></a>
                        @endif
                        @if($sharedTopbar->twitter_url ?? null)
                            <a href="{{ $sharedTopbar->twitter_url }}" target="_blank" rel="noopener" style="width:44px;height:44px;background:#1da1f2;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:16px;text-decoration:none;"><i class="fab fa-twitter"></i></a>
                        @else
                            <a href="#" style="width:44px;height:44px;background:#1da1f2;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:16px;text-decoration:none;"><i class="fab fa-twitter"></i></a>
                        @endif
                        @if($sharedTopbar->linkedin_url ?? null)
                            <a href="{{ $sharedTopbar->linkedin_url }}" target="_blank" rel="noopener" style="width:44px;height:44px;background:#0077b5;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:16px;text-decoration:none;"><i class="fab fa-linkedin-in"></i></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FAQ --}}
@if($faqs->isNotEmpty())
<section style="padding:80px 0; background:var(--light);">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <p class="section-subtitle">Questions Fréquentes</p>
            <h2 class="section-title">FAQ</h2>
            <div class="section-divider center"></div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div id="faqAccordion">
                    @foreach($faqs as $idx => $faq)
                        <div class="card mb-3 border-0" style="border-radius:6px; overflow:hidden; box-shadow:var(--shadow);">
                            <div class="card-header" style="background:#fff; padding:0; border:none;">
                                <button class="btn w-100 text-left d-flex justify-content-between align-items-center p-4" data-toggle="collapse" data-target="#faq{{ $idx }}" style="font-family:'Montserrat',sans-serif; font-weight:700; font-size:14px; color:var(--dark);">
                                    {{ $faq->question ?? $faq['question'] ?? '' }}
                                    <i class="fa fa-plus text-danger ml-3" style="flex-shrink:0;"></i>
                                </button>
                            </div>
                            <div id="faq{{ $idx }}" class="collapse" data-parent="#faqAccordion">
                                <div class="card-body pt-0 px-4 pb-4" style="color:var(--gray); font-size:14px; line-height:1.8;">
                                    {{ $faq->answer ?? $faq['answer'] ?? '' }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@if($map && $map->value)
<section style="padding:0 0 80px;background:var(--light)">
    <div class="container">
        <div class="text-center mb-4"><p class="section-subtitle">Localisation</p><h2 class="section-title">Nous trouver</h2><div class="section-divider center"></div></div>
        <div class="rounded overflow-hidden" style="min-height:360px">{!! $map->value !!}</div>
    </div>
</section>
@endif

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('contactForm');
    var btn  = document.getElementById('contactSubmitBtn');
    var success = document.getElementById('contactSuccess');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        if (!form.checkValidity()) { form.reportValidity(); return; }
        btn.disabled = true;
        btn.innerHTML = '<i class="fa fa-spinner fa-spin mr-2"></i>Envoi en cours...';
        // Simulation envoi (à remplacer par un vrai appel AJAX quand la route sera créée)
        setTimeout(function () {
            form.reset();
            btn.disabled = false;
            btn.innerHTML = '<i class="fa fa-paper-plane mr-2"></i>Envoyer le message';
            success.classList.remove('d-none');
            setTimeout(function () { success.classList.add('d-none'); }, 6000);
        }, 1200);
    });
});
</script>
@endsection
