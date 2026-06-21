@extends('layouts.administration')
@section('title', 'Nouvelle Lettre')

@section('content')
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">SYNEM</div>
    <div class="ps-3"><nav aria-label="breadcrumb"><ol class="breadcrumb mb-0 p-0">
        <li class="breadcrumb-item"><a href="{{ route('administration.tableau-de-bord') }}"><i class="bx bx-home-alt"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ route('administration.lettres.index') }}">Lettres</a></li>
        <li class="breadcrumb-item active">Nouvelle lettre</li>
    </ol></nav></div>
</div>

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('administration.lettres.index') }}" class="btn btn-outline-secondary btn-sm"><i class='bx bx-arrow-back'></i></a>
    <h4 class="mb-0 fw-bold" style="color:#1547c0"><i class='bx bx-plus-circle me-2'></i>Nouvelle Lettre Administrative</h4>
</div>

@if($errors->any())
<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
@endif

{{-- ── TYPE DE LETTRE ─────────────────────────────────────────── --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header fw-semibold" style="background:linear-gradient(135deg,#1547c0,#0a2a7a);color:#fff">
        <i class='bx bx-category me-2'></i>Choisissez le type de lettre
        <small class="ms-2 opacity-75">— les champs se rempliront automatiquement</small>
    </div>
    <div class="card-body py-3">
        <style>
        .type-btn {
            border: 2px solid #dde2f0;
            background: #f8f9fa;
            cursor: pointer;
            transition: border-color .2s, background .2s, transform .15s;
            border-radius: 12px;
            padding: 14px 8px;
            height: 90px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 6px;
            user-select: none;
        }
        .type-btn:hover { transform: translateY(-2px); }
        .type-btn.actif { transform: translateY(-2px); }
        .type-btn i { font-size: 1.6rem; line-height: 1; }
        .type-btn span { font-size: 11px; font-weight: 700; color: #444; text-align: center; line-height: 1.2; }
        </style>
        <div class="row g-2">
            <div class="col-4 col-md-2">
                <div class="type-btn" data-type="circulaire">
                    <i class='bx bx-broadcast' style="color:#4361ee"></i>
                    <span>Circulaire</span>
                </div>
            </div>
            <div class="col-4 col-md-2">
                <div class="type-btn" data-type="convocation">
                    <i class='bx bx-calendar-event' style="color:#f77f00"></i>
                    <span>Convocation</span>
                </div>
            </div>
            <div class="col-4 col-md-2">
                <div class="type-btn" data-type="note">
                    <i class='bx bx-note' style="color:#2dc653"></i>
                    <span>Note de service</span>
                </div>
            </div>
            <div class="col-4 col-md-2">
                <div class="type-btn" data-type="communique">
                    <i class='bx bx-megaphone' style="color:#e63946"></i>
                    <span>Communiqué</span>
                </div>
            </div>
            <div class="col-4 col-md-2">
                <div class="type-btn" data-type="courrier">
                    <i class='bx bx-envelope' style="color:#7209b7"></i>
                    <span>Courrier officiel</span>
                </div>
            </div>
            <div class="col-4 col-md-2">
                <div class="type-btn" data-type="autre">
                    <i class='bx bx-edit-alt' style="color:#888"></i>
                    <span>Autre / Libre</span>
                </div>
            </div>
        </div>
        <div id="bandeau-type" style="display:none;margin-top:10px;padding:6px 12px;border-radius:8px;font-size:13px;font-weight:600">
            ✓ Type sélectionné — les champs ont été pré-remplis. Vous pouvez les modifier.
        </div>
    </div>
</div>

<form id="formLettre" method="POST" action="{{ route('administration.lettres.store') }}" enctype="multipart/form-data">
@csrf
<input type="hidden" name="signature_base64" id="signature_base64">

<div class="row g-4">

{{-- ══════ COLONNE GAUCHE ══════ --}}
<div class="col-lg-8">

    {{-- Infos générales --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header fw-semibold" style="background:#f0f4ff;color:#1547c0">
            <i class='bx bx-info-circle me-2'></i>Informations générales
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">N° de la lettre <span class="text-danger">*</span></label>
                    <input type="text" name="numero" id="numero" class="form-control"
                        value="{{ old('numero', $nextNumero) }}" required>
                    <small class="text-muted">Auto-généré, modifiable.</small>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Date <span class="text-danger">*</span></label>
                    <input type="date" name="date_lettre" id="date_lettre" class="form-control"
                        value="{{ old('date_lettre', date('Y-m-d')) }}" required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <div class="w-100 text-center py-2 rounded-3" style="background:#f0f4ff;border:1px dashed #1547c0;font-size:12px">
                        <div style="color:#888;font-size:10px">Lieu</div>
                        <div style="color:#1547c0;font-weight:700">Bamako</div>
                    </div>
                </div>

                {{-- Destinataire --}}
                <div class="col-12">
                    <label class="form-label fw-semibold">Destinataire <span class="text-danger">*</span></label>
                    <div class="mb-2">
                        <small class="text-muted">Sélection rapide :</small>
                        <div class="d-flex flex-wrap gap-1 mt-1">
                            <button type="button" class="btn btn-sm btn-outline-primary py-0" style="font-size:11px;border-radius:20px"
                                onclick="setDestinataire('À Mesdames et Messieurs les Coordinateurs Régionaux\nSections SYNEM du Mali')">Coordinateurs</button>
                            <button type="button" class="btn btn-sm btn-outline-primary py-0" style="font-size:11px;border-radius:20px"
                                onclick="setDestinataire('Aux membres du Bureau Exécutif National\nBEN-SYNEM\nBamako')">Bureau Exécutif</button>
                            <button type="button" class="btn btn-sm btn-outline-primary py-0" style="font-size:11px;border-radius:20px"
                                onclick="setDestinataire('À l\'ensemble des membres\ndu Syndicat National des Enseignants du Mali (SYNEM)')">Tous les membres</button>
                            <button type="button" class="btn btn-sm btn-outline-primary py-0" style="font-size:11px;border-radius:20px"
                                onclick="setDestinataire('À Monsieur le Ministre de l\'Éducation Nationale\nMinistère de l\'Éducation Nationale\nBamako, Mali')">Ministère</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary py-0" style="font-size:11px;border-radius:20px"
                                onclick="document.getElementById('destinataire').value=''">Effacer</button>
                        </div>
                    </div>
                    <textarea name="destinataire" id="destinataire" class="form-control" rows="3" required
                        placeholder="Sélectionnez ou saisissez le destinataire...">{{ old('destinataire') }}</textarea>
                </div>

                {{-- Objet --}}
                <div class="col-12">
                    <label class="form-label fw-semibold">Objet <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" name="objet" id="objet" class="form-control"
                            value="{{ old('objet') }}" required
                            placeholder="Saisissez l'objet, puis cliquez sur Générer le corps →">
                        <button type="button" class="btn btn-primary" id="btnGenererCorps">
                            <i class='bx bx-brain me-1'></i>Générer le corps
                        </button>
                    </div>
                    <small class="text-muted">Après avoir saisi l'objet, l'IA rédige automatiquement tout le corps de la lettre.</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Corps --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header fw-semibold" style="background:#f0f4ff;color:#1547c0">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <span><i class='bx bx-text me-2'></i>Corps de la lettre <span class="text-danger">*</span></span>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="btnFormules">
                        <i class='bx bx-text me-1'></i>Formules
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalIA">
                        <i class='bx bx-brain me-1'></i>IA libre
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body position-relative">
            {{-- Overlay chargement IA --}}
            <div id="corpsLoading" style="display:none;position:absolute;inset:0;background:rgba(255,255,255,.88);z-index:10;border-radius:4px;align-items:center;justify-content:center;flex-direction:column">
                <div class="spinner-border text-primary mb-2" role="status"></div>
                <div class="fw-semibold text-primary">L'IA rédige votre lettre...</div>
            </div>

            <textarea name="corps" id="corps" class="form-control" rows="16" required
                placeholder="Cliquez sur « Générer le corps » pour que l'IA rédige automatiquement...&#10;Ou rédigez manuellement ici.">{{ old('corps') }}</textarea>

            {{-- Formules rapides --}}
            <div id="panelFormules" style="display:none;margin-top:12px;padding:12px;background:#f8f9fa;border:1px solid #dde2f0;border-radius:8px">
                <div style="font-size:12px;font-weight:700;color:#1547c0;margin-bottom:8px">Formules — cliquez pour insérer au curseur</div>
                <div class="d-flex flex-wrap gap-2">
                    @php $formules = [
                        'Camarades,',
                        'Chers camarades,',
                        'J\'ai l\'honneur de porter à votre connaissance que',
                        'En référence à votre correspondance en date du',
                        'Je vous prie de bien vouloir',
                        'Veuillez trouver ci-joint',
                        'Je reste à votre disposition pour tout renseignement complémentaire.',
                        'Dans l\'espoir d\'une suite favorable, je vous adresse mes sincères salutations syndicales.',
                        'Fraternellement,',
                    ]; @endphp
                    @foreach($formules as $f)
                    <button type="button" class="btn btn-sm btn-outline-secondary py-0"
                        style="font-size:11px;border-radius:20px"
                        onclick="insererAuCurseur({{ json_encode($f) }})">
                        {{ \Illuminate\Support\Str::limit($f, 38) }}
                    </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Ampliations --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header fw-semibold d-flex justify-content-between align-items-center" style="background:#f0f4ff;color:#1547c0">
            <span><i class='bx bx-list-ul me-2'></i>Ampliations</span>
            <button type="button" class="btn btn-sm btn-outline-primary py-0" id="btnResetAmp" style="font-size:11px">
                <i class='bx bx-reset me-1'></i>Standard SYNEM
            </button>
        </div>
        <div class="card-body">
            <textarea name="ampliations" id="ampliations" class="form-control" rows="5">{{ old('ampliations', "Archives/Chrono ………..03\nSecrétariat Général\nTrésorerie Générale\nConseil Consultatif\nClasseur") }}</textarea>
            <small class="text-muted">Une ampliation par ligne.</small>
        </div>
    </div>

</div>
{{-- ══════ COLONNE DROITE ══════ --}}
<div class="col-lg-4">

    {{-- Signataire --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header fw-semibold" style="background:#f0f4ff;color:#1547c0">
            <i class='bx bx-user-check me-2'></i>Signataire
        </div>
        <div class="card-body">
            {{-- Liste des admins --}}
            @if($signataires->count() > 0)
            <div class="mb-3">
                <label class="form-label fw-semibold" style="font-size:12px">Choisir depuis la liste des admins</label>
                <select class="form-select form-select-sm" id="selectSignataire">
                    <option value="">— Sélectionner un admin —</option>
                    @foreach($signataires as $s)
                    <option value="{{ $s->name }}" data-fonction="{{ $s->fonction ?? '' }}">
                        {{ $s->name }}{{ $s->fonction ? ' ('.$s->fonction.')' : '' }}
                    </option>
                    @endforeach
                    <option value="__autre__">✏ Autre — saisir manuellement</option>
                </select>
            </div>
            @endif

            <div class="mb-3">
                <label class="form-label fw-semibold">Nom du signataire <span class="text-danger">*</span></label>
                <input type="text" name="signataire" id="signataire" class="form-control"
                    value="{{ old('signataire', $currentUser->role !== 'superadmin' ? $currentUser->name : '') }}"
                    required placeholder="Prénom NOM">
            </div>
            <div class="mb-2">
                <label class="form-label fw-semibold">Fonction <span class="text-danger">*</span></label>
                <input type="text" name="fonction_signataire" id="fonction_signataire" class="form-control"
                    value="{{ old('fonction_signataire', $currentUser->role !== 'superadmin' ? ($currentUser->fonction ?? '') : '') }}"
                    required placeholder="Ex : Le Secrétaire Général">
            </div>
        </div>
    </div>

    {{-- Signature électronique --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header fw-semibold" style="background:#f0f4ff;color:#1547c0">
            <i class='bx bx-pencil me-2'></i>Signature électronique
        </div>
        <div class="card-body p-0">
            <ul class="nav nav-tabs px-3 pt-2 border-0">
                <li class="nav-item">
                    <button type="button" class="nav-link active py-1 px-3" id="tabDessiner"
                        style="font-size:12px" onclick="switchSigTab('dessiner')">
                        <i class='bx bx-edit me-1'></i>Dessiner
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link py-1 px-3" id="tabImporter"
                        style="font-size:12px" onclick="switchSigTab('importer')">
                        <i class='bx bx-upload me-1'></i>Importer
                    </button>
                </li>
            </ul>

            {{-- Panneau Dessiner --}}
            <div id="panelDessiner" class="px-3 pb-3 pt-2">
                <div style="border:2px dashed #1547c0;border-radius:8px;background:#fafbff;position:relative">
                    <canvas id="sigCanvas" width="300" height="110"
                        style="width:100%;height:110px;cursor:crosshair;display:block;border-radius:6px;touch-action:none"></canvas>
                    <div id="sigPlaceholder"
                        style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;pointer-events:none;color:#b0b8d0;font-size:12px">
                        <i class='bx bx-pencil me-1'></i>Dessinez votre signature ici
                    </div>
                </div>
                <div class="d-flex gap-2 mt-2">
                    <button type="button" class="btn btn-sm btn-outline-danger py-0" id="btnEffacerSig">
                        <i class='bx bx-trash me-1'></i>Effacer
                    </button>
                    <div class="d-flex align-items-center gap-1 ms-auto">
                        <small class="text-muted">Couleur :</small>
                        <input type="color" id="sigColor" value="#1547c0" style="width:28px;height:28px;border:none;padding:0;border-radius:4px;cursor:pointer">
                    </div>
                </div>
                <small class="text-muted d-block mt-1">Signez avec votre souris ou votre doigt (tablette).</small>
            </div>

            {{-- Panneau Importer --}}
            <div id="panelImporter" class="px-3 pb-3 pt-2" style="display:none">
                <input type="file" name="signature_fichier" id="signature_fichier" class="form-control" accept="image/*">
                <small class="text-muted">PNG avec fond transparent recommandé. Max 2 Mo.</small>
                <div id="previewSignature" style="display:none;margin-top:8px;text-align:center">
                    <img id="previewSignatureImg" style="max-height:80px;border:1px solid #eee;border-radius:6px;padding:4px">
                </div>
            </div>
        </div>
    </div>

    {{-- Sceau électronique --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header fw-semibold" style="background:#f0f4ff;color:#1547c0">
            <i class='bx bx-shield me-2'></i>Sceau électronique (tampon officiel)
        </div>
        <div class="card-body">
            <input type="file" name="cachet" id="cachet" class="form-control" accept="image/*">
            <small class="text-muted">Image du tampon/sceau officiel du SYNEM. PNG avec fond transparent.</small>
            <div id="previewSceau" style="display:none;margin-top:8px;text-align:center">
                <img id="previewSceauImg" style="max-height:80px;border:1px solid #eee;border-radius:6px;padding:4px">
            </div>
        </div>
    </div>

    {{-- Pièces jointes --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header fw-semibold" style="background:#f0f4ff;color:#1547c0">
            <i class='bx bx-paperclip me-2'></i>Pièces jointes
        </div>
        <div class="card-body">
            <input type="file" name="pieces_jointes[]" class="form-control" multiple>
            <small class="text-muted">Plusieurs fichiers acceptés (max 5 Mo chacun).</small>
        </div>
    </div>

    {{-- Publication --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header fw-semibold" style="background:#f0f4ff;color:#1547c0">
            <i class='bx bx-cog me-2'></i>Publication
        </div>
        <div class="card-body">
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" name="est_publiee" id="est_publiee" value="1" {{ old('est_publiee') ? 'checked' : '' }}>
                <label class="form-check-label" for="est_publiee"><strong>Publier</strong> dans les Actualités du site</label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="est_telechargeable" id="est_telechargeable" value="1" checked>
                <label class="form-check-label" for="est_telechargeable"><strong>Téléchargeable</strong> par les militants</label>
            </div>
        </div>
    </div>

    <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary btn-lg"><i class='bx bx-save me-2'></i>Enregistrer la lettre</button>
        <a href="{{ route('administration.lettres.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </div>
</div>
</div>
</form>

{{-- Modal IA libre --}}
<div class="modal fade" id="modalIA" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background:linear-gradient(135deg,#1547c0,#0a2a7a);color:#fff">
                <h5 class="modal-title"><i class='bx bx-brain me-2'></i>Assistance IA — Rédaction libre</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info py-2 mb-3"><i class='bx bx-info-circle me-1'></i>Décrivez votre besoin ou collez un texte à améliorer. Assistant propulsé par le quota gratuit Groq.</div>
                <textarea id="iaPrompt" class="form-control mb-3" rows="5"
                    placeholder="Ex : Améliore ce texte... / Rédige une introduction pour..."></textarea>
                <button type="button" id="btnIA" class="btn btn-primary">
                    <i class='bx bx-send me-1'></i><span id="btnIAText">Générer</span>
                </button>
                <div id="iaResult" class="mt-3" style="display:none">
                    <label class="form-label fw-semibold text-success"><i class='bx bx-check-circle me-1'></i>Résultat IA</label>
                    <textarea id="iaResultText" class="form-control" rows="10"></textarea>
                    <button type="button" id="btnInsererIA" class="btn btn-success mt-2 w-100">
                        <i class='bx bx-import me-1'></i>Insérer dans le corps
                    </button>
                </div>
                <div id="iaError" class="alert alert-danger mt-3" style="display:none"></div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── PRESETS PAR TYPE ─────────────────────────────────────────
    var presets = {
        circulaire: {
            color: '#4361ee',
            destinataire: "À Mesdames et Messieurs les Coordinateurs Régionaux\nSections et Sous-sections SYNEM du Mali",
            ampliations: "Archives/Chrono ………..03\nSecrétariat Général\nTrésorerie Générale\nCoordinateurs Régionaux (8)\nConseil Consultatif\nClasseur",
            ia: "Rédige une circulaire interne syndicale pour le SYNEM adressée aux coordinateurs régionaux. Commence par 'Camarades Coordinateurs,'"
        },
        convocation: {
            color: '#f77f00',
            destinataire: "Aux membres du Bureau Exécutif National\nBEN-SYNEM\nBamako",
            ampliations: "Archives/Chrono ………..03\nSecrétariat Général\nTrésorerie Générale\nPrésidents de sections\nClasseur",
            ia: "Rédige une convocation officielle pour une réunion du SYNEM. Précise lieu, date et ordre du jour."
        },
        note: {
            color: '#2dc653',
            destinataire: "À l'ensemble des membres\ndu Syndicat National des Enseignants du Mali (SYNEM)",
            ampliations: "Archives/Chrono ………..03\nSecrétariat Général\nTous les secrétaires de sections\nClasseur",
            ia: "Rédige une note de service officielle du SYNEM destinée à l'ensemble des membres."
        },
        communique: {
            color: '#e63946',
            destinataire: "À tous les enseignants membres et sympathisants\ndu Syndicat National des Enseignants du Mali\nOpinion Nationale",
            ampliations: "Archives/Chrono ………..03\nSecrétariat de Presse\nMédias partenaires\nSecrétariat Général\nClasseur",
            ia: "Rédige un communiqué de presse syndical pour le SYNEM avec un ton engagé et professionnel."
        },
        courrier: {
            color: '#7209b7',
            destinataire: "À Monsieur le Ministre de l'Éducation Nationale\nMinistère de l'Éducation Nationale\nBamako, Mali",
            ampliations: "Archives/Chrono ………..03\nSecrétariat Général\nMinistère de l'Éducation Nationale\nClasseur",
            ia: "Rédige un courrier officiel adressé au Ministre de l'Éducation Nationale du Mali de la part du SYNEM."
        },
        autre: {
            color: '#888',
            destinataire: "",
            ampliations: "Archives/Chrono ………..03\nSecrétariat Général\nClasseur",
            ia: "Rédige une lettre administrative officielle pour le SYNEM."
        }
    };

    var typeActuel = null;

    // ── SÉLECTEUR DE TYPE ────────────────────────────────────────
    var typeBtns = document.querySelectorAll('.type-btn');
    typeBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var type = this.dataset.type;
            var preset = presets[type];
            if (!preset) return;

            typeActuel = type;

            // Visuels
            typeBtns.forEach(function (b) {
                b.style.borderColor = '#dde2f0';
                b.style.background  = '#f8f9fa';
            });
            this.style.borderColor = preset.color;
            this.style.background  = preset.color + '15';

            // Bandeau confirmation
            var bandeau = document.getElementById('bandeau-type');
            bandeau.style.display  = 'block';
            bandeau.style.background = preset.color + '18';
            bandeau.style.color      = preset.color;
            bandeau.style.border     = '1.5px solid ' + preset.color;

            // Pré-remplir destinataire (seulement si vide)
            var dest = document.getElementById('destinataire');
            if (!dest.value.trim() && preset.destinataire) {
                dest.value = preset.destinataire;
            }

            // Ampliations (toujours selon le type)
            document.getElementById('ampliations').value = preset.ampliations;
        });
    });

    // ── DESTINATAIRE RAPIDE ──────────────────────────────────────
    window.setDestinataire = function (val) {
        document.getElementById('destinataire').value = val;
    };

    // ── SIGNATAIRE LISTE ─────────────────────────────────────────
    var selSig = document.getElementById('selectSignataire');
    if (selSig) {
        selSig.addEventListener('change', function () {
            var opt = this.options[this.selectedIndex];
            if (!opt.value || opt.value === '__autre__') {
                document.getElementById('signataire').value = '';
                document.getElementById('fonction_signataire').value = '';
                document.getElementById('signataire').focus();
                return;
            }
            document.getElementById('signataire').value = opt.value;
            document.getElementById('fonction_signataire').value = opt.dataset.fonction || '';
        });
    }

    // ── RESET AMPLIATIONS ────────────────────────────────────────
    document.getElementById('btnResetAmp').addEventListener('click', function () {
        var preset = typeActuel ? presets[typeActuel] : null;
        document.getElementById('ampliations').value = preset
            ? preset.ampliations
            : "Archives/Chrono ………..03\nSecrétariat Général\nTrésorerie Générale\nConseil Consultatif\nClasseur";
    });

    // ── FORMULES RAPIDES ─────────────────────────────────────────
    document.getElementById('btnFormules').addEventListener('click', function () {
        var p = document.getElementById('panelFormules');
        p.style.display = p.style.display === 'none' ? 'block' : 'none';
    });

    window.insererAuCurseur = function (texte) {
        var ta = document.getElementById('corps');
        var start = ta.selectionStart;
        var end   = ta.selectionEnd;
        ta.value = ta.value.substring(0, start) + texte + ' ' + ta.value.substring(end);
        ta.selectionStart = ta.selectionEnd = start + texte.length + 1;
        ta.focus();
    };

    // ── GÉNÉRER LE CORPS AVEC IA ─────────────────────────────────
    document.getElementById('btnGenererCorps').addEventListener('click', function () {
        var objet = document.getElementById('objet').value.trim();
        if (!objet) {
            alert('Veuillez d\'abord saisir l\'objet de la lettre.');
            document.getElementById('objet').focus();
            return;
        }

        var dest    = document.getElementById('destinataire').value.trim();
        var sig     = document.getElementById('signataire').value.trim();
        var fonc    = document.getElementById('fonction_signataire').value.trim();
        var iaBase  = typeActuel ? presets[typeActuel].ia : 'Rédige une lettre administrative officielle pour le SYNEM.';

        var prompt = iaBase + '\n\n'
            + 'Objet : ' + objet + '\n'
            + (dest ? 'Destinataire : ' + dest + '\n' : '')
            + (sig  ? 'Signataire : ' + sig + (fonc ? ', ' + fonc : '') + '\n' : '')
            + '\nRédige uniquement le corps complet (pas l\'en-tête, pas le numéro, pas la signature). '
            + 'Commence par la formule d\'adresse et termine par une formule de courtoisie syndicale.';

        var loading = document.getElementById('corpsLoading');
        loading.style.display = 'flex';
        document.getElementById('btnGenererCorps').disabled = true;

        fetch('{{ route('administration.lettres.ia') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ prompt: prompt })
        })
        .then(function (r) { return r.json(); })
        .then(function (json) {
            if (json.error) {
                alert('Erreur IA : ' + json.error);
            } else {
                document.getElementById('corps').value = json.result;
                document.getElementById('corps').scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        })
        .catch(function () { alert('Erreur de connexion à l\'IA.'); })
        .finally(function () {
            loading.style.display = 'none';
            document.getElementById('btnGenererCorps').disabled = false;
        });
    });

    // ── ASSISTANCE IA LIBRE (MODAL) ──────────────────────────────
    document.getElementById('btnIA').addEventListener('click', function () {
        var prompt = document.getElementById('iaPrompt').value.trim();
        if (!prompt) { alert('Veuillez saisir votre demande.'); return; }

        this.disabled = true;
        document.getElementById('btnIAText').textContent = 'Génération...';
        document.getElementById('iaResult').style.display = 'none';
        document.getElementById('iaError').style.display  = 'none';

        fetch('{{ route('administration.lettres.ia') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ prompt: prompt })
        })
        .then(function (r) { return r.json(); })
        .then(function (json) {
            if (json.error) {
                document.getElementById('iaError').textContent = json.error;
                document.getElementById('iaError').style.display = 'block';
            } else {
                document.getElementById('iaResultText').value = json.result;
                document.getElementById('iaResult').style.display = 'block';
            }
        })
        .catch(function () {
            document.getElementById('iaError').textContent = 'Erreur de connexion.';
            document.getElementById('iaError').style.display = 'block';
        })
        .finally(function () {
            document.getElementById('btnIA').disabled = false;
            document.getElementById('btnIAText').textContent = 'Générer';
        });
    });

    document.getElementById('btnInsererIA').addEventListener('click', function () {
        document.getElementById('corps').value = document.getElementById('iaResultText').value;
        bootstrap.Modal.getInstance(document.getElementById('modalIA')).hide();
    });

    // ── CANVAS SIGNATURE ─────────────────────────────────────────
    var canvas  = document.getElementById('sigCanvas');
    var ctx     = canvas.getContext('2d');
    var drawing = false;
    var lastX = 0, lastY = 0;
    var sigVide = true;

    function getPos(e) {
        var rect = canvas.getBoundingClientRect();
        var scaleX = canvas.width  / rect.width;
        var scaleY = canvas.height / rect.height;
        if (e.touches && e.touches.length) {
            return {
                x: (e.touches[0].clientX - rect.left) * scaleX,
                y: (e.touches[0].clientY - rect.top)  * scaleY
            };
        }
        return {
            x: (e.clientX - rect.left) * scaleX,
            y: (e.clientY - rect.top)  * scaleY
        };
    }

    function startDraw(e) {
        e.preventDefault();
        drawing = true;
        var pos = getPos(e);
        lastX = pos.x; lastY = pos.y;
        document.getElementById('sigPlaceholder').style.display = 'none';
    }
    function draw(e) {
        e.preventDefault();
        if (!drawing) return;
        var pos = getPos(e);
        ctx.beginPath();
        ctx.moveTo(lastX, lastY);
        ctx.lineTo(pos.x, pos.y);
        ctx.strokeStyle = document.getElementById('sigColor').value;
        ctx.lineWidth = 2.2;
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';
        ctx.stroke();
        lastX = pos.x; lastY = pos.y;
        sigVide = false;
    }
    function stopDraw(e) { drawing = false; }

    canvas.addEventListener('mousedown',  startDraw);
    canvas.addEventListener('mousemove',  draw);
    canvas.addEventListener('mouseup',    stopDraw);
    canvas.addEventListener('mouseleave', stopDraw);
    canvas.addEventListener('touchstart', startDraw, { passive: false });
    canvas.addEventListener('touchmove',  draw,      { passive: false });
    canvas.addEventListener('touchend',   stopDraw);

    document.getElementById('btnEffacerSig').addEventListener('click', function () {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        sigVide = true;
        document.getElementById('sigPlaceholder').style.display = 'flex';
    });

    // ── ONGLETS SIGNATURE ────────────────────────────────────────
    window.switchSigTab = function (tab) {
        if (tab === 'dessiner') {
            document.getElementById('panelDessiner').style.display = 'block';
            document.getElementById('panelImporter').style.display = 'none';
            document.getElementById('tabDessiner').classList.add('active');
            document.getElementById('tabImporter').classList.remove('active');
        } else {
            document.getElementById('panelDessiner').style.display = 'none';
            document.getElementById('panelImporter').style.display = 'block';
            document.getElementById('tabDessiner').classList.remove('active');
            document.getElementById('tabImporter').classList.add('active');
        }
    };

    // ── PRÉVISUALISATION SIGNATURE IMPORTÉE ──────────────────────
    document.getElementById('signature_fichier').addEventListener('change', function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('previewSignatureImg').src = e.target.result;
                document.getElementById('previewSignature').style.display = 'block';
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    // ── PRÉVISUALISATION SCEAU ───────────────────────────────────
    document.getElementById('cachet').addEventListener('change', function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('previewSceauImg').src = e.target.result;
                document.getElementById('previewSceau').style.display = 'block';
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    // ── SOUMISSION FORMULAIRE : capturer la signature canvas ─────
    document.getElementById('formLettre').addEventListener('submit', function () {
        var tabActive = document.getElementById('tabDessiner').classList.contains('active');
        if (tabActive && !sigVide) {
            document.getElementById('signature_base64').value = canvas.toDataURL('image/png');
        }
    });

}); // fin DOMContentLoaded
</script>
@endpush
