<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteWeb\AccueilController;
use App\Http\Controllers\SiteWeb\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Administration\UtilisateurController;

// Page d'accueil publique
Route::get('/', [AccueilController::class, 'index'])->name('accueil');

// Pages publiques
Route::get('/a-propos', [PageController::class, 'aPropos'])->name('a-propos');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/mission', [PageController::class, 'mission'])->name('mission');
Route::get('/historique', [PageController::class, 'historique'])->name('historique');

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
    Route::get('/tableau-de-bord', function () {
        $stats = [
            'publications_total' => 0,
            'membres_total' => 1,
            'documents_total' => 0,
            'evenements_prochains' => 0,
        ];

        $activites_recentes = [];
        $publications_recentes = [];

        return view('administration.pages.tableau-de-bord', compact('stats', 'activites_recentes', 'publications_recentes'));
    })->name('tableau-de-bord');

    
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
        Route::post('/accueil/update/documents', [\App\Http\Controllers\Administration\AdminAccueilController::class, 'updateDocuments'])->name('accueil.update.documents');
        Route::get('/accueil', [\App\Http\Controllers\Administration\AdminAccueilController::class, 'edit'])->name('accueil');
        Route::delete('/accueil/document/{id}', [\App\Http\Controllers\Administration\AdminAccueilController::class, 'deleteDocument'])->name('accueil.document.delete');
        Route::put('/accueil/document/{id}', [\App\Http\Controllers\Administration\AdminAccueilController::class, 'updateDocument'])->name('accueil.document.update');
        Route::delete('/accueil/carousel/{id}', [\App\Http\Controllers\Administration\AdminAccueilController::class, 'deleteCarouselImage'])->name('accueil.carousel.delete');
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
        Route::delete('/mission/image', [\App\Http\Controllers\Administration\AdminMissionController::class, 'deleteImage'])->name('mission.image.delete');
        Route::delete('/mission/document/{id}', [\App\Http\Controllers\Administration\AdminMissionController::class, 'deleteDocument'])->name('mission.document.delete');

        // Historique
        Route::get('/historique/edit', [\App\Http\Controllers\Administration\AdminHistoriqueController::class, 'edit'])->name('historique.edit');
        Route::post('/historique/update/main', [\App\Http\Controllers\Administration\AdminHistoriqueController::class, 'updateMain'])->name('historique.update.main');
        Route::post('/historique/update/image', [\App\Http\Controllers\Administration\AdminHistoriqueController::class, 'updateImage'])->name('historique.update.image');
        Route::post('/historique/update/documents', [\App\Http\Controllers\Administration\AdminHistoriqueController::class, 'updateDocuments'])->name('historique.update.documents');
        Route::delete('/historique/image', [\App\Http\Controllers\Administration\AdminHistoriqueController::class, 'deleteImage'])->name('historique.image.delete');
        Route::delete('/historique/document/{id}', [\App\Http\Controllers\Administration\AdminHistoriqueController::class, 'deleteDocument'])->name('historique.document.delete');

        // Contact
        Route::get('/contact/edit', [\App\Http\Controllers\Administration\AdminContactController::class, 'edit'])->name('contact.edit');
        Route::post('/contact/update/infos', [\App\Http\Controllers\Administration\AdminContactController::class, 'updateInfos'])->name('contact.update.infos');
        Route::post('/contact/update/image', [\App\Http\Controllers\Administration\AdminContactController::class, 'updateImage'])->name('contact.update.image');
        Route::post('/contact/update/documents', [\App\Http\Controllers\Administration\AdminContactController::class, 'updateDocuments'])->name('contact.update.documents');
        Route::delete('/contact/image', [\App\Http\Controllers\Administration\AdminContactController::class, 'deleteImage'])->name('contact.image.delete');
        Route::delete('/contact/document/{id}', [\App\Http\Controllers\Administration\AdminContactController::class, 'deleteDocument'])->name('contact.document.delete');
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
            return redirect()->route('administration.parametres.generaux');
        })->name('index');

        Route::get('/generaux', function () {
            return view('administration.parametres.index', [
                'section_active' => 'generaux',
                'contenu' => 'administration.parametres.sections.generaux'
            ]);
        })->name('generaux');

        Route::get('/seo', function () {
            return view('administration.parametres.index', [
                'section_active' => 'seo',
                'contenu' => 'administration.parametres.sections.seo'
            ]);
        })->name('seo');

        // Route pour la gestion des utilisateurs dans les paramètres
        Route::get('/utilisateurs', [UtilisateurController::class, 'index'])->name('utilisateurs');
        
        // Routes CRUD pour les utilisateurs
        Route::post('/utilisateurs', [UtilisateurController::class, 'store'])->name('utilisateurs.store');
        Route::put('/utilisateurs/{id}', [UtilisateurController::class, 'update'])->name('utilisateurs.update');
        Route::delete('/utilisateurs/{id}', [UtilisateurController::class, 'destroy'])->name('utilisateurs.destroy');
        Route::post('/utilisateurs/{id}/toggle-status', [UtilisateurController::class, 'toggleStatus'])->name('utilisateurs.toggle-status');

        Route::get('/reseaux-sociaux', function () {
            return view('administration.parametres.index', [
                'section_active' => 'reseaux-sociaux',
                'contenu' => 'administration.parametres.sections.reseaux-sociaux'
            ]);
        })->name('reseaux-sociaux');

        Route::get('/notifications', function () {
            return view('administration.parametres.index', [
                'section_active' => 'notifications',
                'contenu' => 'administration.parametres.sections.notifications'
            ]);
        })->name('notifications');
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