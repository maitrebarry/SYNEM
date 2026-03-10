<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteWeb\AccueilController;
use App\Http\Controllers\SiteWeb\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Administration\UtilisateurController;
use App\Http\Controllers\MilitantMessageController;

// Test route for admin militants without auth (can be removed after testing)
Route::get('/test-admin-militants', function() {
    $request = request();

    $query = App\Models\Militant::query();

    // Filter by status
    if ($request->filled('status') && $request->status !== 'all') {
        $query->where('status', $request->status);
    }

    // Filter by local coordination
    if ($request->filled('coordination') && $request->coordination !== 'all') {
        $query->where('coordinations', $request->coordination);
    }

    // Search by name, email, phone or card number
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('nom', 'like', "%$search%")
              ->orWhere('prenom', 'like', "%$search%")
              ->orWhere('name', 'like', "%$search%")
              ->orWhere('email', 'like', "%$search%")
              ->orWhere('n_cartes_syndicale', 'like', "%$search%")
              ->orWhere('tel', 'like', "%$search%");
        });
    }

    // Coordinations list - ensure we get fresh data
    $coordinations = App\Models\Militant::distinct()->pluck('coordinations')->filter()->sort()->values();

    // Stats - ensure we get fresh data
    $stats = [
        'total' => App\Models\Militant::count(),
        'pending' => App\Models\Militant::where('status', 'pending')->count(),
        'approved' => App\Models\Militant::where('status', 'approved')->count(),
        'rejected' => App\Models\Militant::where('status', 'rejected')->count(),
    ];

    $militants = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

    return view('administration.militants.index', compact('militants', 'coordinations', 'stats'));
})->name('test.admin.militants');

// Nouvelle route de test pour éviter le cache
Route::get('/test-militants-fresh', function() {
    $request = request();

    $query = App\Models\Militant::query();

    // Filter by status
    if ($request->filled('status') && $request->status !== 'all') {
        $query->where('status', $request->status);
    }

    // Filter by local coordination
    if ($request->filled('coordination') && $request->coordination !== 'all') {
        $query->where('coordinations', $request->coordination);
    }

    // Search by name, email, phone or card number
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('nom', 'like', "%$search%")
              ->orWhere('prenom', 'like', "%$search%")
              ->orWhere('name', 'like', "%$search%")
              ->orWhere('email', 'like', "%$search%")
              ->orWhere('n_cartes_syndicale', 'like', "%$search%")
              ->orWhere('tel', 'like', "%$search%");
        });
    }

    // Coordinations list - ensure we get fresh data
    $coordinations = App\Models\Militant::distinct()->pluck('coordinations')->filter()->sort()->values();

    // Stats - ensure we get fresh data
    $stats = [
        'total' => App\Models\Militant::count(),
        'pending' => App\Models\Militant::where('status', 'pending')->count(),
        'approved' => App\Models\Militant::where('status', 'approved')->count(),
        'rejected' => App\Models\Militant::where('status', 'rejected')->count(),
    ];

    $militants = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

    return view('administration.militants.index', compact('militants', 'coordinations', 'stats'));
})->name('test.militants.fresh');

// Test route with auth simulation
Route::get('/test-admin-auth', function() {
    // Simulate authentication
    $user = App\Models\User::find(1);
    if ($user) {
        Illuminate\Support\Facades\Auth::login($user);
    }

    return redirect('/administration/pages/militants');
})->name('test.admin.auth');

// Test route for debug page
Route::get('/test-militants-debug', function() {
    $query = App\Models\Militant::query();

    // Filter by status
    if (request()->filled('status') && request()->status !== 'all') {
        $query->where('status', request()->status);
    }

    // Filter by local coordination
    if (request()->filled('coordination') && request()->coordination !== 'all') {
        $query->where('coordinations', request()->coordination);
    }

    // Search by name, email, or card number
    if (request()->filled('search')) {
        $search = request()->search;
        $query->where(function($q) use ($search) {
            $q->where('nom', 'like', '%' . $search . '%')
              ->orWhere('prenom', 'like', '%' . $search . '%')
              ->orWhere('name', 'like', '%' . $search . '%')
              ->orWhere('email', 'like', '%' . $search . '%')
              ->orWhere('n_cartes_syndicale', 'like', '%' . $search . '%')
              ->orWhere('tel', 'like', '%' . $search . '%');
        });
    }

    // Get unique coordinations for filter dropdown
    $coordinations = App\Models\Militant::distinct()->pluck('coordinations')->filter()->sort();

    // Get statistics
    $stats = [
        'total' => App\Models\Militant::count(),
        'pending' => App\Models\Militant::where('status', 'pending')->count(),
        'approved' => App\Models\Militant::where('status', 'approved')->count(),
        'rejected' => App\Models\Militant::where('status', 'rejected')->count(),
    ];

    $militants = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

    return view('test.militants', compact('militants', 'coordinations', 'stats'));
})->name('test.militants.debug');

// Page d'accueil publique
Route::get('/', [AccueilController::class, 'index'])->name('accueil');

// Pages publiques
Route::get('/a-propos', [PageController::class, 'aPropos'])->name('a-propos');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

// Militant documents access (public access for approved militants)
Route::get('/militant/documents', [\App\Http\Controllers\MilitantDocumentController::class, 'accessForm'])->name('militant.documents.access');
Route::post('/militant/documents/verify', [\App\Http\Controllers\MilitantDocumentController::class, 'verifyAccess'])->name('militant.documents.verify');
Route::get('/militant/documents/list', [\App\Http\Controllers\MilitantDocumentController::class, 'index'])->name('militant.documents.index');
Route::get('/militant/documents/download/{filename}', [\App\Http\Controllers\MilitantDocumentController::class, 'download'])->name('militant.documents.download');
Route::post('/militant/documents/logout', [\App\Http\Controllers\MilitantDocumentController::class, 'logout'])->name('militant.documents.logout');
Route::get('/militant/test', [\App\Http\Controllers\MilitantDocumentController::class, 'testCategories'])->name('militant.test');

// Public route for militant membership submission
Route::post('/militant/submit', [\App\Http\Controllers\MilitantController::class, 'store'])->name('contact.submit.membership');
Route::post('/militant/messages', [MilitantMessageController::class, 'store'])->name('militant.messages.store');

Route::get('/mission', [PageController::class, 'mission'])->name('mission');
Route::get('/historique', [PageController::class, 'historique'])->name('historique');

// Documents publics - liste complète
Route::get('/documents', [\App\Http\Controllers\SiteWeb\DocumentController::class, 'index'])->name('site.documents.index');

// Routes d'authentification Breeze
Route::get('/connexion', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/connexion', [AuthenticatedSessionController::class, 'store']);
Route::post('/deconnexion', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Route dashboard par défaut
Route::get('/dashboard', function () {
    return redirect()->route('administration.tableau-de-bord');
})->middleware(['auth'])->name('dashboard');

Route::prefix('administration')->name('administration.')->middleware(['auth'])->group(function () {

    // Tableau de bord
    Route::get('/tableau-de-bord', [\App\Http\Controllers\Administration\TableauDeBordController::class, 'index'])->name('tableau-de-bord');

    
    // Publications
    Route::prefix('publications')->name('publications.')->group(function () {
        Route::get('/', function () {
            return view('administration.publications.liste');
        })->name('liste');

        Route::get('/creer', function () {
            return view('administration.publications.creer');
        })->name('creer');

        Route::get('/categories', function () {
            return view('administration.publications.categories');
        })->name('categories');

        Route::get('/carousels', function () {
            return view('administration.publications.carousels');
        })->name('carousels');
    });

    // Documents
    Route::prefix('documents')->name('documents.')->group(function () {
        Route::get('/', function () {
            return view('administration.documents.liste');
        })->name('liste');

        Route::get('/ajouter', function () {
            return view('administration.documents.ajouter');
        })->name('ajouter');

        Route::get('/categories', function () {
            return view('administration.documents.categories');
        })->name('categories');

        Route::get('/statistiques', function () {
            return view('administration.documents.statistiques');
        })->name('statistiques');
    });

    // Pages du site
    Route::prefix('pages')->name('pages.')->group(function () {
        Route::get('/accueil/edit', [\App\Http\Controllers\Administration\AdminAccueilController::class, 'edit'])->name('accueil.edit');
        Route::post('/accueil/update', [\App\Http\Controllers\Administration\AdminAccueilController::class, 'update'])->name('accueil.update');
        // Section-specific update routes
        Route::post('/accueil/update/carousel', [\App\Http\Controllers\Administration\AdminAccueilController::class, 'updateCarousel'])->name('accueil.update.carousel');
        Route::post('/accueil/update/about', [\App\Http\Controllers\Administration\AdminAccueilController::class, 'updateAbout'])->name('accueil.update.about');
        Route::post('/accueil/update/news', [\App\Http\Controllers\Administration\AdminAccueilController::class, 'updateNews'])->name('accueil.update.news');
        Route::post('/accueil/update/services', [\App\Http\Controllers\Administration\AdminAccueilController::class, 'updateServices'])->name('accueil.update.services');
        Route::post('/accueil/update/documents', [\App\Http\Controllers\Administration\AdminAccueilController::class, 'updateDocuments'])->name('accueil.update.documents');
        Route::get('/accueil', [\App\Http\Controllers\Administration\AdminAccueilController::class, 'edit'])->name('accueil');
        Route::delete('/accueil/document/{id}', [\App\Http\Controllers\Administration\AdminAccueilController::class, 'deleteDocument'])->name('accueil.document.delete');
        Route::put('/accueil/document/{id}', [\App\Http\Controllers\Administration\AdminAccueilController::class, 'updateDocument'])->name('accueil.document.update');
        Route::delete('/accueil/carousel/{id}', [\App\Http\Controllers\Administration\AdminAccueilController::class, 'deleteCarouselImage'])->name('accueil.carousel.delete');
        Route::put('/accueil/carousel/{id}', [\App\Http\Controllers\Administration\AdminAccueilController::class, 'updateCarouselImage'])->name('accueil.carousel.update');
        // Compte Rendu managed via its own POST endpoint
        Route::post('/accueil/compte-rendu/update', [\App\Http\Controllers\Administration\AdminAccueilController::class, 'updateCompteRendu'])->name('accueil.compte_rendu.update');
        Route::delete('/accueil/about-image', [\App\Http\Controllers\Administration\AdminAccueilController::class, 'deleteAboutImage'])->name('accueil.about_image.delete');

        // À propos
        Route::get('/a-propos/edit', [\App\Http\Controllers\Administration\AdminAproposController::class, 'edit'])->name('a-propos.edit');
        Route::post('/a-propos/update/presentation', [\App\Http\Controllers\Administration\AdminAproposController::class, 'updatePresentation'])->name('a-propos.update.presentation');
        Route::post('/a-propos/update/mission', [\App\Http\Controllers\Administration\AdminAproposController::class, 'updateMission'])->name('a-propos.update.mission');
        Route::post('/a-propos/update/image', [\App\Http\Controllers\Administration\AdminAproposController::class, 'updateImage'])->name('a-propos.update.image');
        Route::post('/a-propos/update/documents', [\App\Http\Controllers\Administration\AdminAproposController::class, 'updateDocuments'])->name('a-propos.update.documents');
        Route::delete('/a-propos/image', [\App\Http\Controllers\Administration\AdminAproposController::class, 'deleteImage'])->name('a-propos.image.delete');
        Route::delete('/a-propos/document/{id}', [\App\Http\Controllers\Administration\AdminAproposController::class, 'deleteDocument'])->name('a-propos.document.delete');
        // Route unique pour le formulaire global
        Route::post('/a-propos/update', [\App\Http\Controllers\Administration\AdminAproposController::class, 'update'])->name('a-propos.update');
        // Individual CRUD for timeline and team entries
        Route::delete('/a-propos/timeline/{index}', [\App\Http\Controllers\Administration\AdminAproposController::class, 'deleteTimeline'])->name('a-propos.timeline.delete');
        Route::put('/a-propos/timeline/{index}', [\App\Http\Controllers\Administration\AdminAproposController::class, 'updateTimelineEntry'])->name('a-propos.timeline.update');
        // Create timeline entry
        Route::post('/a-propos/timeline', [\App\Http\Controllers\Administration\AdminAproposController::class, 'createTimelineEntry'])->name('a-propos.timeline.create');

        Route::delete('/a-propos/team/{index}', [\App\Http\Controllers\Administration\AdminAproposController::class, 'deleteTeam'])->name('a-propos.team.delete');
        Route::put('/a-propos/team/{index}', [\App\Http\Controllers\Administration\AdminAproposController::class, 'updateTeamEntry'])->name('a-propos.team.update');
        // Create team member
        Route::post('/a-propos/team', [\App\Http\Controllers\Administration\AdminAproposController::class, 'createTeamEntry'])->name('a-propos.team.create');

        // Update stats independently
        Route::post('/a-propos/update/stats', [\App\Http\Controllers\Administration\AdminAproposController::class, 'updateStats'])->name('a-propos.update.stats');

        // Mission
        Route::get('/mission/edit', [\App\Http\Controllers\Administration\AdminMissionController::class, 'edit'])->name('mission.edit');
        Route::post('/mission/update/main', [\App\Http\Controllers\Administration\AdminMissionController::class, 'updateMain'])->name('mission.update.main');
        Route::post('/mission/update/image', [\App\Http\Controllers\Administration\AdminMissionController::class, 'updateImage'])->name('mission.update.image');
        Route::post('/mission/update/documents', [\App\Http\Controllers\Administration\AdminMissionController::class, 'updateDocuments'])->name('mission.update.documents');
        // Additional mission section endpoints used by the modal-first admin UI
        Route::post('/mission/update/header', [\App\Http\Controllers\Administration\AdminMissionController::class, 'updateHeader'])->name('mission.update.header');
        Route::post('/mission/update/items', [\App\Http\Controllers\Administration\AdminMissionController::class, 'updateItems'])->name('mission.update.items');
        Route::post('/mission/update/values', [\App\Http\Controllers\Administration\AdminMissionController::class, 'updateValues'])->name('mission.update.values');
        Route::post('/mission/update/cta', [\App\Http\Controllers\Administration\AdminMissionController::class, 'updateCta'])->name('mission.update.cta');
        Route::delete('/mission/image', [\App\Http\Controllers\Administration\AdminMissionController::class, 'deleteImage'])->name('mission.image.delete');
        Route::delete('/mission/document/{id}', [\App\Http\Controllers\Administration\AdminMissionController::class, 'deleteDocument'])->name('mission.document.delete');

        // Historique
        Route::get('/historique/edit', [\App\Http\Controllers\Administration\AdminHistoriqueController::class, 'edit'])->name('historique.edit');
        Route::post('/historique/update/main', [\App\Http\Controllers\Administration\AdminHistoriqueController::class, 'updateMain'])->name('historique.update.main');
        Route::post('/historique/update/image', [\App\Http\Controllers\Administration\AdminHistoriqueController::class, 'updateImage'])->name('historique.update.image');
        Route::post('/historique/update/documents', [\App\Http\Controllers\Administration\AdminHistoriqueController::class, 'updateDocuments'])->name('historique.update.documents');
        Route::delete('/historique/image', [\App\Http\Controllers\Administration\AdminHistoriqueController::class, 'deleteImage'])->name('historique.image.delete');
        Route::delete('/historique/document/{id}', [\App\Http\Controllers\Administration\AdminHistoriqueController::class, 'deleteDocument'])->name('historique.document.delete');
        // Events CRUD for historique
        Route::post('/historique/events', [\App\Http\Controllers\Administration\AdminHistoriqueController::class, 'store'])->name('historique.events.store');
        Route::put('/historique/events/{id}', [\App\Http\Controllers\Administration\AdminHistoriqueController::class, 'update'])->name('historique.events.update');
        Route::delete('/historique/events/{id}', [\App\Http\Controllers\Administration\AdminHistoriqueController::class, 'destroy'])->name('historique.events.destroy');
        Route::post('/historique/events/reorder', [\App\Http\Controllers\Administration\AdminHistoriqueController::class, 'reorder'])->name('historique.events.reorder');
        // Milestones (Nos Réalisations)
        Route::post('/historique/milestones', [\App\Http\Controllers\Administration\AdminHistoriqueController::class, 'storeMilestone'])->name('historique.milestones.store');
        Route::put('/historique/milestones/{id}', [\App\Http\Controllers\Administration\AdminHistoriqueController::class, 'updateMilestone'])->name('historique.milestones.update');
        Route::delete('/historique/milestones/{id}', [\App\Http\Controllers\Administration\AdminHistoriqueController::class, 'destroyMilestone'])->name('historique.milestones.destroy');
        Route::post('/historique/milestones/reorder', [\App\Http\Controllers\Administration\AdminHistoriqueController::class, 'reorderMilestones'])->name('historique.milestones.reorder');

        // Archives
        Route::post('/historique/archives', [\App\Http\Controllers\Administration\AdminHistoriqueController::class, 'storeArchive'])->name('historique.archives.store');
        Route::put('/historique/archives/{id}', [\App\Http\Controllers\Administration\AdminHistoriqueController::class, 'updateArchive'])->name('historique.archives.update');
        Route::delete('/historique/archives/{id}', [\App\Http\Controllers\Administration\AdminHistoriqueController::class, 'destroyArchive'])->name('historique.archives.destroy');
        Route::post('/historique/archives/reorder', [\App\Http\Controllers\Administration\AdminHistoriqueController::class, 'reorderArchives'])->name('historique.archives.reorder');

        // Contact
        Route::get('/contact/edit', [\App\Http\Controllers\Administration\AdminContactController::class, 'edit'])->name('contact.edit');
        Route::post('/contact/update/infos', [\App\Http\Controllers\Administration\AdminContactController::class, 'updateInfos'])->name('contact.update.infos');
        Route::post('/contact/update/image', [\App\Http\Controllers\Administration\AdminContactController::class, 'updateImage'])->name('contact.update.image');
        Route::post('/contact/update/documents', [\App\Http\Controllers\Administration\AdminContactController::class, 'updateDocuments'])->name('contact.update.documents');
        Route::delete('/contact/image', [\App\Http\Controllers\Administration\AdminContactController::class, 'deleteImage'])->name('contact.image.delete');
        Route::delete('/contact/document/{id}', [\App\Http\Controllers\Administration\AdminContactController::class, 'deleteDocument'])->name('contact.document.delete');

        // Contact carousel CRUD
        Route::post('/contact/carousels', [\App\Http\Controllers\Administration\AdminContactController::class, 'storeCarousel'])->name('contact.carousels.store');
        Route::put('/contact/carousels/{id}', [\App\Http\Controllers\Administration\AdminContactController::class, 'updateCarousel'])->name('contact.carousels.update');
        Route::get('/contact/carousels/{id}', [\App\Http\Controllers\Administration\AdminContactController::class, 'showCarousel'])->name('contact.carousels.show');
        Route::delete('/contact/carousels/{id}', [\App\Http\Controllers\Administration\AdminContactController::class, 'deleteCarousel'])->name('contact.carousels.delete');
        Route::post('/contact/carousels/reorder', [\App\Http\Controllers\Administration\AdminContactController::class, 'reorderCarousels'])->name('contact.carousels.reorder');

        // Contact infos CRUD
        Route::post('/contact/infos', [\App\Http\Controllers\Administration\AdminContactController::class, 'storeInfo'])->name('contact.infos.store');
        Route::put('/contact/infos/{id}', [\App\Http\Controllers\Administration\AdminContactController::class, 'updateInfo'])->name('contact.infos.update');
        Route::delete('/contact/infos/{id}', [\App\Http\Controllers\Administration\AdminContactController::class, 'deleteInfo'])->name('contact.infos.delete');
        Route::post('/contact/infos/reorder', [\App\Http\Controllers\Administration\AdminContactController::class, 'reorderInfos'])->name('contact.infos.reorder');

        // Hours CRUD
        Route::post('/contact/hours', [\App\Http\Controllers\Administration\AdminContactController::class, 'storeHour'])->name('contact.hours.store');
        Route::put('/contact/hours/{id}', [\App\Http\Controllers\Administration\AdminContactController::class, 'updateHour'])->name('contact.hours.update');
        Route::delete('/contact/hours/{id}', [\App\Http\Controllers\Administration\AdminContactController::class, 'deleteHour'])->name('contact.hours.delete');
        Route::post('/contact/hours/reorder', [\App\Http\Controllers\Administration\AdminContactController::class, 'reorderHours'])->name('contact.hours.reorder');

        // FAQ CRUD
        Route::post('/contact/faqs', [\App\Http\Controllers\Administration\AdminContactController::class, 'storeFaq'])->name('contact.faqs.store');
        Route::put('/contact/faqs/{id}', [\App\Http\Controllers\Administration\AdminContactController::class, 'updateFaq'])->name('contact.faqs.update');
        Route::delete('/contact/faqs/{id}', [\App\Http\Controllers\Administration\AdminContactController::class, 'deleteFaq'])->name('contact.faqs.delete');
        Route::post('/contact/faqs/reorder', [\App\Http\Controllers\Administration\AdminContactController::class, 'reorderFaqs'])->name('contact.faqs.reorder');

        // Map update
        Route::post('/contact/map', [\App\Http\Controllers\Administration\AdminContactController::class, 'updateMap'])->name('contact.map.update');

        // Contact submissions (public requests to become militant)
        Route::get('/contact/submissions', [\App\Http\Controllers\Administration\AdminContactSubmissionsController::class, 'index'])->name('contact.submissions.index');
        Route::get('/contact/submissions/{id}', [\App\Http\Controllers\Administration\AdminContactSubmissionsController::class, 'show'])->name('contact.submissions.show');
        Route::get('/contact/submissions/{id}/attachment', [\App\Http\Controllers\Administration\AdminContactSubmissionsController::class, 'attachment'])->name('administration.contact.submission.attachment');
        Route::post('/contact/submissions/{id}/approve', [\App\Http\Controllers\Administration\AdminContactSubmissionsController::class, 'approve'])->name('contact.submissions.approve');
        Route::post('/contact/submissions/{id}/reject', [\App\Http\Controllers\Administration\AdminContactSubmissionsController::class, 'reject'])->name('contact.submissions.reject');

        // Militants management
        Route::get('/militants', [\App\Http\Controllers\MilitantController::class, 'index'])->name('militants.index');
        Route::get('/militants/export/excel', [\App\Http\Controllers\MilitantController::class, 'exportExcel'])->name('militants.export.excel');
        Route::get('/militants/export/word', [\App\Http\Controllers\MilitantController::class, 'exportWord'])->name('militants.export.word');
        Route::get('/militants/{militant}', [\App\Http\Controllers\MilitantController::class, 'show'])->name('militants.show');
        Route::patch('/militants/{militant}/status', [\App\Http\Controllers\MilitantController::class, 'updateStatus'])->name('militants.update-status');
        Route::patch('/militants/{militant}/status-ajax', [\App\Http\Controllers\MilitantController::class, 'updateStatusAjax'])->name('militants.update-status-ajax');

        Route::get('/militant-messages', [MilitantMessageController::class, 'adminIndex'])->name('militant-messages.index');
        Route::post('/militant-messages/{message}/reply', [MilitantMessageController::class, 'reply'])->name('militant-messages.reply');
    });

    // Médiathèque
    Route::prefix('mediatheque')->name('mediatheque.')->group(function () {
        Route::get('/images', function () {
            return view('administration.mediatheque.images');
        })->name('images');

        Route::get('/documents', function () {
            return view('administration.mediatheque.documents');
        })->name('documents');

        Route::get('/upload', function () {
            return view('administration.mediatheque.upload');
        })->name('upload');
    });

   // Paramètres
    Route::prefix('parametres')->name('parametres.')->group(function () {
        Route::get('/', function () {
            return redirect()->route('administration.parametres.utilisateurs');
        })->name('index');

        // Route pour la gestion des utilisateurs dans les paramètres
        Route::get('/utilisateurs', [UtilisateurController::class, 'index'])->name('utilisateurs');
        
        // Routes CRUD pour les utilisateurs
        Route::post('/utilisateurs', [UtilisateurController::class, 'store'])->name('utilisateurs.store');
        Route::put('/utilisateurs/{id}', [UtilisateurController::class, 'update'])->name('utilisateurs.update');
        Route::delete('/utilisateurs/{id}', [UtilisateurController::class, 'destroy'])->name('utilisateurs.destroy');
        Route::post('/utilisateurs/{id}/toggle-status', [UtilisateurController::class, 'toggleStatus'])->name('utilisateurs.toggle-status');

        Route::get('/topbar', [\App\Http\Controllers\Administration\AdminTopbarController::class, 'edit'])->name('topbar');
        Route::post('/topbar/update', [\App\Http\Controllers\Administration\AdminTopbarController::class, 'update'])->name('topbar.update');

        Route::get('/footer', [\App\Http\Controllers\Administration\AdminFooterController::class, 'edit'])->name('footer');
        Route::post('/footer/update', [\App\Http\Controllers\Administration\AdminFooterController::class, 'update'])->name('footer.update');
        Route::delete('/footer/gallery-image/{index}', [\App\Http\Controllers\Administration\AdminFooterController::class, 'deleteGalleryImage'])->name('footer.gallery_image.delete');
    });

    Route::post('/administration/pages/a-propos/update', [App\Http\Controllers\Administration\AdminAproposController::class, 'update'])
    ->name('administration.pages.a-propos.update');
});

// Profile routes (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';