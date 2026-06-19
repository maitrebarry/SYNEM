@extends('layouts.administration')

@section('title', 'Cartes de membres')

@section('breadcrumb')
<div class="page-breadcrumb d-flex align-items-center">
    <div class="breadcrumb-title pe-3">Militants</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('administration.tableau-de-bord') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item active">Cartes de membres</li>
            </ol>
        </nav>
    </div>
</div>
@endsection

@section('styles')
<style>
/* ═══ ONGLETS DE NAVIGATION ═══════════════════════════════ */
.step-tabs .nav-link {
    border: 2px solid #dee2e6;
    border-radius: 12px;
    padding: 14px 18px;
    color: #6c757d;
    background: #fff;
    transition: all .2s;
    text-align: center;
}
.step-tabs .nav-link:hover {
    border-color: #0d6efd;
    color: #0d6efd;
    background: #f0f5ff;
}
.step-tabs .nav-link.active {
    background: #0d6efd;
    border-color: #0d6efd;
    color: #fff;
    box-shadow: 0 4px 14px rgba(13,110,253,.3);
}
.step-tabs .nav-link .step-icon {
    font-size: 1.5rem;
    display: block;
    margin-bottom: 4px;
}
.step-tabs .nav-link .step-label {
    font-size: .82rem;
    font-weight: 600;
    display: block;
}
.step-tabs .nav-link .step-sub {
    font-size: .72rem;
    opacity: .75;
    display: block;
}
.step-tabs .nav-link.active .step-sub { opacity: .85; }

/* ═══ SECTION TITRES ═══════════════════════════════════════ */
.section-icon-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: .95rem;
    font-weight: 700;
    color: #212529;
    margin-bottom: 1rem;
}
.section-icon-title .icon-circle {
    width: 36px; height: 36px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: .9rem;
    flex-shrink: 0;
}
.section-icon-title .desc {
    font-size: .78rem;
    font-weight: 400;
    color: #6c757d;
}

/* ═══ MEMBRES – SÉLECTEUR ══════════════════════════════════ */
.member-selector-grid { max-height: 300px; overflow-y: auto; }
.member-selector-item {
    border: 2px solid #dee2e6;
    border-radius: 8px;
    padding: 8px 10px;
    cursor: pointer;
    transition: all .15s;
    display: flex;
    align-items: center;
    gap: 8px;
    background: #fff;
}
.member-selector-item:hover { border-color: #0d6efd; background: #f0f5ff; }
.member-selector-item.is-selected {
    border-color: #0d6efd;
    background: #e8f0fe;
}
.member-selector-item .member-avatar {
    width: 34px; height: 34px;
    border-radius: 50%;
    background: #e9ecef;
    display: flex; align-items: center; justify-content: center;
    font-size: .8rem; color: #495057;
    flex-shrink: 0;
    font-weight: 700;
}

/* ═══ APERÇU CARTE PHYSIQUE ════════════════════════════════ */
.mc-preview-shell {
    background: #ffffff;
    border: 2.5px solid #1a3a6b;
    border-radius: 10px;
    overflow: hidden;
    font-family: Arial, sans-serif;
    max-width: 320px;
    box-shadow: 0 4px 16px rgba(0,0,0,.12);
}
.mc-header {
    display: flex;
    align-items: center;
    padding: 8px 12px 5px;
    background: #fff;
}
.mc-logo { width: 32px; height: 32px; object-fit: contain; flex-shrink: 0; }
.mc-title { flex: 1; text-align: center; font-size: 8.5px; font-weight: 700; color: #C8102E; text-transform: uppercase; letter-spacing: .3px; }
.mc-title-spacer { width: 32px; flex-shrink: 0; }
.mc-flagband { display: flex; height: 6px; }
.mc-flagband span { flex: 1; display: block; }
.mc-cardnum { text-align: center; padding: 4px 12px; font-size: 11px; font-weight: 800; color: #C8102E; text-transform: uppercase; background: #fff; border-bottom: 1px solid #e5e7eb; letter-spacing: .4px; }
.mc-body { display: flex; padding: 8px 10px; gap: 8px; align-items: flex-start; background: #fff; }
.mc-fields { flex: 1; }
.mc-field { font-size: 9px; line-height: 1.6; border-bottom: .5px solid #9ca3af; margin-bottom: 3px; padding-bottom: 2px; color: #111827; }
.mc-field b { font-size: 8.5px; }
.mc-photo { width: 64px; height: 80px; object-fit: cover; border: 1px solid #9ca3af; flex-shrink: 0; }
.mc-photo-placeholder { width: 64px; height: 80px; background: #f3f4f6; border: 1px dashed #9ca3af; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 8px; color: #9ca3af; text-align: center; }
.mc-footer { display: flex; align-items: flex-end; gap: 6px; padding: 6px 10px 8px; border-top: 1px solid #e5e7eb; background: #fff; }
.mc-price { flex: 1; }
.mc-price-label { font-size: 9px; font-weight: 700; color: #111827; display: block; }
.mc-tel { font-size: 8.5px; color: #374151; display: block; border-bottom: .5px solid #9ca3af; }
.mc-secretary { text-align: right; }
.mc-sec-title { font-size: 7.5px; text-transform: uppercase; color: #6b7280; display: block; }
.mc-sec-sig { max-width: 64px; max-height: 20px; object-fit: contain; display: block; margin: 2px 0 2px auto; }
.mc-sec-sig-text { font-size: 10px; font-style: italic; font-weight: 700; display: block; text-align: right; }
.mc-sec-name { font-size: 8.5px; font-weight: 700; color: #111827; display: block; }
.mc-qr { flex-shrink: 0; }
.mc-qr img { width: 48px; height: 48px; object-fit: contain; display: block; }

/* ═══ SIGNATURE PAD ════════════════════════════════════════ */
.signature-pad-shell {
    border: 2px dashed #94a3b8;
    border-radius: 10px;
    background: #fff;
    position: relative;
    overflow: hidden;
}
.signature-pad {
    width: 100%; height: 140px;
    display: block; cursor: crosshair;
    touch-action: none;
    background-image: linear-gradient(to bottom, transparent 31px, #eef2f7 32px);
    background-size: 100% 32px;
}
.signature-pad-shell::before {
    content: 'Dessinez la signature ici';
    position: absolute; top: .6rem; left: .9rem;
    font-size: .78rem; color: #94a3b8; pointer-events: none;
}
.signature-preview { max-width: 180px; max-height: 60px; object-fit: contain; background: #fff; border: 1px solid #dbe2ea; border-radius: .5rem; padding: .3rem; }
.signature-live-preview { width: 200px; max-width: 100%; height: 70px; object-fit: contain; background: #fff; border: 1px solid #dbe2ea; border-radius: .5rem; padding: .3rem; }
.signature-text-preview { min-height: 48px; display: flex; align-items: center; padding: .3rem .75rem; background: #fff; border: 1px solid #dbe2ea; border-radius: .5rem; font-size: 1.4rem; font-style: italic; color: #0f172a; }
.signature-status { font-size: .82rem; }

/* ═══ OPTIONS CHECKBOX ═════════════════════════════════════ */
.option-check-card {
    border: 2px solid #dee2e6;
    border-radius: 10px;
    padding: 10px 14px;
    cursor: pointer;
    transition: all .15s;
    display: flex;
    align-items: center;
    gap: 10px;
    background: #fff;
}
.option-check-card:hover { border-color: #0d6efd; background: #f0f5ff; }
.option-check-card input:checked ~ * { color: #0d6efd; }
.option-check-card.checked { border-color: #0d6efd; background: #e8f0fe; }
.option-check-card .oc-icon { font-size: 1.1rem; width: 28px; text-align: center; flex-shrink: 0; }
.option-check-card .oc-text strong { font-size: .83rem; display: block; }
.option-check-card .oc-text small { font-size: .73rem; color: #6c757d; }
</style>
@endsection

@section('content')

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- STATISTIQUES RAPIDES                                    --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div style="width:48px;height:48px;background:#e8f0fe;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0;">👥</div>
                <div>
                    <div class="text-muted" style="font-size:.75rem;">Militants approuvés</div>
                    <div class="fs-4 fw-bold">{{ $stats['approved_militants'] }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div style="width:48px;height:48px;background:#fff3cd;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0;">📷</div>
                <div>
                    <div class="text-muted" style="font-size:.75rem;">Photos reçues</div>
                    <div class="fs-4 fw-bold">{{ $stats['received_submissions'] }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div style="width:48px;height:48px;background:#d1e7dd;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0;">✅</div>
                <div>
                    <div class="text-muted" style="font-size:.75rem;">Photos validées</div>
                    <div class="fs-4 fw-bold">{{ $stats['approved_cards'] }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div style="width:48px;height:48px;background:#f8d7da;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0;">⏳</div>
                <div>
                    <div class="text-muted" style="font-size:.75rem;">En attente</div>
                    <div class="fs-4 fw-bold">{{ $stats['pending_cards'] }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- NAVIGATION PAR ONGLETS                                  --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<ul class="nav step-tabs gap-2 mb-4" id="cardMainTabs" role="tablist">
    <li class="nav-item flex-fill">
        <a class="nav-link active" id="tab-campagne-link" data-bs-toggle="pill" href="#tab-campagne" role="tab">
            <span class="step-icon">📤</span>
            <span class="step-label">Demander des photos</span>
            <span class="step-sub">Envoyer une demande aux membres</span>
        </a>
    </li>
    <li class="nav-item flex-fill">
        <a class="nav-link" id="tab-photos-link" data-bs-toggle="pill" href="#tab-photos" role="tab">
            <span class="step-icon">📋
                @if($stats['pending_cards'] > 0)
                    <span class="badge bg-warning text-dark" style="font-size:.55rem;vertical-align:top;">{{ $stats['pending_cards'] }}</span>
                @endif
            </span>
            <span class="step-label">Valider les photos</span>
            <span class="step-sub">Approuver les photos reçues</span>
        </a>
    </li>
    <li class="nav-item flex-fill">
        <a class="nav-link" id="tab-imprimer-link" data-bs-toggle="pill" href="#tab-imprimer" role="tab">
            <span class="step-icon">🖨️
                @if($eligibleCards->count() > 0)
                    <span class="badge bg-success" style="font-size:.55rem;vertical-align:top;">{{ $eligibleCards->count() }}</span>
                @endif
            </span>
            <span class="step-label">Imprimer les cartes</span>
            <span class="step-sub">Générer et exporter en PDF</span>
        </a>
    </li>
    <li class="nav-item flex-fill">
        <a class="nav-link" id="tab-config-link" data-bs-toggle="pill" href="#tab-config" role="tab">
            <span class="step-icon">⚙️</span>
            <span class="step-label">Signature & Apparence</span>
            <span class="step-sub">Configurer le modèle de carte</span>
        </a>
    </li>
</ul>

<div class="tab-content" id="cardMainTabsContent">

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- ONGLET 1 : DEMANDER DES PHOTOS                          --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<div class="tab-pane fade show active" id="tab-campagne" role="tabpanel">
    <div class="row g-4">

        {{-- Campagne active --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="section-icon-title">
                        <div class="icon-circle" style="background:#fff3cd;">📡</div>
                        <div>
                            Campagne en cours
                            <div class="desc">Statut de la dernière demande envoyée</div>
                        </div>
                    </div>

                    @if($activeCampaign)
                        <div class="alert alert-success border-0 mb-3">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge bg-success">Active</span>
                                <strong>{{ $activeCampaign->title }}</strong>
                            </div>
                            <div class="text-muted small mb-3">Envoyée le {{ optional($activeCampaign->sent_at)->format('d/m/Y à H:i') }}</div>
                            <p class="mb-3 small">{{ $activeCampaign->message }}</p>
                            <div class="row g-2 text-center mb-3">
                                <div class="col-3">
                                    <div class="fw-bold fs-5">{{ $activeCampaign->submissions_count }}</div>
                                    <div class="text-muted" style="font-size:.7rem;">Photos reçues</div>
                                </div>
                                <div class="col-3">
                                    <div class="fw-bold fs-5 text-warning">{{ $activeCampaign->pending_submissions_count }}</div>
                                    <div class="text-muted" style="font-size:.7rem;">À valider</div>
                                </div>
                                <div class="col-3">
                                    <div class="fw-bold fs-5 text-success">{{ $activeCampaign->approved_submissions_count }}</div>
                                    <div class="text-muted" style="font-size:.7rem;">Validées</div>
                                </div>
                                <div class="col-3">
                                    <div class="fw-bold fs-5 text-danger">{{ $activeCampaign->revision_submissions_count }}</div>
                                    <div class="text-muted" style="font-size:.7rem;">À reprendre</div>
                                </div>
                            </div>
                            <form action="{{ route('administration.pages.cartes-membres.campaigns.close', $activeCampaign) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-outline-danger btn-sm w-100" type="submit">
                                    <i class="fas fa-stop-circle me-1"></i>Clôturer cette campagne
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <div style="font-size:2.5rem;">📭</div>
                            <div class="mt-2">Aucune campagne active pour le moment.</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Lancer une nouvelle campagne --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="section-icon-title">
                        <div class="icon-circle" style="background:#e8f0fe;">📨</div>
                        <div>
                            Lancer une nouvelle demande
                            <div class="desc">Un message sera envoyé à tous les militants approuvés pour qu'ils envoient leur photo</div>
                        </div>
                    </div>

                    <form action="{{ route('administration.pages.cartes-membres.campaigns.store') }}" method="POST" class="row g-3">
                        @csrf
                        <div class="col-12">
                            <label class="form-label fw-semibold">Titre de la campagne</label>
                            <input type="text" class="form-control" name="title"
                                value="{{ old('title', 'Demande de photo pour carte SYNEM ' . now()->year) }}"
                                maxlength="150" required
                                placeholder="Ex : Demande de photo – Cartes 2026">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Message pour les militants</label>
                            <textarea class="form-control" name="message" rows="5" required
                                placeholder="Expliquez aux militants comment envoyer leur photo...">{{ old('message', "Bonjour,\n\nNous vous invitons à envoyer votre photo d'identité pour la confection de votre carte de membre SYNEM " . now()->year . ".\n\nVous pouvez prendre une photo directement avec votre téléphone ou téléverser une photo depuis votre appareil.\n\nMerci pour votre coopération.") }}</textarea>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary btn-lg w-100" type="submit">
                                <i class="fas fa-paper-plane me-2"></i>Envoyer la demande aux militants
                            </button>
                            <div class="text-muted small mt-2 text-center">
                                <i class="fas fa-info-circle me-1"></i>Tous les militants ayant le statut « Approuvé » recevront cette demande.
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- ONGLET 2 : VALIDER LES PHOTOS                           --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<div class="tab-pane fade" id="tab-photos" role="tabpanel">
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
                <div class="section-icon-title mb-0">
                    <div class="icon-circle" style="background:#d1e7dd;">🔍</div>
                    <div>
                        Photos reçues des militants
                        <div class="desc">Acceptez ou refusez chaque photo avant de générer les cartes</div>
                    </div>
                </div>
                <form class="d-flex gap-2 align-items-center" method="GET" action="{{ route('administration.pages.cartes-membres.index') }}#tab-photos">
                    <select class="form-select form-select-sm" name="submission_status" onchange="this.form.submit()">
                        <option value="all">Toutes les photos</option>
                        <option value="pending"   {{ request('submission_status') === 'pending'            ? 'selected' : '' }}>⏳ En attente</option>
                        <option value="approved"  {{ request('submission_status') === 'approved'           ? 'selected' : '' }}>✅ Validées</option>
                        <option value="revision_requested" {{ request('submission_status') === 'revision_requested' ? 'selected' : '' }}>🔄 À reprendre</option>
                    </select>
                </form>
            </div>

            <div class="row g-4">
                @forelse($submissions as $submission)
                    <div class="col-lg-6">
                        <div class="border rounded-3 p-3 h-100" style="background:#fafbfc;">
                            <div class="d-flex gap-3">
                                {{-- Photo --}}
                                <img src="{{ $submission->photo_url }}" alt="Photo"
                                    style="width:110px;height:135px;object-fit:cover;border-radius:8px;border:2px solid #dee2e6;flex-shrink:0;">

                                <div class="flex-grow-1">
                                    {{-- Nom + statut --}}
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="mb-0 fw-bold">{{ $submission->militant?->full_name ?? '—' }}</h6>
                                            <div class="text-muted small">{{ $submission->militant?->email }}</div>
                                        </div>
                                        <span class="badge {{ $submission->status === 'approved' ? 'bg-success' : ($submission->status === 'revision_requested' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                            {{ $submission->status_label }}
                                        </span>
                                    </div>

                                    {{-- Infos membre --}}
                                    <div class="small text-muted mb-2">
                                        N° {{ $submission->militant?->n_cartes_syndicale ?: 'Non attribué' }}
                                        &nbsp;·&nbsp;
                                        Photo reçue le {{ optional($submission->submitted_at)->format('d/m/Y') }}
                                    </div>

                                    {{-- Modifier les données carte --}}
                                    <form action="{{ route('administration.pages.cartes-membres.militants.identity', $submission->militant) }}" method="POST" class="mb-3">
                                        @csrf @method('PATCH')
                                        <div class="row g-1 mb-1">
                                            <div class="col-6"><input class="form-control form-control-sm" type="text" name="nom"    value="{{ $submission->militant?->nom }}"    placeholder="Nom *" required></div>
                                            <div class="col-6"><input class="form-control form-control-sm" type="text" name="prenom" value="{{ $submission->militant?->prenom }}" placeholder="Prénom *" required></div>
                                            <div class="col-6"><input class="form-control form-control-sm" type="text" name="division" value="{{ $submission->militant?->division }}" placeholder="Division"></div>
                                            <div class="col-6"><input class="form-control form-control-sm" type="text" name="region" value="{{ $submission->militant?->region }}"   placeholder="Région"></div>
                                            <div class="col-6"><input class="form-control form-control-sm" type="text" name="tel"  value="{{ $submission->militant?->tel }}"    placeholder="Téléphone *" required></div>
                                            <div class="col-6"><input class="form-control form-control-sm" type="text" name="n_cartes_syndicale" value="{{ $submission->militant?->n_cartes_syndicale }}" placeholder="N° de carte *" required></div>
                                            <input type="hidden" name="coordinations" value="{{ $submission->militant?->coordinations }}">
                                        </div>
                                        <button class="btn btn-outline-primary btn-sm w-100" type="submit">
                                            <i class="fas fa-save me-1"></i>Mettre à jour les informations
                                        </button>
                                    </form>

                                    {{-- Commentaire admin --}}
                                    @if($submission->admin_comment)
                                        <div class="alert alert-light border py-1 px-2 mb-2 small">
                                            <i class="fas fa-comment me-1 text-muted"></i>{{ $submission->admin_comment }}
                                        </div>
                                    @endif

                                    {{-- Validation --}}
                                    <form action="{{ route('administration.pages.cartes-membres.submissions.review', $submission) }}" method="POST" class="row g-1">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="redirect_submission_status" value="{{ request('submission_status', 'all') }}">
                                        <div class="col-12">
                                            <textarea class="form-control form-control-sm" name="admin_comment" rows="1"
                                                placeholder="Commentaire (optionnel)">{{ old('admin_comment') }}</textarea>
                                        </div>
                                        <div class="col-6 d-grid">
                                            <button class="btn btn-success btn-sm" type="submit" name="status" value="approved">
                                                <i class="fas fa-check me-1"></i>Valider la photo
                                            </button>
                                        </div>
                                        <div class="col-6 d-grid">
                                            <button class="btn btn-outline-danger btn-sm" type="submit" name="status" value="revision_requested">
                                                <i class="fas fa-redo me-1"></i>Demander une nouvelle photo
                                            </button>
                                        </div>
                                    </form>

                                    {{-- Supprimer --}}
                                    <form action="{{ route('administration.pages.cartes-membres.submissions.destroy', $submission) }}" method="POST" class="mt-1 js-delete-card-form" data-card-delete-message="Supprimer définitivement cette photo ?">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-link text-danger p-0" type="submit">
                                            <i class="fas fa-trash me-1"></i>Supprimer cette photo
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5 text-muted">
                            <div style="font-size:3rem;">📂</div>
                            <p class="mt-2">Aucune photo reçue pour le moment.<br>
                            <a href="#tab-campagne" data-bs-toggle="pill" class="btn btn-sm btn-outline-primary mt-2">
                                <i class="fas fa-paper-plane me-1"></i>Envoyer une demande aux militants
                            </a></p>
                        </div>
                    </div>
                @endforelse
            </div>

            @if($submissions->hasPages())
                <div class="mt-4">{{ $submissions->links() }}</div>
            @endif
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- ONGLET 3 : IMPRIMER LES CARTES                          --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<div class="tab-pane fade" id="tab-imprimer" role="tabpanel">

    <form action="{{ route('administration.pages.cartes-membres.export.pdf') }}" method="GET" target="_blank" id="cardGenerateForm">

        {{-- Champs cachés pour la configuration avancée (synchronisés depuis l'onglet Paramètres) --}}
        <input type="hidden" name="template"          id="hTemplate"      value="{{ $selectedTemplate }}">
        <input type="hidden" name="primary_color"     id="hPrimary"       value="{{ $resolvedTemplate['primary'] }}">
        <input type="hidden" name="secondary_color"   id="hSecondary"     value="{{ $resolvedTemplate['secondary'] }}">
        <input type="hidden" name="accent_color"      id="hAccent"        value="{{ $resolvedTemplate['accent'] }}">
        <input type="hidden" name="header_text_color" id="hHeaderText"    value="{{ $resolvedTemplate['header_text_color'] }}">
        <input type="hidden" name="text_color"        id="hTextColor"     value="{{ $resolvedTemplate['text_color'] }}">
        <input type="hidden" name="logo_path"         id="hLogoPath"      value="{{ $resolvedTemplate['logo_path'] }}">
        <input type="hidden" name="signature_path"    id="hSigPath"       value="{{ $resolvedTemplate['signature_path'] }}">
        <input type="hidden" name="signature_text"    id="hSigText"       value="{{ $resolvedTemplate['signature_text'] }}">

        <div class="row g-4">

            {{-- ── COLONNE GAUCHE : Configuration ── --}}
            <div class="col-lg-7">

                {{-- 1. Informations de la carte --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="section-icon-title">
                            <div class="icon-circle" style="background:#e8f0fe;">📋</div>
                            <div>Informations inscrites sur la carte<div class="desc">Ces textes apparaîtront directement sur chaque carte imprimée</div></div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label fw-semibold">Nom du Secrétaire Général</label>
                                <input type="text" class="form-control" name="secretary_general_name"
                                    value="{{ $resolvedTemplate['secretary_general_name'] }}"
                                    placeholder="Ex : Amadou COULIBALY">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Titre</label>
                                <input type="text" class="form-control" name="secretary_general_title"
                                    value="{{ $resolvedTemplate['secretary_general_title'] }}"
                                    placeholder="Secrétaire Général">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Devise (texte du haut)</label>
                                <input type="text" class="form-control" name="header_motto"
                                    value="{{ $resolvedTemplate['header_motto'] }}"
                                    placeholder="Ex : Unité - Action - Justice - 2026">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Prix de la carte</label>
                                <input type="text" class="form-control" name="price_label"
                                    value="{{ $resolvedTemplate['price_label'] }}"
                                    placeholder="Ex : 2 000 F CFA">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Année</label>
                                <input type="text" class="form-control" name="year_label"
                                    value="{{ $resolvedTemplate['year_label'] }}"
                                    placeholder="{{ now()->year }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2. Éléments à afficher --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="section-icon-title">
                            <div class="icon-circle" style="background:#fff3cd;">👁</div>
                            <div>Éléments à afficher sur la carte<div class="desc">Cochez ce que vous souhaitez voir apparaître</div></div>
                        </div>
                        <div class="row g-2">
                            @php
                                $options = [
                                    ['name'=>'show_logo',             'val'=>$resolvedTemplate['show_logo'],             'icon'=>'🏅', 'label'=>'Logo SYNEM',        'sub'=>'Logo de l\'organisation'],
                                    ['name'=>'show_qr',               'val'=>$resolvedTemplate['show_qr'],               'icon'=>'📱', 'label'=>'QR Code',           'sub'=>'Code de vérification unique'],
                                    ['name'=>'show_flag_band',        'val'=>$resolvedTemplate['show_flag_band'],        'icon'=>'🇲🇱', 'label'=>'Drapeau du Mali',   'sub'=>'Bande tricolore verte/jaune/rouge'],
                                    ['name'=>'show_border',           'val'=>$resolvedTemplate['show_border'],           'icon'=>'🔲', 'label'=>'Bordure de la carte','sub'=>'Encadrement visible'],
                                    ['name'=>'show_secretary_block',  'val'=>$resolvedTemplate['show_secretary_block'],  'icon'=>'✍️', 'label'=>'Bloc signataire',    'sub'=>'Nom et signature du secrétaire'],
                                ];
                            @endphp
                            @foreach($options as $opt)
                                <div class="col-sm-6">
                                    <label class="option-check-card {{ $opt['val'] ? 'checked' : '' }}" id="opt-label-{{ $opt['name'] }}">
                                        <input type="checkbox" name="{{ $opt['name'] }}" value="1"
                                            class="form-check-input flex-shrink-0 option-checkbox"
                                            data-label-id="opt-label-{{ $opt['name'] }}"
                                            {{ $opt['val'] ? 'checked' : '' }}>
                                        <div class="oc-icon">{{ $opt['icon'] }}</div>
                                        <div class="oc-text">
                                            <strong>{{ $opt['label'] }}</strong>
                                            <small>{{ $opt['sub'] }}</small>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- 3. Sélection des membres --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="section-icon-title">
                            <div class="icon-circle" style="background:#d1e7dd;">👥</div>
                            <div>
                                Membres à inclure
                                <div class="desc">Sélectionnez les membres dont vous voulez imprimer la carte</div>
                            </div>
                        </div>

                        @if($eligibleCards->isEmpty())
                            <div class="text-center py-4 text-muted">
                                <div style="font-size:2.5rem;">🚫</div>
                                <p class="mt-2 mb-1">Aucune carte prête à imprimer.</p>
                                <small>Il faut d'abord valider des photos dans l'onglet <strong>« Valider les photos »</strong>.</small>
                                <div class="mt-3">
                                    <a href="#tab-photos" data-bs-toggle="pill" class="btn btn-sm btn-outline-primary">
                                        Aller valider les photos →
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <span class="fw-semibold" id="selectedMilitantsCount">0 sélectionné</span>
                                    <span class="text-muted small ms-2">sur {{ $eligibleCards->count() }} disponibles</span>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-dark" type="button" id="checkAllMilitants">Tout sélectionner</button>
                                    <button class="btn btn-sm btn-outline-secondary" type="button" id="uncheckAllMilitants">Tout désélectionner</button>
                                </div>
                            </div>

                            <div class="member-selector-grid">
                                <div class="row g-2">
                                    @foreach($eligibleCards as $sub)
                                        <div class="col-md-6">
                                            <label class="member-selector-item" id="ms-label-{{ $sub->militant_id }}">
                                                <input class="form-check-input flex-shrink-0 militant-selector"
                                                    type="checkbox"
                                                    name="militant_ids[]"
                                                    value="{{ $sub->militant_id }}"
                                                    {{ collect(request('militant_ids', []))->contains($sub->militant_id) ? 'checked' : '' }}>
                                                <div class="member-avatar">
                                                    {{ strtoupper(substr($sub->militant?->prenom ?? '?', 0, 1)) }}{{ strtoupper(substr($sub->militant?->nom ?? '', 0, 1)) }}
                                                </div>
                                                <div style="flex:1;min-width:0;">
                                                    <div class="fw-semibold text-truncate" style="font-size:.85rem;">{{ $sub->militant?->full_name }}</div>
                                                    <div class="text-muted" style="font-size:.72rem;">
                                                        N° {{ $sub->militant?->n_cartes_syndicale ?: 'Auto' }}
                                                        &nbsp;·&nbsp;{{ $sub->militant?->region_label }}
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- 4. Boutons d'action --}}
                @if($eligibleCards->isNotEmpty())
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6 d-grid">
                                    <button class="btn btn-outline-secondary btn-lg" type="submit" name="inline" value="1">
                                        <i class="fas fa-print me-2"></i>Imprimer (aperçu)
                                    </button>
                                    <div class="text-muted text-center mt-1" style="font-size:.73rem;">Ouvre le PDF dans le navigateur</div>
                                </div>
                                <div class="col-md-6 d-grid">
                                    <button class="btn btn-primary btn-lg" type="submit">
                                        <i class="fas fa-file-pdf me-2"></i>Télécharger le PDF
                                    </button>
                                    <div class="text-muted text-center mt-1" style="font-size:.73rem;">Enregistre le fichier sur votre appareil</div>
                                </div>
                            </div>
                            <div class="text-center mt-3 text-muted small">
                                <i class="fas fa-info-circle me-1"></i>
                                Si aucun membre n'est sélectionné, toutes les cartes disponibles seront exportées.
                            </div>
                        </div>
                    </div>
                @endif

            </div>{{-- /col-lg-7 --}}

            {{-- ── COLONNE DROITE : Aperçu des cartes ── --}}
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm" style="position:sticky;top:80px;">
                    <div class="card-body">
                        <div class="section-icon-title">
                            <div class="icon-circle" style="background:#f8d7da;">👁</div>
                            <div>Aperçu des cartes<div class="desc">Voici à quoi ressembleront les cartes imprimées</div></div>
                        </div>

                        @forelse($previewCards as $card)
                            <div class="mb-3">
                                {{-- Carte visuelle --}}
                                <div class="mc-preview-shell mb-2">
                                    <div class="mc-header">
                                        @if($card['show_logo'] && $card['logo'])
                                            <img src="{{ $card['logo'] }}" alt="Logo" class="mc-logo">
                                        @else
                                            <div class="mc-title-spacer"></div>
                                        @endif
                                        <div class="mc-title">{{ $card['header_motto'] }}</div>
                                        <div class="mc-title-spacer"></div>
                                    </div>
                                    @if($card['show_flag_band'])
                                        <div class="mc-flagband">
                                            <span style="background:#0b8f3c;"></span>
                                            <span style="background:#f2c94c;"></span>
                                            <span style="background:#d62828;"></span>
                                        </div>
                                    @endif
                                    <div class="mc-cardnum">CARTE DE MEMBRE &nbsp; N° {{ $card['card_number'] }}</div>
                                    <div class="mc-body">
                                        <div class="mc-fields">
                                            <div class="mc-field"><b>Nom :</b> {{ $card['nom'] }}</div>
                                            <div class="mc-field"><b>Prénom :</b> {{ $card['prenom'] }}</div>
                                            <div class="mc-field"><b>DIVISION :</b> {{ $card['division'] }}</div>
                                            <div class="mc-field"><b>Coord. Rég. :</b> {{ $card['coordination'] }}</div>
                                        </div>
                                        @if($card['photo'])
                                            <img src="{{ $card['photo'] }}" alt="Photo" class="mc-photo">
                                        @else
                                            <div class="mc-photo-placeholder">Photo</div>
                                        @endif
                                    </div>
                                    <div class="mc-footer">
                                        <div class="mc-price">
                                            <span class="mc-price-label">Prix : {{ $card['price_label'] }}</span>
                                            <span class="mc-tel">N° Tél : {{ $card['phone'] }}</span>
                                        </div>
                                        @if($card['show_secretary_block'])
                                            <div class="mc-secretary">
                                                <span class="mc-sec-title">{{ $card['secretary_general_title'] }}</span>
                                                @if($card['signature_image'])
                                                    <img src="{{ $card['signature_image'] }}" alt="Signature" class="mc-sec-sig">
                                                @elseif($card['signature_text'])
                                                    <span class="mc-sec-sig-text">{{ $card['signature_text'] }}</span>
                                                @endif
                                                <span class="mc-sec-name">{{ $card['secretary_general_name'] }}</span>
                                            </div>
                                        @endif
                                        @if($card['show_qr'] && $card['qr_code'])
                                            <div class="mc-qr"><img src="{{ $card['qr_code'] }}" alt="QR"></div>
                                        @endif
                                    </div>
                                </div>
                                {{-- Actions individuelles --}}
                                <div class="d-flex gap-1 flex-wrap">
                                    @php
                                        $q = http_build_query([
                                            'template'               => $selectedTemplate,
                                            'primary_color'          => $resolvedTemplate['primary'],
                                            'secondary_color'        => $resolvedTemplate['secondary'],
                                            'accent_color'           => $resolvedTemplate['accent'],
                                            'header_text_color'      => $resolvedTemplate['header_text_color'],
                                            'text_color'             => $resolvedTemplate['text_color'],
                                            'logo_path'              => $resolvedTemplate['logo_path'],
                                            'signature_path'         => $resolvedTemplate['signature_path'],
                                            'signature_text'         => $resolvedTemplate['signature_text'],
                                            'header_motto'           => $resolvedTemplate['header_motto'],
                                            'price_label'            => $resolvedTemplate['price_label'],
                                            'secretary_general_name' => $resolvedTemplate['secretary_general_name'],
                                            'secretary_general_title'=> $resolvedTemplate['secretary_general_title'],
                                            'year_label'             => $resolvedTemplate['year_label'],
                                            'show_logo'              => $resolvedTemplate['show_logo'] ? 1 : 0,
                                            'show_qr'                => $resolvedTemplate['show_qr'] ? 1 : 0,
                                            'show_border'            => $resolvedTemplate['show_border'] ? 1 : 0,
                                            'show_flag_band'         => $resolvedTemplate['show_flag_band'] ? 1 : 0,
                                            'show_secretary_block'   => $resolvedTemplate['show_secretary_block'] ? 1 : 0,
                                        ]);
                                    @endphp
                                    <a class="btn btn-sm btn-outline-secondary" target="_blank"
                                        href="{{ route('administration.pages.cartes-membres.militants.download', $card['militant']) }}?{{ $q }}&inline=1">
                                        <i class="fas fa-print"></i> Imprimer
                                    </a>
                                    <a class="btn btn-sm btn-primary"
                                        href="{{ route('administration.pages.cartes-membres.militants.download', $card['militant']) }}?{{ $q }}">
                                        <i class="fas fa-file-pdf"></i> PDF
                                    </a>
                                    <a class="btn btn-sm btn-outline-dark"
                                        href="{{ route('administration.pages.cartes-membres.militants.image', $card['militant']) }}?{{ $q }}">
                                        <i class="fas fa-image"></i> Image
                                    </a>
                                    <form action="{{ route('administration.pages.cartes-membres.submissions.destroy', $card['submission']) }}"
                                        method="POST" class="js-delete-card-form" data-card-delete-message="Supprimer cette carte ?">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" type="submit">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4 text-muted">
                                <div style="font-size:2.5rem;">🃏</div>
                                <p class="mt-2 small">Aucune carte à prévisualiser.<br>Validez d'abord des photos.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>{{-- /row --}}
    </form>
</div>{{-- /tab-imprimer --}}

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- ONGLET 4 : SIGNATURE & APPARENCE                        --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<div class="tab-pane fade" id="tab-config" role="tabpanel">
    <div class="row g-4">

        {{-- Signature --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="section-icon-title">
                        <div class="icon-circle" style="background:#e8f0fe;">✍️</div>
                        <div>Signature du signataire<div class="desc">Cette signature apparaîtra au bas de chaque carte imprimée</div></div>
                    </div>

                    @if($errors->has('signature'))
                        <div class="alert alert-warning py-2 px-3 mb-3">{{ $errors->first('signature') }}</div>
                    @endif

                    {{-- Signature active --}}
                    @if($resolvedTemplate['signature_path'])
                        <div class="d-flex align-items-center gap-3 flex-wrap p-3 rounded-3 mb-3" style="background:#f0fff4;border:1px solid #d1e7dd;">
                            <img src="{{ Storage::url($resolvedTemplate['signature_path']) }}" alt="Signature" class="signature-preview">
                            <div class="flex-grow-1">
                                <div class="badge bg-success mb-1">Signature active</div>
                                <div class="fw-semibold">{{ $resolvedTemplate['secretary_general_name'] }}</div>
                            </div>
                            <form action="{{ route('administration.pages.cartes-membres.signature.clear') }}" method="POST"
                                onsubmit="return confirm('Supprimer la signature enregistrée ?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm" type="submit">
                                    <i class="fas fa-trash me-1"></i>Supprimer
                                </button>
                            </form>
                        </div>
                    @elseif($resolvedTemplate['signature_text'])
                        <div class="p-3 rounded-3 mb-3" style="background:#f0fff4;border:1px solid #d1e7dd;">
                            <div class="badge bg-success mb-2">Signature texte active</div>
                            <div class="signature-text-preview">{{ $resolvedTemplate['signature_text'] }}</div>
                        </div>
                    @endif

                    <form action="{{ route('administration.pages.cartes-membres.signature.store') }}" method="POST"
                        enctype="multipart/form-data" id="signatureForm" class="row g-3">
                        @csrf

                        {{-- Option 1 : Texte --}}
                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                <span class="badge bg-secondary me-1">Option 1</span>
                                Signature en texte manuscrit
                            </label>
                            <input type="text" class="form-control" name="signature_text" id="signatureText"
                                value="{{ $resolvedTemplate['signature_text'] }}"
                                placeholder="Ex : B. Moustapha">
                            <div class="mt-2">
                                <div class="text-muted small mb-1">Aperçu :</div>
                                <div id="signatureTextPreview" class="signature-text-preview">
                                    {{ $resolvedTemplate['signature_text'] ?: 'Votre signature apparaîtra ici...' }}
                                </div>
                            </div>
                        </div>

                        <div class="col-12"><div class="text-center text-muted small">─── ou ───</div></div>

                        {{-- Option 2 : Image --}}
                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                <span class="badge bg-secondary me-1">Option 2</span>
                                Importer une image de signature
                            </label>
                            <input type="file" class="form-control" name="signature_file" id="signatureFile"
                                accept="image/png,image/jpeg,image/jpg,image/webp">
                            <small class="text-muted">Formats acceptés : PNG, JPG, WEBP. Fond transparent recommandé.</small>
                        </div>

                        <div class="col-12"><div class="text-center text-muted small">─── ou ───</div></div>

                        {{-- Option 3 : Dessin --}}
                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                <span class="badge bg-secondary me-1">Option 3</span>
                                Dessiner la signature avec la souris ou le doigt
                            </label>
                            <div class="signature-pad-shell">
                                <canvas id="signaturePad" class="signature-pad"></canvas>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-1">
                                <div class="signature-status text-muted small" id="signatureStatus">En attente de votre signature...</div>
                                <button class="btn btn-sm btn-outline-secondary" type="button" id="clearSignaturePad">Effacer</button>
                            </div>
                            <div class="mt-2">
                                <img id="signaturePreviewLive" class="signature-live-preview d-none" alt="Aperçu">
                            </div>
                            <input type="hidden" name="signature_data" id="signatureData">
                        </div>

                        <div class="col-12 d-grid">
                            <button class="btn btn-primary btn-lg" type="submit" id="saveSignatureBtn">
                                <i class="fas fa-save me-2"></i>Enregistrer la signature
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Apparence avancée --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="section-icon-title">
                        <div class="icon-circle" style="background:#fff3cd;">🎨</div>
                        <div>Apparence de la carte<div class="desc">Ces paramètres s'appliqueront lors de la prochaine génération</div></div>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Modèle de base</label>
                            <select class="form-select" id="templateSelector">
                                @foreach($templates as $key => $tmpl)
                                    <option value="{{ $key }}" data-primary="{{ $tmpl['primary'] }}" data-secondary="{{ $tmpl['secondary'] }}" data-accent="{{ $tmpl['accent'] }}"
                                        {{ $selectedTemplate === $key ? 'selected' : '' }}>
                                        {{ $tmpl['label'] }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Vous pouvez ensuite ajuster les couleurs ci-dessous</small>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Couleur principale</label>
                            <div class="d-flex align-items-center gap-2">
                                <input type="color" class="form-control form-control-color" id="cfgPrimary" value="{{ $resolvedTemplate['primary'] }}" style="width:48px;height:38px;">
                                <span class="text-muted small" id="cfgPrimaryHex">{{ $resolvedTemplate['primary'] }}</span>
                            </div>
                            <small class="text-muted">Couleur du texte en-tête et du numéro</small>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Couleur du fond</label>
                            <div class="d-flex align-items-center gap-2">
                                <input type="color" class="form-control form-control-color" id="cfgAccent" value="{{ $resolvedTemplate['accent'] }}" style="width:48px;height:38px;">
                                <span class="text-muted small" id="cfgAccentHex">{{ $resolvedTemplate['accent'] }}</span>
                            </div>
                            <small class="text-muted">Fond général de la carte</small>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Couleur du texte</label>
                            <div class="d-flex align-items-center gap-2">
                                <input type="color" class="form-control form-control-color" id="cfgTextColor" value="{{ $resolvedTemplate['text_color'] }}" style="width:48px;height:38px;">
                                <span class="text-muted small" id="cfgTextHex">{{ $resolvedTemplate['text_color'] }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Chemin du logo</label>
                            <input type="text" class="form-control form-control-sm" id="cfgLogoPath" value="{{ $resolvedTemplate['logo_path'] }}" placeholder="template-admin/assets/images/syneklogo.jpeg">
                            <small class="text-muted">Chemin relatif dans le dossier public/</small>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary w-100" type="button" id="applyConfigBtn">
                                <i class="fas fa-check me-2"></i>Appliquer ces paramètres aux cartes
                            </button>
                            <div class="text-success small mt-2 d-none" id="configAppliedMsg">
                                <i class="fas fa-check-circle me-1"></i>Paramètres appliqués. Allez dans l'onglet <strong>Imprimer les cartes</strong> pour générer le PDF.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Champ logo complet readonly --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="section-icon-title">
                        <div class="icon-circle" style="background:#f8d7da;">ℹ️</div>
                        <div>Signature enregistrée (info)<div class="desc">Chemin actuel de la signature dans le système</div></div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-semibold small">Fichier signature actif</label>
                        <input type="text" class="form-control form-control-sm" readonly
                            value="{{ $resolvedTemplate['signature_path'] ?: '(aucune image de signature)' }}">
                    </div>
                    <div>
                        <label class="form-label fw-semibold small">Signature texte active</label>
                        <input type="text" class="form-control form-control-sm" readonly
                            value="{{ $resolvedTemplate['signature_text'] ?: '(aucune signature texte)' }}">
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>{{-- /tab-config --}}

</div>{{-- /tab-content --}}
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── Persistance de l'onglet actif ──────────────────── */
    const STORAGE_KEY = 'synem_cards_active_tab';
    const savedTab = localStorage.getItem(STORAGE_KEY);
    if (savedTab) {
        const el = document.querySelector('[href="' + savedTab + '"]');
        if (el) bootstrap.Tab.getOrCreateInstance(el).show();
    }
    document.querySelectorAll('#cardMainTabs .nav-link').forEach(function (link) {
        link.addEventListener('shown.bs.tab', function () {
            localStorage.setItem(STORAGE_KEY, link.getAttribute('href'));
        });
    });

    /* ── Checkboxes options (style visuel) ──────────────── */
    document.querySelectorAll('.option-checkbox').forEach(function (cb) {
        cb.addEventListener('change', function () {
            const label = document.getElementById(cb.dataset.labelId);
            if (label) label.classList.toggle('checked', cb.checked);
        });
    });

    /* ── Sélection membres ───────────────────────────────── */
    const getSelectors = () => Array.from(document.querySelectorAll('.militant-selector'));
    const countLabel   = document.getElementById('selectedMilitantsCount');

    const syncMemberStyles = () => {
        const sel = getSelectors();
        const checked = sel.filter(s => s.checked).length;
        if (countLabel) countLabel.textContent = checked + ' sélectionné' + (checked > 1 ? 's' : '');
        sel.forEach(s => {
            const item = s.closest('.member-selector-item');
            if (item) item.classList.toggle('is-selected', s.checked);
        });
        if (document.getElementById('checkAllMilitants'))
            document.getElementById('checkAllMilitants').disabled = sel.length > 0 && sel.every(s => s.checked);
        if (document.getElementById('uncheckAllMilitants'))
            document.getElementById('uncheckAllMilitants').disabled = !sel.some(s => s.checked);
    };

    window.synemBulkSelect = (checked) => { getSelectors().forEach(s => s.checked = checked); syncMemberStyles(); return false; };

    document.addEventListener('click', function (e) {
        if (e.target.closest('#checkAllMilitants'))   { e.preventDefault(); window.synemBulkSelect(true); }
        if (e.target.closest('#uncheckAllMilitants')) { e.preventDefault(); window.synemBulkSelect(false); }
    });
    document.addEventListener('change', function (e) {
        if (e.target && e.target.matches('.militant-selector')) syncMemberStyles();
    });
    syncMemberStyles();

    /* ── Suppression cartes (confirmation) ───────────────── */
    document.querySelectorAll('.js-delete-card-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            if (!window.Swal) return;
            e.preventDefault();
            Swal.fire({ icon: 'warning', title: 'Confirmation', text: form.dataset.cardDeleteMessage || 'Supprimer ?',
                showCancelButton: true, confirmButtonText: 'Supprimer', cancelButtonText: 'Annuler',
                confirmButtonColor: '#dc3545', reverseButtons: true,
            }).then(r => { if (r.isConfirmed) form.submit(); });
        });
    });

    /* ── Pad de signature ────────────────────────────────── */
    const canvas   = document.getElementById('signaturePad');
    const form     = document.getElementById('signatureForm');
    const sigData  = document.getElementById('signatureData');
    const sigFile  = document.getElementById('signatureFile');
    const sigText  = document.getElementById('signatureText');
    const sigStatus= document.getElementById('signatureStatus');
    const sigPreview= document.getElementById('signaturePreviewLive');
    const sigTextPrev= document.getElementById('signatureTextPreview');
    const clearBtn = document.getElementById('clearSignaturePad');

    if (canvas && form) {
        const ctx = canvas.getContext('2d');
        let drawing = false, hasDrawn = false;

        const resize = () => {
            const r = window.devicePixelRatio || 1, rect = canvas.getBoundingClientRect();
            canvas.width = rect.width * r; canvas.height = rect.height * r;
            ctx.setTransform(1,0,0,1,0,0); ctx.scale(r,r);
            ctx.lineWidth = 2.2; ctx.lineCap = 'round'; ctx.lineJoin = 'round';
            ctx.strokeStyle = '#0f172a'; ctx.fillStyle = '#ffffff';
            ctx.fillRect(0,0,rect.width,rect.height);
            hasDrawn = false;
            if (sigStatus) sigStatus.textContent = 'En attente de votre signature...';
            if (sigPreview) { sigPreview.src=''; sigPreview.classList.add('d-none'); }
        };

        const pt = (e) => { const r=canvas.getBoundingClientRect(), s=e.touches?e.touches[0]:(e.changedTouches?e.changedTouches[0]:e); return {x:s.clientX-r.left,y:s.clientY-r.top}; };

        const start = (e) => { e.preventDefault(); drawing=true; hasDrawn=true; if(canvas.setPointerCapture&&e.pointerId)canvas.setPointerCapture(e.pointerId); const p=pt(e); ctx.beginPath(); ctx.moveTo(p.x,p.y); if(sigStatus)sigStatus.textContent='Signature en cours...'; };
        const draw_ = (e) => { if(!drawing)return; e.preventDefault(); hasDrawn=true; const p=pt(e); ctx.lineTo(p.x,p.y); ctx.stroke(); if(sigPreview){sigPreview.src=canvas.toDataURL();sigPreview.classList.remove('d-none');} };
        const stop  = (e) => { drawing=false; if(hasDrawn&&sigStatus)sigStatus.textContent='Signature enregistrée. Cliquez sur « Enregistrer ».'; };

        resize(); window.addEventListener('resize', resize);

        if (window.PointerEvent) {
            canvas.addEventListener('pointerdown', start);
            canvas.addEventListener('pointermove', draw_);
            canvas.addEventListener('pointerup',   stop);
            canvas.addEventListener('pointerleave',stop);
        } else {
            canvas.addEventListener('mousedown', start); canvas.addEventListener('mousemove', draw_); canvas.addEventListener('mouseup', stop); canvas.addEventListener('mouseleave', stop);
            canvas.addEventListener('touchstart', start, {passive:false}); canvas.addEventListener('touchmove', draw_, {passive:false}); canvas.addEventListener('touchend', stop);
        }

        if (clearBtn) clearBtn.addEventListener('click', () => { resize(); if(sigData)sigData.value=''; if(sigFile)sigFile.value=''; if(sigText)sigText.value=''; if(sigTextPrev)sigTextPrev.textContent='Votre signature apparaîtra ici...'; });

        if (sigText) sigText.addEventListener('input', function () { if(sigTextPrev)sigTextPrev.textContent=sigText.value||'Votre signature apparaîtra ici...'; });

        form.addEventListener('submit', function (e) {
            const hasFile = sigFile && sigFile.files && sigFile.files.length > 0;
            const hasTxt  = sigText && sigText.value.trim().length > 0;
            if (!hasDrawn && !hasFile && !hasTxt) {
                e.preventDefault();
                if (window.Swal) Swal.fire({ icon:'warning', title:'Signature requise', text:'Dessinez, importez une image ou saisissez un texte de signature.' });
                else alert('Veuillez saisir ou dessiner une signature.');
                return;
            }
            if (sigData) sigData.value = (hasFile || hasTxt) ? '' : canvas.toDataURL('image/png');
        });
    }

    /* ── Configuration avancée → sync vers champs cachés ── */
    const cfgPrimary   = document.getElementById('cfgPrimary');
    const cfgAccent    = document.getElementById('cfgAccent');
    const cfgTextColor = document.getElementById('cfgTextColor');
    const cfgLogoPath  = document.getElementById('cfgLogoPath');
    const applyBtn     = document.getElementById('applyConfigBtn');
    const applyMsg     = document.getElementById('configAppliedMsg');
    const tmplSel      = document.getElementById('templateSelector');

    if (tmplSel) {
        tmplSel.addEventListener('change', function () {
            const opt = tmplSel.options[tmplSel.selectedIndex];
            if (cfgPrimary   && opt.dataset.primary)   { cfgPrimary.value   = opt.dataset.primary;   document.getElementById('cfgPrimaryHex').textContent = opt.dataset.primary; }
            if (cfgAccent    && opt.dataset.accent)    { cfgAccent.value    = opt.dataset.accent;    document.getElementById('cfgAccentHex').textContent  = opt.dataset.accent; }
        });
    }

    [['cfgPrimary','cfgPrimaryHex'],['cfgAccent','cfgAccentHex'],['cfgTextColor','cfgTextHex']].forEach(([id,hexId]) => {
        const el = document.getElementById(id), hex = document.getElementById(hexId);
        if (el && hex) el.addEventListener('input', () => hex.textContent = el.value.toUpperCase());
    });

    if (applyBtn) {
        applyBtn.addEventListener('click', function () {
            const f = document.getElementById('cardGenerateForm');
            if (!f) return;
            const set = (id, val) => { const el = f.querySelector('#' + id); if (el) el.value = val; };
            if (tmplSel)    set('hTemplate',  tmplSel.value);
            if (cfgPrimary) { set('hPrimary', cfgPrimary.value); set('hSecondary', cfgPrimary.value); }
            if (cfgAccent)  set('hAccent',    cfgAccent.value);
            if (cfgTextColor) set('hTextColor', cfgTextColor.value);
            if (cfgLogoPath)  set('hLogoPath',  cfgLogoPath.value);
            if (applyMsg) { applyMsg.classList.remove('d-none'); setTimeout(() => applyMsg.classList.add('d-none'), 4000); }
        });
    }

});
</script>
@endpush
