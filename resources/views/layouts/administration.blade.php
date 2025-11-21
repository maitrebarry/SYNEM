<!doctype html>
<html lang="fr" class="semi-dark">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!--favicon-->
	<link rel="icon" href="{{ asset('template-admin/assets/images/favicon-32x32.png') }}" type="image/png" />
	<!--plugins-->
	<link href="{{ asset('template-admin/assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
	<link href="{{ asset('template-admin/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
	@if(request()->is('administration/tableau-de-bord'))
	<link href="{{ asset('template-admin/assets/plugins/highcharts/css/highcharts.css') }}" rel="stylesheet" />
	<link href="{{ asset('template-admin/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
	@endif
	<link href="{{ asset('template-admin/assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
	<!-- lien pour icone -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Font Awesome (pour icônes utilisées dans les vues) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
	<!-- loader-->
	<link href="{{ asset('template-admin/assets/css/pace.min.css') }}" rel="stylesheet" />
	<script src="{{ asset('template-admin/assets/js/pace.min.js') }}"></script>
	<!-- Bootstrap CSS -->
	<link href="{{ asset('template-admin/assets/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('template-admin/assets/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('template-admin/assets/css/icons.css') }}" rel="stylesheet">
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="{{ asset('template-admin/assets/css/dark-theme.css') }}" />
	<link rel="stylesheet" href="{{ asset('template-admin/assets/css/semi-dark.css') }}" />
	<link rel="stylesheet" href="{{ asset('template-admin/assets/css/header-colors.css') }}" />
	<!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
	<title>Admin SYNEM - @yield('title', 'Tableau de bord')</title>
	
	<style>
        .card-hover:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .stat-card {
            border-left: 4px solid #0d6efd;
        }
        .stat-card.success {
            border-left-color: #198754;
        }
        .stat-card.warning {
            border-left-color: #ffc107;
        }
        .stat-card.info {
            border-left-color: #0dcaf0;
        }
        .progress {
            height: 8px;
        }
        .cursor-pointer {
            cursor: pointer;
        }
        
        /* Styles SYNEM */
        .synem-primary { color: #1a365d; }
        .bg-synem-primary { background-color: #1a365d; }
        .synem-logo { color: #1a365d; font-weight: bold; }
    </style>
    
    @yield('styles')
</head>

<body>
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
		@include('administration.partials.sidebar')
		<!--end sidebar wrapper -->
		
		<!--start header -->
		@include('administration.partials.header')
		<!--end header -->
		
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!-- Breadcrumb -->
				@yield('breadcrumb')
				
				<!-- Messages de notification -->
				@if(session('success'))
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						{{ session('success') }}
						<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
					</div>
				@endif

				@if($errors->any())
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<ul class="mb-0">
							@foreach($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
						<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
					</div>
				@endif

				<!-- Contenu principal -->
				@yield('content')
			</div>
		</div>
		<!--end page wrapper -->
		
		<!--start overlay-->
		<div class="overlay toggle-icon"></div>
		<!--end overlay-->
		
		<!--Start Back To Top Button--> 
		<a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
		
		<footer class="page-footer">
			<p class="mb-0">SYNEM &copy; {{ date('Y') }}. Tous droits réservés.</p>
		</footer>
	</div>
	<!--end wrapper-->
	
<!-- jQuery FIRST -->
<script src="{{ asset('template-admin/assets/js/jquery.min.js') }}"></script>

<!-- THEN Bootstrap -->
<script src="{{ asset('template-admin/assets/js/bootstrap.bundle.min.js') }}"></script>

<!-- plugins -->
<script src="{{ asset('template-admin/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ asset('template-admin/assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
<script src="{{ asset('template-admin/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>

<!-- DÉSACTIVER l'initialisation automatique de PerfectScrollbar dans app.js -->
<script>
    // Redéfinir PerfectScrollbar pour éviter les erreurs
    const OriginalPerfectScrollbar = window.PerfectScrollbar;
    window.PerfectScrollbar = function(element, options) {
        // Vérifier si element est valide
        if (!element || typeof element === 'undefined' || element === null) {
            console.warn('PerfectScrollbar: Aucun élément spécifié, initialisation annulée');
            return {
                update: function() {},
                destroy: function() {},
                initialized: false
            };
        }

        // Vérifier si c'est un élément DOM valide
        if (!(element instanceof Element) && !(element instanceof HTMLElement)) {
            console.warn('PerfectScrollbar: Élément invalide, initialisation annulée');
            return {
                update: function() {},
                destroy: function() {},
                initialized: false
            };
        }

        try {
            return new OriginalPerfectScrollbar(element, options);
        } catch (e) {
            console.warn('PerfectScrollbar: Erreur lors de l\'initialisation:', e.message);
            return {
                update: function() {},
                destroy: function() {},
                initialized: false
            };
        }
    };

    // Également redéfinir la fonction d'initialisation si elle existe
    if (typeof window.PerfectScrollbar.initializeAll === 'function') {
        window.PerfectScrollbar.initializeAll = function() {
            console.warn('PerfectScrollbar.initializeAll désactivé');
        };
    }
</script>

<!-- Charger app.js APRÈS avoir redéfini PerfectScrollbar -->
<script src="{{ asset('template-admin/assets/js/app.js') }}"></script>

<!-- Scripts additionnels - UNIQUEMENT pour le dashboard -->
@if(request()->is('administration/tableau-de-bord'))
<script src="{{ asset('template-admin/assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
<script src="{{ asset('template-admin/assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<script src="{{ asset('template-admin/assets/plugins/highcharts/js/highcharts.js') }}"></script>
<script src="{{ asset('template-admin/assets/plugins/highcharts/js/exporting.js') }}"></script>
<script src="{{ asset('template-admin/assets/plugins/highcharts/js/variable-pie.js') }}"></script>
<script src="{{ asset('template-admin/assets/plugins/highcharts/js/export-data.js') }}"></script>
<script src="{{ asset('template-admin/assets/plugins/highcharts/js/accessibility.js') }}"></script>
<script src="{{ asset('template-admin/assets/plugins/apexcharts-bundle/js/apexcharts.min.js') }}"></script>
<script src="{{ asset('template-admin/assets/js/index.js') }}"></script>
@endif

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- SortableJS for drag and drop -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<!-- Script d'initialisation SYNEM -->
<script>
$(document).ready(function () {

    // Initialisation PerfectScrollbar
    const sidebar = document.querySelector('.sidebar-wrapper');
    if (sidebar) {
        try {
            new PerfectScrollbar(sidebar);
        } catch (e) {}
    }

    // Initialisation MetisMenu (version correcte)
    try {
        $("#menu").metisMenu();
    } catch (e) {
        console.warn("Erreur MetisMenu:", e);
    }

    // Fermer tous les menus au démarrage
    setTimeout(() => {
        $('.metismenu .mm-collapse').removeClass('mm-show');
        $('.metismenu .has-arrow').removeClass('mm-active');
    }, 200);
});
</script>

@stack('scripts')
    {{-- Notifications handled inline in the layout (Bootstrap alerts) to avoid duplicate popups. --}}
</body>
</html>
