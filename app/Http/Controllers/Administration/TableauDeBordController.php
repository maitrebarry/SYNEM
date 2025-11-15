<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TableauDeBordController extends Controller
{
    public function index()
    {
        // Statistiques factices pour la démo
        $stats = [
            'publications_total' => 24,
            'membres_total' => 156,
            'documents_total' => 42,
            'evenements_prochains' => 5,
        ];

        $activites_recentes = [
            [
                'type' => 'Publication',
                'type_color' => 'primary',
                'description' => 'Nouvelle actualité publiée',
                'date' => '2024-01-15 10:30',
                'utilisateur' => 'Admin SYNEM'
            ],
            [
                'type' => 'Document',
                'type_color' => 'success',
                'description' => 'Document administratif ajouté',
                'date' => '2024-01-14 14:20',
                'utilisateur' => 'Admin SYNEM'
            ],
            [
                'type' => 'Membre',
                'type_color' => 'info',
                'description' => 'Nouveau membre inscrit',
                'date' => '2024-01-14 09:15',
                'utilisateur' => 'Système'
            ],
        ];

        $publications_recentes = [
            [
                'id' => 1,
                'titre' => 'Assemblée générale annuelle',
                'contenu' => 'Invitation à l\'assemblée générale du syndicat...',
                'date' => '2024-01-15',
                'statut' => 'Publié',
                'statut_color' => 'success'
            ],
            [
                'id' => 2,
                'titre' => 'Nouvelles mesures éducatives',
                'contenu' => 'Informations sur les nouvelles réformes...',
                'date' => '2024-01-14',
                'statut' => 'Brouillon',
                'statut_color' => 'warning'
            ],
        ];

        return view('administration.pages.tableau-de-bord', compact('stats', 'activites_recentes', 'publications_recentes'));
    }
}