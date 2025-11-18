<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'SYNEM - Syndicat National des Enseignants du Mali')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="SYNEM, Enseignants, Mali, Éducation" name="keywords">
    <meta content="Syndicat National des Enseignants du Mali" name="description">

    <!-- Favicon -->
    <link href="{{ asset('template-siteweb/asset/img/vendor-4.png') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Rubik&display=swap" rel="stylesheet"> 

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
    @yield('scripts')
</body>
</html>