<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteWeb\AccueilController;
use App\Http\Controllers\SiteWeb\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

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

// Administration - Protection par auth
Route::prefix('administration')->name('administration.')->middleware(['auth'])->group(function () {
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
});

// Profile routes (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Inclure les autres routes d'authentification
require __DIR__.'/auth.php';