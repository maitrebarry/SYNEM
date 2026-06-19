<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TableauDeBordController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $startOfMonth = Carbon::now()->startOfMonth();
        $visitorsEnabled = Schema::hasTable('visitors');

        // Statistiques dynamiques depuis la base de données
        $stats = [
            'utilisateurs_total' => DB::table('users')->where('role', '!=', 'superadmin')->count(),
            'publications_total' => DB::table('homepage_contents')->whereNotNull('news_items')->where('news_items', '!=', '')->count(),
            'documents_total' => DB::table('homepage_documents')->count(),
            'soumissions_contact' => DB::table('contact_submissions')->count(),
            'images_carousel' => DB::table('homepage_carousel_images')->count(),
            'evenements_historique' => DB::table('historique_events')->count(),
            'visiteurs_total' => $visitorsEnabled ? Visitor::count() : 0,
            'visiteurs_aujourdhui' => $visitorsEnabled ? Visitor::where('visited_at', '>=', $today)->count() : 0,
            'visiteurs_semaine' => $visitorsEnabled ? Visitor::where('visited_at', '>=', $startOfWeek)->count() : 0,
            'visiteurs_mois' => $visitorsEnabled ? Visitor::where('visited_at', '>=', $startOfMonth)->count() : 0,
        ];

        // Activités récentes (derniers éléments créés/modifiés)
        $activites_recentes = [];

        // Publications récentes (not implemented yet)
        $publications = collect();

        foreach ($publications as $pub) {
            $activites_recentes[] = [
                'type' => 'Publication',
                'type_color' => 'primary',
                'description' => 'Nouvelle publication: ' . substr($pub->title ?? 'Sans titre', 0, 30) . '...',
                'date' => $pub->created_at,
                'utilisateur' => 'Admin SYNEM',
                'icon' => 'bx bx-news'
            ];
        }

        // Documents récents
        $documents = DB::table('homepage_documents')
            ->orderBy('created_at', 'desc')
            ->limit(2)
            ->get();

        foreach ($documents as $doc) {
            $activites_recentes[] = [
                'type' => 'Document',
                'type_color' => 'success',
                'description' => 'Nouveau document ajouté: ' . ($doc->title ?? 'Document'),
                'date' => $doc->created_at,
                'utilisateur' => 'Admin SYNEM',
                'icon' => 'bx bx-file'
            ];
        }

        // Soumissions de contact récentes
        $contacts = DB::table('contact_submissions')
            ->orderBy('created_at', 'desc')
            ->limit(2)
            ->get();

        foreach ($contacts as $contact) {
            $activites_recentes[] = [
                'type' => 'Contact',
                'type_color' => 'info',
                'description' => 'Nouvelle soumission: ' . ($contact->subject ?? 'Message'),
                'date' => $contact->created_at,
                'utilisateur' => $contact->name ?? 'Anonyme',
                'icon' => 'bx bx-envelope'
            ];
        }

        // Trier par date et limiter à 8 éléments
        $activites_recentes = collect($activites_recentes)
            ->sortByDesc('date')
            ->take(8)
            ->values()
            ->all();

        // Publications récentes avec plus de détails (not implemented yet)
        $publications_recentes = collect();

        return view('administration.pages.tableau-de-bord', compact('stats', 'activites_recentes', 'publications_recentes'));
    }
}