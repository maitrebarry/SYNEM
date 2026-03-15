@extends('layouts.administration')

@section('title', 'Cartes des membres')

@section('breadcrumb')
<div class="page-breadcrumb d-flex align-items-center">
    <div class="breadcrumb-title pe-3">Militants</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('administration.tableau-de-bord') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item active" aria-current="page">Cartes des membres</li>
            </ol>
        </nav>
    </div>
</div>
@endsection

@section('styles')
<style>
    .member-card-preview-shell {
        background: #f8fafc;
        border: 1px solid #dbe2ea;
    }

    .member-card-preview-header {
        background: linear-gradient(135deg, #1a365d, #0d6efd);
        color: #fff;
    }

    .member-card-preview-photo {
        width: 88px;
        height: 108px;
        object-fit: cover;
        border: 3px solid #0d6efd;
    }

    .member-select-grid {
        max-height: 280px;
        overflow-y: auto;
    }

    .signature-pad-shell {
        border: 1px dashed #94a3b8;
        border-radius: .75rem;
        background: #fff;
        position: relative;
        overflow: hidden;
    }

    .signature-pad {
        width: 100%;
        height: 150px;
        display: block;
        cursor: crosshair;
        touch-action: none;
        background-image: linear-gradient(to bottom, transparent 31px, #eef2f7 32px);
        background-size: 100% 32px;
    }

    .signature-pad-shell::before {
        content: 'Signez ici avec le doigt ou la souris';
        position: absolute;
        top: .6rem;
        left: .9rem;
        font-size: .8rem;
        color: #94a3b8;
        pointer-events: none;
    }

    .signature-preview {
        max-width: 180px;
        max-height: 70px;
        object-fit: contain;
        background: #fff;
        border: 1px solid #dbe2ea;
        border-radius: .5rem;
        padding: .35rem;
    }

    .signature-status {
        font-size: .85rem;
    }

    .signature-live-preview {
        width: 220px;
        max-width: 100%;
        height: 80px;
        object-fit: contain;
        background: #fff;
        border: 1px solid #dbe2ea;
        border-radius: .5rem;
        padding: .35rem;
    }

    .signature-text-preview {
        min-height: 54px;
        display: flex;
        align-items: center;
        padding: .35rem .75rem;
        background: #fff;
        border: 1px solid #dbe2ea;
        border-radius: .5rem;
        font-size: 1.5rem;
        font-style: italic;
        color: #0f172a;
    }

    .member-selector-item.is-selected {
        border-color: #0d6efd !important;
        background: #eff6ff;
    }
</style>
@endsection

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="text-muted small">Militants approuvés</div>
                <div class="fs-3 fw-bold">{{ $stats['approved_militants'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card info h-100">
            <div class="card-body">
                <div class="text-muted small">Photos reçues</div>
                <div class="fs-3 fw-bold">{{ $stats['received_submissions'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card success h-100">
            <div class="card-body">
                <div class="text-muted small">Photos validées</div>
                <div class="fs-3 fw-bold">{{ $stats['approved_cards'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card warning h-100">
            <div class="card-body">
                <div class="text-muted small">En attente</div>
                <div class="fs-3 fw-bold">{{ $stats['pending_cards'] }}</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-xl-5">
        <div class="card h-100 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">Campagne de collecte</h5>
                    <small class="text-muted">Diffusion automatique de la demande photo vers tous les militants approuvés.</small>
                </div>
                @if($activeCampaign)
                    <span class="badge bg-success">Active</span>
                @endif
            </div>
            <div class="card-body">
                @if($activeCampaign)
                    <div class="alert alert-light border">
                        <div class="fw-semibold">{{ $activeCampaign->title }}</div>
                        <small class="text-muted">Envoyée le {{ optional($activeCampaign->sent_at)->format('d/m/Y H:i') }}</small>
                        <p class="mb-3 mt-2">{{ $activeCampaign->message }}</p>
                        <div class="d-flex gap-2 flex-wrap mb-3">
                            <span class="badge bg-secondary">{{ $activeCampaign->submissions_count }} photos</span>
                            <span class="badge bg-warning text-dark">{{ $activeCampaign->pending_submissions_count }} à valider</span>
                            <span class="badge bg-success">{{ $activeCampaign->approved_submissions_count }} validées</span>
                            <span class="badge bg-danger">{{ $activeCampaign->revision_submissions_count }} à reprendre</span>
                        </div>
                        <form action="{{ route('administration.pages.cartes-membres.campaigns.close', $activeCampaign) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-outline-danger btn-sm" type="submit">
                                <i class="fas fa-stop-circle me-1"></i>
                                Clôturer cette campagne
                            </button>
                        </form>
                    </div>
                @endif

                <form action="{{ route('administration.pages.cartes-membres.campaigns.store') }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-12">
                        <label class="form-label">Titre</label>
                        <input type="text" class="form-control" name="title" value="{{ old('title', 'Demande de photo pour carte SYNEM') }}" maxlength="150" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Message envoyé aux militants</label>
                        <textarea class="form-control" name="message" rows="5" required>{{ old('message', 'Bonjour, merci d\'envoyer votre photo d\'identité pour la confection de votre carte de membre SYNEM. Vous pouvez prendre une photo avec la caméra ou téléverser votre photo depuis votre appareil.') }}</textarea>
                    </div>
                    <div class="col-12 d-grid">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-paper-plane me-1"></i>
                            Lancer une nouvelle campagne
                        </button>
                    </div>
                </form>

                <hr class="my-4">

                <div>
                    <h6 class="mb-1">Signature electronique du signataire</h6>
                    <small class="text-muted d-block mb-3">Dessinez la signature du secretaire general, importez une image PNG/JPG ou saisissez une signature texte, puis enregistrez-la pour l'utiliser sur les cartes.</small>

                    @if($errors->has('signature'))
                        <div class="alert alert-warning py-2 px-3 mb-3">{{ $errors->first('signature') }}</div>
                    @endif

                    @if($resolvedTemplate['signature_path'])
                        <div class="d-flex align-items-center gap-3 flex-wrap mb-3">
                            <img src="{{ Storage::url($resolvedTemplate['signature_path']) }}" alt="Signature enregistree" class="signature-preview">
                            <div>
                                <div class="small text-muted">Signature active</div>
                                <div class="fw-semibold">{{ $resolvedTemplate['secretary_general_name'] }}</div>
                            </div>
                            <form action="{{ route('administration.pages.cartes-membres.signature.clear') }}" method="POST" onsubmit="return confirm('Supprimer la signature enregistree ?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm" type="submit">Supprimer la signature</button>
                            </form>
                        </div>
                    @endif

                    @if($resolvedTemplate['signature_text'])
                        <div class="mb-3">
                            <div class="small text-muted mb-2">Signature texte active</div>
                            <div class="signature-text-preview">{{ $resolvedTemplate['signature_text'] }}</div>
                        </div>
                    @endif

                    <form action="{{ route('administration.pages.cartes-membres.signature.store') }}" method="POST" enctype="multipart/form-data" id="signatureForm" class="row g-3">
                        @csrf
                        <div class="col-12">
                            <label class="form-label">Saisie automatique de la signature</label>
                            <input type="text" class="form-control" name="signature_text" id="signatureText" value="{{ $resolvedTemplate['signature_text'] }}" placeholder="Ex: B. Moustapha">
                            <small class="text-muted">Cette valeur sera utilisee comme signature texte si vous ne dessinez pas et ne choisissez pas d'image.</small>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Importer une image de signature</label>
                            <input type="file" class="form-control" name="signature_file" id="signatureFile" accept="image/png,image/jpeg,image/jpg,image/webp">
                            <small class="text-muted">Si un fichier est choisi, il sera utilise a la place du dessin.</small>
                        </div>
                        <div class="col-12">
                            <div class="text-muted small mb-2">Ou dessiner la signature ci-dessous</div>
                        </div>
                        <div class="col-12">
                            <div class="signature-pad-shell">
                                <canvas id="signaturePad" class="signature-pad"></canvas>
                            </div>
                            <div class="signature-status text-muted mt-2" id="signatureStatus">Aucune signature detectee pour le moment.</div>
                            <div class="small text-muted">Compatible doigt (ecran tactile), souris et stylet. Aucun stylet n'est requis.</div>
                            <input type="hidden" name="signature_data" id="signatureData">
                        </div>
                        <div class="col-12">
                            <div class="small text-muted mb-2">Apercu de la signature capturee</div>
                            <img id="signaturePreviewLive" class="signature-live-preview d-none" alt="Apercu signature">
                        </div>
                        <div class="col-12">
                            <div class="small text-muted mb-2">Apercu de la signature texte</div>
                            <div id="signatureTextPreview" class="signature-text-preview">{{ $resolvedTemplate['signature_text'] ?: 'Votre signature texte apparaitra ici.' }}</div>
                        </div>
                        <div class="col-12 d-flex gap-2">
                            <button class="btn btn-outline-secondary" type="button" id="clearSignaturePad">Effacer</button>
                            <button class="btn btn-primary" type="submit" id="saveSignatureBtn">Enregistrer la signature</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-7">
        <div class="card h-100 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h5 class="mb-1">Génération des cartes</h5>
                    <small class="text-muted">6 modèles disponibles, couleurs ajustables, export PDF et impression.</small>
                </div>
                <span class="badge bg-dark">{{ $eligibleCards->count() }} cartes prêtes</span>
            </div>
            <div class="card-body">
                <form action="{{ route('administration.pages.cartes-membres.export.pdf') }}" method="GET" target="_blank" class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label">Template</label>
                        <select name="template" id="templateSelector" class="form-select">
                            @foreach($templates as $key => $template)
                                <option value="{{ $key }}" {{ $selectedTemplate === $key ? 'selected' : '' }}>{{ $template['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Couleur 1</label>
                        <input type="color" class="form-control form-control-color w-100" name="primary_color" value="{{ $resolvedTemplate['primary'] }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Couleur 2</label>
                        <input type="color" class="form-control form-control-color w-100" name="secondary_color" value="{{ $resolvedTemplate['secondary'] }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Fond</label>
                        <input type="color" class="form-control form-control-color w-100" name="accent_color" value="{{ $resolvedTemplate['accent'] }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Texte haut</label>
                        <input type="color" class="form-control form-control-color w-100" name="header_text_color" value="{{ $resolvedTemplate['header_text_color'] }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Texte carte</label>
                        <input type="color" class="form-control form-control-color w-100" name="text_color" value="{{ $resolvedTemplate['text_color'] }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Chemin logo public</label>
                        <input type="text" class="form-control" name="logo_path" value="{{ $resolvedTemplate['logo_path'] }}" placeholder="template-admin/assets/images/syneklogo.jpeg">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Signature enregistree</label>
                        <input type="text" class="form-control" name="signature_path" value="{{ $resolvedTemplate['signature_path'] }}" placeholder="member-cards/signatures/..." readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Signature texte</label>
                        <input type="text" class="form-control" name="signature_text" value="{{ $resolvedTemplate['signature_text'] }}" placeholder="Signature texte automatique">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Secretaire general</label>
                        <input type="text" class="form-control" name="secretary_general_name" value="{{ $resolvedTemplate['secretary_general_name'] }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Titre signataire</label>
                        <input type="text" class="form-control" name="secretary_general_title" value="{{ $resolvedTemplate['secretary_general_title'] }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Texte du haut</label>
                        <input type="text" class="form-control" name="header_motto" value="{{ $resolvedTemplate['header_motto'] }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Prix</label>
                        <input type="text" class="form-control" name="price_label" value="{{ $resolvedTemplate['price_label'] }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Annee</label>
                        <input type="text" class="form-control" name="year_label" value="{{ $resolvedTemplate['year_label'] }}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-outline-secondary w-100" type="submit" name="inline" value="1">
                            <i class="fas fa-print me-1"></i>
                            Imprimer
                        </button>
                    </div>
                    <div class="col-12">
                        <div class="d-flex flex-wrap gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="show_logo" value="1" id="showLogo" {{ $resolvedTemplate['show_logo'] ? 'checked' : '' }}>
                                <label class="form-check-label" for="showLogo">Logo</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="show_qr" value="1" id="showQr" {{ $resolvedTemplate['show_qr'] ? 'checked' : '' }}>
                                <label class="form-check-label" for="showQr">QR code</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="show_border" value="1" id="showBorder" {{ $resolvedTemplate['show_border'] ? 'checked' : '' }}>
                                <label class="form-check-label" for="showBorder">Bordure</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="show_flag_band" value="1" id="showFlagBand" {{ $resolvedTemplate['show_flag_band'] ? 'checked' : '' }}>
                                <label class="form-check-label" for="showFlagBand">Bande Mali</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="show_secretary_block" value="1" id="showSecretary" {{ $resolvedTemplate['show_secretary_block'] ? 'checked' : '' }}>
                                <label class="form-check-label" for="showSecretary">Bloc signataire</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="border rounded p-3 member-select-grid">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <strong>Selection des militants a generer</strong>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="small text-muted" id="selectedMilitantsCount">0 selectionne</span>
                                    <button class="btn btn-sm btn-outline-dark" type="button" id="checkAllMilitants" onclick="return window.synemBulkSelect ? window.synemBulkSelect(true) : false;">Tout cocher</button>
                                    <button class="btn btn-sm btn-outline-secondary" type="button" id="uncheckAllMilitants" onclick="return window.synemBulkSelect ? window.synemBulkSelect(false) : false;">Tout decocher</button>
                                </div>
                            </div>
                            <div class="small text-muted mb-3">Seuls les militants dont la photo est validee apparaissent ici. Les photos en attente restent visibles plus bas jusqu'a validation.</div>
                            <div class="row g-2">
                                @foreach($eligibleCards as $eligibleSubmission)
                                    <div class="col-md-6">
                                        <label class="form-check border rounded p-2 d-flex gap-2 align-items-start member-selector-item">
                                            <input class="form-check-input mt-1 militant-selector" type="checkbox" name="militant_ids[]" value="{{ $eligibleSubmission->militant_id }}" {{ collect(request('militant_ids', []))->contains($eligibleSubmission->militant_id) ? 'checked' : '' }}>
                                            <span>
                                                <strong>{{ $eligibleSubmission->militant?->full_name }}</strong><br>
                                                <small class="text-muted">{{ $eligibleSubmission->militant?->n_cartes_syndicale ?: 'Numero auto' }} · {{ $eligibleSubmission->militant?->region_label }}</small>
                                            </span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <div class="fw-semibold">{{ $resolvedTemplate['label'] }}</div>
                            <small class="text-muted">{{ $resolvedTemplate['description'] }}</small>
                            <div class="small text-muted">Le texte s'adapte si vous laissez les couleurs proposees, mais vous pouvez aussi choisir vos propres couleurs.</div>
                        </div>
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-file-pdf me-1"></i>
                            Télécharger le PDF global
                        </button>
                    </div>
                </form>

                <div class="row g-3">
                    @forelse($previewCards as $card)
                        <div class="col-md-6">
                            @php
                                $cardQuery = http_build_query([
                                    'template' => $selectedTemplate,
                                    'primary_color' => $resolvedTemplate['primary'],
                                    'secondary_color' => $resolvedTemplate['secondary'],
                                    'accent_color' => $resolvedTemplate['accent'],
                                    'header_text_color' => $resolvedTemplate['header_text_color'],
                                    'text_color' => $resolvedTemplate['text_color'],
                                    'logo_path' => $resolvedTemplate['logo_path'],
                                    'signature_path' => $resolvedTemplate['signature_path'],
                                    'signature_text' => $resolvedTemplate['signature_text'],
                                    'header_motto' => $resolvedTemplate['header_motto'],
                                    'price_label' => $resolvedTemplate['price_label'],
                                    'secretary_general_name' => $resolvedTemplate['secretary_general_name'],
                                    'secretary_general_title' => $resolvedTemplate['secretary_general_title'],
                                    'year_label' => $resolvedTemplate['year_label'],
                                    'show_logo' => $resolvedTemplate['show_logo'] ? 1 : 0,
                                    'show_qr' => $resolvedTemplate['show_qr'] ? 1 : 0,
                                    'show_border' => $resolvedTemplate['show_border'] ? 1 : 0,
                                    'show_flag_band' => $resolvedTemplate['show_flag_band'] ? 1 : 0,
                                    'show_secretary_block' => $resolvedTemplate['show_secretary_block'] ? 1 : 0,
                                ]);
                                $previewHeaderStyle = 'background: linear-gradient(135deg, ' . $resolvedTemplate['primary'] . ', ' . $resolvedTemplate['secondary'] . '); color: ' . $resolvedTemplate['header_text_color'] . ';';
                                $previewBodyStyle = 'background: ' . $resolvedTemplate['accent'] . '; color: ' . $resolvedTemplate['text_color'] . ';';
                            @endphp
                            <div class="member-card-preview member-card-preview-shell rounded shadow-sm overflow-hidden h-100">
                                <div class="p-3 member-card-preview-header" style="<?php echo e($previewHeaderStyle); ?>">
                                    <div class="small text-uppercase mb-1">{{ $card['header_motto'] }}</div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="small text-uppercase">SYNEM {{ $card['year_label'] }}</div>
                                            <div class="fw-bold">CARTE DE MEMBRE</div>
                                        </div>
                                        @if($card['show_logo'] && $card['logo'])
                                            <img src="{{ $card['logo'] }}" alt="Logo" style="width: 44px; height: 44px; object-fit: contain; background: rgba(255,255,255,0.95); border-radius: 10px; padding: 4px;">
                                        @endif
                                    </div>
                                </div>
                                @if($card['show_flag_band'])
                                    <div class="d-flex" style="height: 8px;">
                                        <div style="flex:1;background:#0b8f3c;"></div>
                                        <div style="flex:1;background:#f2c94c;"></div>
                                        <div style="flex:1;background:#d62828;"></div>
                                    </div>
                                @endif
                                <div class="p-3" style="<?php echo e($previewBodyStyle); ?>">
                                    <div class="d-flex gap-3 align-items-start mb-3">
                                        <img src="{{ $card['photo'] }}" alt="Photo" class="rounded member-card-preview-photo">
                                        <div>
                                            <div class="small"><strong>N° membre :</strong> {{ $card['card_number'] }}</div>
                                            <div class="small"><strong>Nom :</strong> {{ $card['nom'] }}</div>
                                            <div class="small"><strong>Prenom :</strong> {{ $card['prenom'] }}</div>
                                            <div class="small"><strong>Division :</strong> {{ $card['division'] }}</div>
                                            <div class="small"><strong>Coord. / Region :</strong> {{ $card['region'] }}</div>
                                            <div class="small"><strong>Telephone :</strong> {{ $card['phone'] }}</div>
                                            <div class="small"><strong>Prix :</strong> {{ $card['price_label'] }}</div>
                                        </div>
                                    </div>
                                    @if($card['show_secretary_block'])
                                        <div class="d-flex justify-content-between align-items-end gap-3 border-top pt-2 mb-2">
                                            <div>
                                                <div class="small fw-semibold">{{ $card['secretary_general_title'] }}</div>
                                                <div class="small">{{ $card['secretary_general_name'] }}</div>
                                            </div>
                                            @if($card['signature_image'])
                                                <img src="{{ $card['signature_image'] }}" alt="Signature" style="width:120px;height:42px;object-fit:contain;">
                                            @endif
                                        </div>
                                    @endif
                                    @if($card['show_qr'] && $card['qr_code'])
                                        <div class="d-flex justify-content-between align-items-end gap-3 border-top pt-2">
                                            <div class="small text-muted">QR unique de verification</div>
                                            <img src="{{ $card['qr_code'] }}" alt="QR code" style="width:72px;height:72px;">
                                        </div>
                                    @endif
                                </div>
                                <div class="px-3 pb-3 d-flex justify-content-between align-items-center">
                                    <small class="text-muted">{{ $card['show_secretary_block'] ? $card['secretary_general_title'] . ' · ' . $card['secretary_general_name'] : 'Prete pour export' }}</small>
                                    <div class="d-flex gap-2">
                                        <a class="btn btn-sm btn-outline-secondary" target="_blank" href="{{ route('administration.pages.cartes-membres.militants.download', $card['militant']) }}?{{ $cardQuery }}&inline=1">
                                            Imprimer
                                        </a>
                                        <a class="btn btn-sm btn-primary" href="{{ route('administration.pages.cartes-membres.militants.download', $card['militant']) }}?{{ $cardQuery }}">
                                            PDF
                                        </a>
                                        <a class="btn btn-sm btn-outline-dark" href="{{ route('administration.pages.cartes-membres.militants.image', $card['militant']) }}?{{ $cardQuery }}">
                                            Image
                                        </a>
                                        <form action="{{ route('administration.pages.cartes-membres.submissions.destroy', $card['submission']) }}" method="POST" class="js-delete-card-form" data-card-delete-message="Supprimer cette carte ?">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" type="submit">Supprimer</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-warning mb-0">Aucune photo validée n'est encore disponible pour générer des cartes.</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mt-4 shadow-sm" id="submissions">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h5 class="mb-1">Photos envoyées par les militants</h5>
            <small class="text-muted">Visualisation, validation ou demande de nouvelle photo.</small>
        </div>
        <form class="d-flex gap-2" method="GET" action="{{ route('administration.pages.cartes-membres.index') }}#submissions">
            <select class="form-select" name="submission_status">
                <option value="all">Tous les statuts</option>
                <option value="pending" {{ request('submission_status') === 'pending' ? 'selected' : '' }}>En attente</option>
                <option value="approved" {{ request('submission_status') === 'approved' ? 'selected' : '' }}>Validées</option>
                <option value="revision_requested" {{ request('submission_status') === 'revision_requested' ? 'selected' : '' }}>Nouvelle photo demandée</option>
            </select>
            <button class="btn btn-outline-primary" type="submit">Filtrer</button>
        </form>
    </div>
    <div class="card-body">
        <div class="row g-4">
            @forelse($submissions as $submission)
                <div class="col-lg-6">
                    <div class="border rounded p-3 h-100">
                        <div class="d-flex gap-3">
                            <img src="{{ $submission->photo_url }}" alt="Photo militant" class="rounded border" style="width: 140px; height: 170px; object-fit: cover;">
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                                    <div>
                                        <h6 class="mb-1">{{ $submission->militant?->full_name ?? 'Militant' }}</h6>
                                        <div class="text-muted small">{{ $submission->militant?->email }}</div>
                                        <div class="text-muted small">N° membre : {{ $submission->militant?->n_cartes_syndicale ?: 'Non renseigné' }}</div>
                                        <div class="text-muted small">Fonction / statut : {{ $submission->militant?->coordinations ?: 'Militant approuvé' }}</div>
                                    </div>
                                    <span class="badge {{ $submission->status === 'approved' ? 'bg-success' : ($submission->status === 'revision_requested' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                        {{ $submission->status_label }}
                                    </span>
                                </div>

                                <div class="small text-muted mt-2">
                                    Campagne : {{ $submission->campaign?->title ?? 'Non définie' }}<br>
                                    Photo reçue le {{ optional($submission->submitted_at)->format('d/m/Y H:i') }}
                                </div>

                                <form action="{{ route('administration.pages.cartes-membres.militants.identity', $submission->militant) }}" method="POST" class="row g-2 mt-3 mb-3">
                                    @csrf
                                    @method('PATCH')
                                    <div class="col-sm-6">
                                        <input class="form-control form-control-sm" type="text" name="nom" value="{{ $submission->militant?->nom }}" placeholder="Nom" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input class="form-control form-control-sm" type="text" name="prenom" value="{{ $submission->militant?->prenom }}" placeholder="Prenom" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input class="form-control form-control-sm" type="text" name="division" value="{{ $submission->militant?->division }}" placeholder="Division">
                                    </div>
                                    <div class="col-sm-6">
                                        <input class="form-control form-control-sm" type="text" name="region" value="{{ $submission->militant?->region }}" placeholder="Region">
                                    </div>
                                    <div class="col-sm-6">
                                        <input class="form-control form-control-sm" type="text" name="coordinations" value="{{ $submission->militant?->coordinations }}" placeholder="Coordination">
                                    </div>
                                    <div class="col-sm-6">
                                        <input class="form-control form-control-sm" type="text" name="tel" value="{{ $submission->militant?->tel }}" placeholder="Telephone" required>
                                    </div>
                                    <div class="col-12">
                                        <input class="form-control form-control-sm" type="text" name="n_cartes_syndicale" value="{{ $submission->militant?->n_cartes_syndicale }}" placeholder="Numero membre" required>
                                    </div>
                                    <div class="col-12 d-grid">
                                        <button class="btn btn-sm btn-outline-primary" type="submit">Mettre a jour les donnees carte</button>
                                    </div>
                                </form>

                                @if($submission->admin_comment)
                                    <div class="alert alert-light border mt-3 mb-3 py-2 px-3">
                                        <strong>Commentaire :</strong> {{ $submission->admin_comment }}
                                    </div>
                                @endif

                                <form action="{{ route('administration.pages.cartes-membres.submissions.review', $submission) }}" method="POST" class="row g-2 mt-1">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="redirect_submission_status" value="{{ request('submission_status', 'all') }}">
                                    <div class="col-12">
                                        <textarea class="form-control" name="admin_comment" rows="2" placeholder="Commentaire optionnel pour la validation ou la demande de reprise...">{{ old('admin_comment') }}</textarea>
                                    </div>
                                    <div class="col-sm-6 d-grid">
                                        <button class="btn btn-success" type="submit" name="status" value="approved">
                                            <i class="fas fa-check me-1"></i>
                                            Valider la photo
                                        </button>
                                    </div>
                                    <div class="col-sm-6 d-grid">
                                        <button class="btn btn-outline-danger" type="submit" name="status" value="revision_requested">
                                            <i class="fas fa-redo me-1"></i>
                                            Demander une nouvelle photo
                                        </button>
                                    </div>
                                </form>

                                <form action="{{ route('administration.pages.cartes-membres.submissions.destroy', $submission) }}" method="POST" class="mt-2 js-delete-card-form" data-card-delete-message="Supprimer definitivement cette carte et sa photo ?">
                                    @csrf
                                    @method('DELETE')
                                    <div class="d-grid">
                                        <button class="btn btn-sm btn-outline-danger" type="submit">
                                            <i class="fas fa-trash me-1"></i>
                                            Supprimer cette carte
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info mb-0">Aucune photo n'a encore été soumise.</div>
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $submissions->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkAllButton = document.getElementById('checkAllMilitants');
    const uncheckAllButton = document.getElementById('uncheckAllMilitants');
    const signatureCanvas = document.getElementById('signaturePad');
    const clearSignatureButton = document.getElementById('clearSignaturePad');
    const signatureForm = document.getElementById('signatureForm');
    const signatureDataInput = document.getElementById('signatureData');
    const signatureFileInput = document.getElementById('signatureFile');
    const signatureTextInput = document.getElementById('signatureText');
    const signatureStatus = document.getElementById('signatureStatus');
    const signaturePreviewLive = document.getElementById('signaturePreviewLive');
    const signatureTextPreview = document.getElementById('signatureTextPreview');
    const selectedMilitantsCount = document.getElementById('selectedMilitantsCount');
    const deleteCardForms = Array.from(document.querySelectorAll('.js-delete-card-form'));

    const getSelectors = () => Array.from(document.querySelectorAll('.militant-selector'));

    const setAllSelectors = (checked) => {
        const selectors = getSelectors();

        selectors.forEach((selector) => {
            selector.checked = checked;
        });

        updateToggleButtonLabel();
    };

    // Fallback global pour garantir le fonctionnement meme si un listener local saute.
    window.synemBulkSelect = function (checked) {
        const selectors = getSelectors();

        if (selectors.length === 0) {
            if (checked && window.Swal && typeof window.Swal.fire === 'function') {
                window.Swal.fire({
                    icon: 'info',
                    title: 'Aucun militant pret',
                    text: 'Aucune photo validee n\'est encore disponible pour la generation multiple.',
                });
            }

            updateToggleButtonLabel();
            return false;
        }

        setAllSelectors(checked);
        return false;
    };

    const updateToggleButtonLabel = () => {
        const selectors = getSelectors();

        if (!checkAllButton || !uncheckAllButton) {
            return;
        }

        if (selectors.length === 0) {
            checkAllButton.textContent = 'Aucun militant';
            checkAllButton.disabled = true;
            uncheckAllButton.disabled = true;
            return;
        }

        const allChecked = selectors.every((selector) => selector.checked);
        checkAllButton.disabled = allChecked;
        uncheckAllButton.disabled = !selectors.some((selector) => selector.checked);

        const checkedCount = selectors.filter((selector) => selector.checked).length;
        if (selectedMilitantsCount) {
            selectedMilitantsCount.textContent = checkedCount + ' selectionne' + (checkedCount > 1 ? 's' : '');
        }

        selectors.forEach((selector) => {
            const item = selector.closest('.member-selector-item');
            if (item) {
                item.classList.toggle('is-selected', selector.checked);
            }
        });
    };

    if (checkAllButton && uncheckAllButton) {
        checkAllButton.addEventListener('click', function (event) {
            event.preventDefault();
            window.synemBulkSelect(true);
        });

        uncheckAllButton.addEventListener('click', function (event) {
            event.preventDefault();
            window.synemBulkSelect(false);
        });

        getSelectors().forEach((selector) => {
            selector.addEventListener('change', updateToggleButtonLabel);
            selector.addEventListener('click', function () {
                window.requestAnimationFrame(updateToggleButtonLabel);
            });
        });

        updateToggleButtonLabel();
    }

    deleteCardForms.forEach((form) => {
        form.addEventListener('submit', function (event) {
            if (!window.Swal || typeof window.Swal.fire !== 'function') {
                return;
            }

            event.preventDefault();

            window.Swal.fire({
                icon: 'warning',
                title: 'Confirmation requise',
                text: form.dataset.cardDeleteMessage || 'Supprimer cette carte ?',
                showCancelButton: true,
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler',
                confirmButtonColor: '#dc3545',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    if (signatureCanvas && signatureForm && signatureDataInput) {
        const context = signatureCanvas.getContext('2d');
        let isDrawing = false;
        let hasDrawn = false;

        const updateSignatureStatus = (message, isActive = false) => {
            if (!signatureStatus) {
                return;
            }

            signatureStatus.textContent = message;
            signatureStatus.classList.toggle('text-success', isActive);
            signatureStatus.classList.toggle('fw-semibold', isActive);
            signatureStatus.classList.toggle('text-muted', !isActive);
        };

        const updateSignaturePreview = (dataUrl = '') => {
            if (!signaturePreviewLive) {
                return;
            }

            if (!dataUrl) {
                signaturePreviewLive.src = '';
                signaturePreviewLive.classList.add('d-none');
                return;
            }

            signaturePreviewLive.src = dataUrl;
            signaturePreviewLive.classList.remove('d-none');
        };

        const updateSignatureTextPreview = () => {
            if (!signatureTextPreview || !signatureTextInput) {
                return;
            }

            const value = signatureTextInput.value.trim();
            signatureTextPreview.textContent = value || 'Votre signature texte apparaitra ici.';
        };

        const resizeCanvas = () => {
            const ratio = window.devicePixelRatio || 1;
            const rect = signatureCanvas.getBoundingClientRect();
            signatureCanvas.width = rect.width * ratio;
            signatureCanvas.height = rect.height * ratio;
            context.setTransform(1, 0, 0, 1, 0, 0);
            context.scale(ratio, ratio);
            context.lineWidth = 2.2;
            context.lineCap = 'round';
            context.lineJoin = 'round';
            context.strokeStyle = '#0f172a';
            context.fillStyle = '#ffffff';
            context.fillRect(0, 0, rect.width, rect.height);
            hasDrawn = false;
            updateSignatureStatus('Aucune signature detectee pour le moment.');
            updateSignaturePreview('');
        };

        const getPoint = (event) => {
            const rect = signatureCanvas.getBoundingClientRect();
            const source = event.touches ? event.touches[0] : (event.changedTouches ? event.changedTouches[0] : event);
            return {
                x: source.clientX - rect.left,
                y: source.clientY - rect.top,
            };
        };

        const startDrawing = (event) => {
            event.preventDefault();
            isDrawing = true;
            hasDrawn = true;
            if (typeof signatureCanvas.setPointerCapture === 'function') {
                signatureCanvas.setPointerCapture(event.pointerId);
            }
            const point = getPoint(event);
            context.beginPath();
            context.moveTo(point.x, point.y);
            context.arc(point.x, point.y, 0.8, 0, Math.PI * 2);
            context.fillStyle = '#0f172a';
            context.fill();
            context.beginPath();
            context.moveTo(point.x, point.y);
            const pointerType = event.pointerType || (event.touches ? 'touch' : 'mouse');
            const label = pointerType === 'touch' ? 'doigt' : (pointerType === 'pen' ? 'stylet' : 'souris');
            updateSignatureStatus('Signature detectee via ' + label + '. Vous pouvez maintenant enregistrer.', true);
            updateSignaturePreview(signatureCanvas.toDataURL('image/png'));
        };

        const draw = (event) => {
            if (!isDrawing) {
                return;
            }

            event.preventDefault();
            hasDrawn = true;
            const point = getPoint(event);
            context.lineTo(point.x, point.y);
            context.stroke();
            updateSignatureStatus('Signature detectee. Vous pouvez maintenant enregistrer.', true);
            updateSignaturePreview(signatureCanvas.toDataURL('image/png'));
        };

        const stopDrawing = (event) => {
            isDrawing = false;

            if (event && typeof signatureCanvas.releasePointerCapture === 'function') {
                try {
                    signatureCanvas.releasePointerCapture(event.pointerId);
                } catch (error) {
                }
            }
        };

        resizeCanvas();
        window.addEventListener('resize', resizeCanvas);

        if (window.PointerEvent) {
            signatureCanvas.addEventListener('pointerdown', startDrawing);
            signatureCanvas.addEventListener('pointermove', draw);
            signatureCanvas.addEventListener('pointerup', stopDrawing);
            signatureCanvas.addEventListener('pointerleave', stopDrawing);
            signatureCanvas.addEventListener('pointercancel', stopDrawing);
        } else {
            signatureCanvas.addEventListener('mousedown', startDrawing);
            signatureCanvas.addEventListener('mousemove', draw);
            signatureCanvas.addEventListener('mouseup', stopDrawing);
            signatureCanvas.addEventListener('mouseleave', stopDrawing);
            signatureCanvas.addEventListener('touchstart', startDrawing, { passive: false });
            signatureCanvas.addEventListener('touchmove', draw, { passive: false });
            signatureCanvas.addEventListener('touchend', stopDrawing);
            signatureCanvas.addEventListener('touchcancel', stopDrawing);
        }

        if (clearSignatureButton) {
            clearSignatureButton.addEventListener('click', function () {
                resizeCanvas();
                signatureDataInput.value = '';
                if (signatureFileInput) {
                    signatureFileInput.value = '';
                }
                if (signatureTextInput) {
                    signatureTextInput.value = '';
                }
                updateSignatureTextPreview();
                updateToggleButtonLabel();
            });
        }

        signatureForm.addEventListener('submit', function (event) {
            const hasUploadedFile = signatureFileInput && signatureFileInput.files && signatureFileInput.files.length > 0;
            const hasSignatureText = signatureTextInput && signatureTextInput.value.trim().length > 0;

            if (!hasDrawn && !hasUploadedFile && !hasSignatureText) {
                event.preventDefault();
                if (window.Swal && typeof window.Swal.fire === 'function') {
                    window.Swal.fire({
                        icon: 'warning',
                        title: 'Signature requise',
                        text: 'Dessinez la signature, choisissez un fichier image ou saisissez une signature texte.',
                    });
                } else {
                    alert('Dessinez la signature, choisissez un fichier image ou saisissez une signature texte.');
                }
                return;
            }

            signatureDataInput.value = hasUploadedFile || hasSignatureText ? '' : signatureCanvas.toDataURL('image/png');
        });

        if (signatureFileInput) {
            signatureFileInput.addEventListener('change', function () {
                if (signatureFileInput.files && signatureFileInput.files.length > 0) {
                    updateSignatureStatus('Image de signature selectionnee. Elle sera utilisee a l\'enregistrement.', true);
                    updateSignaturePreview('');
                } else if (!hasDrawn) {
                    updateSignatureStatus('Aucune signature detectee pour le moment.');
                }
            });
        }

        if (signatureTextInput) {
            signatureTextInput.addEventListener('input', updateSignatureTextPreview);
            updateSignatureTextPreview();
        }

    }
});
</script>
<script>
(function () {
    const getSelectors = () => Array.from(document.querySelectorAll('input[name="militant_ids[]"]'));

    const syncSelectedStyles = () => {
        const selectors = getSelectors();
        const selectedMilitantsCount = document.getElementById('selectedMilitantsCount');

        if (selectedMilitantsCount) {
            const checkedCount = selectors.filter((selector) => selector.checked).length;
            selectedMilitantsCount.textContent = checkedCount + ' selectionne' + (checkedCount > 1 ? 's' : '');
        }

        selectors.forEach((selector) => {
            const item = selector.closest('.member-selector-item');
            if (item) {
                item.classList.toggle('is-selected', selector.checked);
            }
        });
    };

    const bulkSet = (checked) => {
        const selectors = getSelectors();
        selectors.forEach((selector) => {
            selector.checked = checked;
        });
        syncSelectedStyles();
    };

    document.addEventListener('click', function (event) {
        const checkAllBtn = event.target.closest('#checkAllMilitants');
        if (checkAllBtn) {
            event.preventDefault();
            bulkSet(true);
            return;
        }

        const uncheckAllBtn = event.target.closest('#uncheckAllMilitants');
        if (uncheckAllBtn) {
            event.preventDefault();
            bulkSet(false);
        }
    });

    document.addEventListener('change', function (event) {
        if (event.target && event.target.matches('input[name="militant_ids[]"]')) {
            syncSelectedStyles();
        }
    });

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', syncSelectedStyles);
    } else {
        syncSelectedStyles();
    }
})();
</script>
@endpush