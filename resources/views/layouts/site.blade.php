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