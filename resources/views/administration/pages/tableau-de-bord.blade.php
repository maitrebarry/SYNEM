@extends('layouts.administration')

@section('title', 'Tableau de bord')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Tableau de bord</h1>
    <div class="btn-group">
        <button class="btn btn-outline-secondary">
            <i class="bi bi-calendar me-1"></i>Ce mois
        </button>
        <button class="btn btn-primary">
            <i class="bi bi-arrow-clockwise me-1"></i>Actualiser
        </button>
    </div>
</div>

<!-- Cartes de statistiques -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $stats['publications_total'] ?? 0 }}</h4>
                        <p class="mb-0">Publications</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-newspaper fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $stats['membres_total'] ?? 0 }}</h4>
                        <p class="mb-0">Membres</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-people fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $stats['documents_total'] ?? 0 }}</h4>
                        <p class="mb-0">Documents</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-files fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $stats['evenements_prochains'] ?? 0 }}</h4>
                        <p class="mb-0">Événements</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-calendar-event fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Contenu supplémentaire -->
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Bienvenue dans l'administration SYNEM</h5>
                <p class="card-text">Vous êtes connecté en tant qu'administrateur. Utilisez le menu de gauche pour gérer le contenu du site.</p>
                <div class="alert alert-info">
                    <strong>Prochaines étapes :</strong>
                    <ul class="mb-0 mt-2">
                        <li>Créer votre première publication</li>
                        <li>Ajouter des documents pour les membres</li>
                        <li>Planifier des événements</li>
                        <li>Gérer les utilisateurs</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Actions rapides</h5>
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary">Nouvelle publication</button>
                    <button class="btn btn-outline-success">Ajouter un document</button>
                    <button class="btn btn-outline-warning">Créer un événement</button>
                    <button class="btn btn-outline-info">Voir les statistiques</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection