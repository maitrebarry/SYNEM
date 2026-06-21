<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'SYNEM - Syndicat National des Enseignants du Mali')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="SYNEM, Enseignants, Mali, Éducation" name="keywords">
    <meta content="Syndicat National des Enseignants du Mali" name="description">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link href="{{ asset('template-siteweb/asset/img/vendor-4.png') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- AOS - Animate On Scroll -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('template-siteweb/asset/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template-siteweb/asset/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('template-siteweb/asset/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('template-siteweb/asset/css/style.css') }}" rel="stylesheet">
     <link href="{{ asset('template-siteweb/asset/css/stylecarosel.css') }}" rel="stylesheet">
    @yield('styles')
</head>

<body>
    <!-- Header -->
    @include('site-web.partials.site-header')

    <!-- Contenu Principal -->
    @yield('content')

    <!-- Footer -->
    @include('site-web.partials.site-footer')

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- ── Bouton WhatsApp Flottant ───────────────────────── -->
    <style>
        #waBtnFlottant {
            position: fixed; bottom: 90px; right: 24px; z-index: 9999;
            width: 60px; height: 60px; border-radius: 50%;
            background: #25D366; border: none; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 20px rgba(37,211,102,.55);
            animation: waPulse 2.2s ease-in-out infinite;
            transition: transform .2s, box-shadow .2s;
        }
        #waBtnFlottant:hover {
            transform: scale(1.15);
            box-shadow: 0 6px 28px rgba(37,211,102,.75);
            animation: none;
        }
        @keyframes waPulse {
            0%   { box-shadow: 0 0 0 0 rgba(37,211,102,.6); transform: scale(1); }
            50%  { box-shadow: 0 0 0 14px rgba(37,211,102,0); transform: scale(1.06); }
            100% { box-shadow: 0 0 0 0 rgba(37,211,102,0); transform: scale(1); }
        }
        /* Bulle tooltip "Contactez-nous" */
        #waBtnFlottant::before {
            content: 'Contactez-nous';
            position: absolute; right: 70px; top: 50%;
            transform: translateY(-50%);
            background: #1a1a1a; color: #fff;
            font-size: 12px; font-weight: 600;
            padding: 5px 10px; border-radius: 6px;
            white-space: nowrap; pointer-events: none;
            opacity: 0; transition: opacity .25s;
        }
        #waBtnFlottant:hover::before { opacity: 1; }
    </style>
    <button id="waBtnFlottant" onclick="document.getElementById('waModal').style.display='flex'" title="Contactez-nous sur WhatsApp">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30" height="30" fill="#fff">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
        </svg>
    </button>

    <!-- ── Modal WhatsApp 2 étapes ───────────────────────── -->
    @php
        $waAdmins = \App\Models\User::whereIn('role',['superadmin','admin'])
            ->where('is_active', true)
            ->whereNotNull('whatsapp')
            ->select('name','fonction','whatsapp')
            ->get()
            ->map(function($u){
                $d = preg_replace('/\D/','',$u->whatsapp);
                return [
                    'name'     => $u->name,
                    'fonction' => $u->fonction ?? 'Responsable SYNEM',
                    'numero'   => $u->whatsapp,
                    'waNum'    => str_starts_with($d,'223') ? $d : '223'.ltrim($d,'0'),
                    'initiale' => strtoupper(substr($u->name,0,1)),
                ];
            });
    @endphp

    <div id="waModal" onclick="if(event.target===this)waModalClose()"
        style="display:none;position:fixed;inset:0;z-index:10000;background:rgba(0,0,0,.52);align-items:center;justify-content:center;padding:16px">

        <div style="background:#fff;border-radius:18px;width:100%;max-width:430px;overflow:hidden;box-shadow:0 24px 70px rgba(0,0,0,.35);animation:waModalIn .3s cubic-bezier(.16,1,.3,1)">

            {{-- En-tête --}}
            <div id="waHeader" style="background:linear-gradient(135deg,#25D366,#128C7E);padding:16px 20px;display:flex;align-items:center;gap:12px">
                <div style="width:40px;height:40px;border-radius:50%;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22" fill="#fff"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                </div>
                <div style="flex:1">
                    <div id="waHeaderTitle" style="color:#fff;font-weight:700;font-size:15px">Contacter le SYNEM</div>
                    <div id="waHeaderSub" style="color:rgba(255,255,255,.8);font-size:12px">Choisissez un responsable</div>
                </div>
                <button onclick="waModalClose()" style="background:none;border:none;color:#fff;font-size:22px;cursor:pointer;line-height:1;opacity:.8">&times;</button>
            </div>

            {{-- ÉTAPE 1 : Liste + recherche --}}
            <div id="waStep1">
                <div style="padding:14px 16px 8px">
                    <div style="position:relative">
                        <input id="waSearch" type="text" placeholder="Rechercher un responsable..."
                            oninput="waFiltrer(this.value)"
                            style="width:100%;padding:9px 12px 9px 36px;border:1.5px solid #e0e0e0;border-radius:10px;font-size:13px;outline:none;transition:border-color .2s"
                            onfocus="this.style.borderColor='#25D366'" onblur="this.style.borderColor='#e0e0e0'">
                        <svg style="position:absolute;left:10px;top:50%;transform:translateY(-50%);opacity:.4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </div>
                </div>
                <div id="waListeAdmins" style="padding:4px 16px 16px;max-height:320px;overflow-y:auto">
                    @forelse($waAdmins as $admin)
                    <div class="wa-admin-card"
                        data-nom="{{ strtolower($admin['name']) }} {{ strtolower($admin['fonction']) }}"
                        onclick="waSelectAdmin('{{ addslashes($admin['name']) }}','{{ $admin['fonction'] }}','{{ $admin['numero'] }}','{{ $admin['waNum'] }}','{{ $admin['initiale'] }}')"
                        style="display:flex;align-items:center;gap:12px;padding:12px;border-radius:12px;border:1.5px solid #f0f0f0;margin-bottom:8px;cursor:pointer;transition:all .2s">
                        <div style="width:48px;height:48px;border-radius:50%;background:linear-gradient(135deg,#25D366,#128C7E);display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 2px 10px rgba(37,211,102,.3)">
                            <span style="color:#fff;font-weight:800;font-size:19px">{{ $admin['initiale'] }}</span>
                        </div>
                        <div style="flex:1;min-width:0">
                            <div style="font-weight:700;color:#1a1a1a;font-size:14px">{{ $admin['name'] }}</div>
                            <div style="font-size:12px;color:#25D366;font-weight:600;margin-top:1px">{{ $admin['fonction'] }}</div>
                            <div style="font-size:11px;color:#999;margin-top:2px">+223 {{ $admin['numero'] }}</div>
                        </div>
                        <div style="flex-shrink:0;color:#ccc">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                        </div>
                    </div>
                    @empty
                    <div style="text-align:center;color:#999;padding:30px 0;font-size:13px">
                        <div style="font-size:2rem;margin-bottom:8px">📵</div>
                        Aucun responsable disponible.<br>
                        <a href="mailto:contact@synem.ml" style="color:#25D366;font-size:12px">contact@synem.ml</a>
                    </div>
                    @endforelse
                    <div id="waAucunResultat" style="display:none;text-align:center;color:#999;padding:20px 0;font-size:13px">Aucun résultat pour votre recherche.</div>
                </div>
            </div>

            {{-- ÉTAPE 2 : Message personnalisable --}}
            <div id="waStep2" style="display:none;padding:16px 20px">
                {{-- Mini profil admin sélectionné --}}
                <div id="waAdminSelectionne" style="display:flex;align-items:center;gap:12px;padding:12px;background:#f6fef9;border:1.5px solid #c8f2d8;border-radius:12px;margin-bottom:16px">
                    <div id="waSelInitiale" style="width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,#25D366,#128C7E);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <span style="color:#fff;font-weight:800;font-size:18px"></span>
                    </div>
                    <div>
                        <div id="waSelNom" style="font-weight:700;color:#1a1a1a;font-size:14px"></div>
                        <div id="waSelFonction" style="font-size:12px;color:#25D366;font-weight:600"></div>
                        <div id="waSelNumero" style="font-size:11px;color:#888;margin-top:1px"></div>
                    </div>
                </div>

                {{-- Zone message --}}
                <label style="font-size:12px;font-weight:700;color:#555;letter-spacing:.5px;text-transform:uppercase;display:block;margin-bottom:6px">Votre message</label>
                <textarea id="waMessage" rows="4"
                    style="width:100%;padding:12px;border:1.5px solid #e0e0e0;border-radius:10px;font-size:13px;line-height:1.6;resize:vertical;outline:none;transition:border-color .2s;font-family:inherit"
                    onfocus="this.style.borderColor='#25D366'" onblur="this.style.borderColor='#e0e0e0'"></textarea>
                <div style="font-size:11px;color:#aaa;margin-top:4px;margin-bottom:12px">Vous pouvez modifier ce message avant de l'envoyer.</div>

                {{-- Choix mobile ou web --}}
                <div style="display:flex;gap:8px;margin-bottom:14px">
                    <button onclick="waOuvrirWhatsApp('app')" style="flex:1;padding:10px 6px;border:none;border-radius:10px;background:#25D366;color:#fff;font-size:12px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px;transition:background .2s" onmouseover="this.style.background='#1ebe5d'" onmouseout="this.style.background='#25D366'" title="Ouvrir l'application WhatsApp">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15" fill="#fff"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        Application
                    </button>
                    <button onclick="waOuvrirWhatsApp('web')" style="flex:1;padding:10px 6px;border:1.5px solid #25D366;border-radius:10px;background:#fff;color:#25D366;font-size:12px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px;transition:all .2s" onmouseover="this.style.background='#f6fef9'" onmouseout="this.style.background='#fff'" title="Ouvrir WhatsApp Web dans le navigateur">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#25D366" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                        WhatsApp Web
                    </button>
                </div>

                <div style="display:flex;gap:10px">
                    <button onclick="waRetour()" style="flex:1;padding:10px;border:1.5px solid #e0e0e0;border-radius:10px;background:#fff;font-size:13px;font-weight:600;cursor:pointer;color:#555;transition:background .2s" onmouseover="this.style.background='#f5f5f5'" onmouseout="this.style.background='#fff'">
                        ← Retour
                    </button>
                </div>

                <div style="margin-top:12px;padding:10px 12px;background:#fffbf0;border-radius:8px;border-left:3px solid #f0b429;font-size:11px;color:#7a6000;line-height:1.5">
                    Le message sera pré-rempli dans WhatsApp. Il vous suffira d'appuyer sur <strong>Envoyer</strong> pour le transmettre.
                </div>
            </div>

        </div>
    </div>

    <style>
        @keyframes waModalIn {
            from { opacity:0; transform:scale(.95) translateY(12px); }
            to   { opacity:1; transform:scale(1)   translateY(0); }
        }
        .wa-admin-card:hover {
            border-color: #25D366 !important;
            background: #f6fef9 !important;
            transform: translateX(3px);
        }
    </style>

    <script>
        var waNumActuel = '';

        function waModalClose() {
            document.getElementById('waModal').style.display = 'none';
            setTimeout(waRetour, 300);
            document.getElementById('waSearch').value = '';
            waFiltrer('');
        }

        function waFiltrer(terme) {
            var t = terme.toLowerCase();
            var cards = document.querySelectorAll('.wa-admin-card');
            var vus = 0;
            cards.forEach(function(c) {
                var visible = c.dataset.nom.includes(t);
                c.style.display = visible ? 'flex' : 'none';
                if (visible) vus++;
            });
            document.getElementById('waAucunResultat').style.display = vus === 0 ? 'block' : 'none';
        }

        function waSelectAdmin(nom, fonction, numero, waNum, initiale) {
            waNumActuel = waNum;
            // Remplir l'en-tête étape 2
            document.getElementById('waHeaderTitle').textContent = nom;
            document.getElementById('waHeaderSub').textContent   = fonction;
            // Remplir la carte admin
            document.getElementById('waSelInitiale').querySelector('span').textContent = initiale;
            document.getElementById('waSelNom').textContent      = nom;
            document.getElementById('waSelFonction').textContent = fonction;
            document.getElementById('waSelNumero').textContent   = '+223 ' + numero;
            // Message prédéfini modifiable
            document.getElementById('waMessage').value =
                'Bonjour ' + nom + ',\n\nJe vous contacte depuis le site du SYNEM.\n\n[Écrivez votre message ici]';
            // Basculer vers étape 2
            document.getElementById('waStep1').style.display = 'none';
            document.getElementById('waStep2').style.display = 'block';
        }

        function waRetour() {
            document.getElementById('waStep2').style.display = 'none';
            document.getElementById('waStep1').style.display = 'block';
            document.getElementById('waHeaderTitle').textContent = 'Contacter le SYNEM';
            document.getElementById('waHeaderSub').textContent   = 'Choisissez un responsable';
        }

        function waOuvrirWhatsApp(mode) {
            var msg = document.getElementById('waMessage').value.trim();
            if (!msg) { alert('Veuillez écrire un message.'); return; }
            var encoded = encodeURIComponent(msg);
            var url;
            if (mode === 'web') {
                url = 'https://web.whatsapp.com/send?phone=' + waNumActuel + '&text=' + encoded;
            } else {
                url = 'https://wa.me/' + waNumActuel + '?text=' + encoded;
            }
            window.open(url, '_blank');
        }
    </script>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('template-siteweb/asset/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('template-siteweb/asset/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('template-siteweb/asset/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('template-siteweb/asset/lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('template-siteweb/asset/lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('template-siteweb/asset/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('template-siteweb/asset/js/main.js') }}"></script>
    <script src="{{ asset('template-siteweb/asset/js/carosel.js') }}"></script>

    <!-- AOS Init -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ duration: 800, once: true, offset: 80 });</script>

    <!-- Global 5 Mo/image client-side validation (site public) -->
    <script>
        (function(){
            const MAX = 5 * 1024 * 1024; // 5 Mo
            window.SYNEM_MAX_IMAGE_BYTES = MAX;

            function formatMo(bytes){ return (bytes/1024/1024).toFixed(2) + ' Mo'; }
            function showTooLarge(files){
                const msg = 'Chaque image doit faire au maximum 5 Mo.';
                if (window.Swal && typeof window.Swal.fire === 'function') {
                    const items = files.map(f => `<li>${String(f.name)} — ${formatMo(f.size)}</li>`).join('');
                    window.Swal.fire({ icon: 'error', title: 'Image trop volumineuse', html: `${msg}<br><ul class="text-start mb-0">${items}</ul>` });
                } else {
                    alert(msg);
                }
            }
            function isImage(file, input){
                const mime = (file && file.type) ? String(file.type) : '';
                if (mime.startsWith('image/')) return true;
                const accept = (input && input.getAttribute) ? (input.getAttribute('accept') || '') : '';
                return String(accept).includes('image');
            }
            function validateInput(input){
                if(!input || input.type !== 'file') return true;
                const files = Array.from(input.files || []);
                if(!files.length) return true;
                const oversized = files.filter(f => isImage(f, input) && f.size > MAX);
                if(!oversized.length) return true;
                try{
                    if(input.multiple && window.DataTransfer){
                        const dt = new DataTransfer();
                        files.filter(f => !oversized.includes(f)).forEach(f => dt.items.add(f));
                        input.files = dt.files;
                    } else {
                        input.value = '';
                    }
                }catch(e){ input.value = ''; }
                showTooLarge(oversized.map(f => ({ name: f.name, size: f.size })));
                return false;
            }
            document.addEventListener('change', function(e){
                const t = e.target;
                if(t && t.matches && t.matches('input[type="file"]')) validateInput(t);
            }, true);
            document.addEventListener('submit', function(e){
                const form = e.target;
                if(!form || !form.querySelectorAll) return;
                const inputs = Array.from(form.querySelectorAll('input[type="file"]'));
                for(const inp of inputs){
                    if(!validateInput(inp)){
                        e.preventDefault();
                        e.stopPropagation();
                        return false;
                    }
                }
            }, true);
        })();
    </script>
    @yield('scripts')
    <script>
        /* Flèche scroll page-hero → contenu suivant */
        document.querySelectorAll('.page-hero-scroll').forEach(function(el) {
            el.addEventListener('click', function() {
                var hero = el.closest('.page-hero');
                var next = hero ? hero.nextElementSibling : null;
                if (next && next.classList.contains('page-header-accent')) next = next.nextElementSibling;
                if (next) next.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });
    </script>
</body>
</html>