@extends('layouts.administration')

@section('content')
<div class="container-fluid py-4">
    @php
        // Backward compatibility: if controller passes a `page` (MissionPage model)
        // but the view still expects `$content` arrays, build a lightweight
        // `$content` representation from the Eloquent relations.
        if(!isset($content) && isset($page)){
            $content = new \stdClass();
            $content->mission_main = $page->mission_main;
            $content->mission_image = $page->mission_image;
            $content->mission_cta = is_array($page->mission_cta) ? $page->mission_cta : ($page->mission_cta ?? []);
            $content->mission_header_images = $page->headerImages->map(function($h){ return ['id'=>$h->id, 'file'=>$h->file, 'caption'=>$h->caption]; })->toArray();
            $content->mission_documents = $page->documents->map(function($d){ return ['id'=>$d->id, 'file'=>$d->file, 'title'=>$d->title]; })->toArray();
            $content->missions = $page->items->map(function($it){ return ['id'=>$it->id, 'icon'=>$it->icon, 'title'=>$it->title, 'text'=>$it->text]; })->toArray();
            $content->values = $page->values->map(function($v){ return ['id'=>$v->id, 'icon'=>$v->icon, 'title'=>$v->title, 'text'=>$v->text]; })->toArray();
        }
    @endphp

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('administration.tableau-de-bord') }}">Tableau de bord</a></li>
        <li class="breadcrumb-item active" aria-current="page">Notre Mission</li>
    </ol>
</nav>

<a href="{{ route('administration.tableau-de-bord') }}" class="btn btn-secondary mb-3">
    <i class="fas fa-arrow-left"></i> Retour au tableau de bord
</a>

    <h2 class="mb-4">Notre Mission</h2>
    {{-- Header Carousel (page header) --}}
    <div class="card mb-4">
        <div class="card-header">Carousel d'en-tête
            <button type="button" class="btn btn-sm btn-primary ms-2 btn-open-modal" data-bs-toggle="modal" data-bs-target="#modalMissionHeader">Ajouter</button>
            <button type="button" class="btn btn-sm btn-outline-secondary ms-2 btn-open-section-modal" data-section="mission_header">Modifier</button>
        </div>
        <div class="card-body">
            @php
                $headerImages = [];
                if(!empty($content->mission_header_images)){
                    $headerImages = is_array($content->mission_header_images) ? $content->mission_header_images : (json_decode($content->mission_header_images, true) ?: []);
                }
            @endphp
            <div class="table-responsive">
                <table class="table table-bordered" id="mission-header-table">
                    <thead>
                        <tr><th>Fichier</th><th>Caption</th><th>Aperçu</th><th>Actions</th></tr>
                    </thead>
                    <tbody>
                        @if(count($headerImages))
                            @foreach($headerImages as $h)
                                <tr>
                                    <td>{{ $h['file'] ?? '—' }}</td>
                                    <td>{{ $h['caption'] ?? '—' }}</td>
                                    <td><img src="{{ asset('storage/mission_header/' . ($h['file'] ?? '')) }}" style="max-height:60px;" /></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-secondary btn-edit-header" data-file="{{ $h['file'] ?? '' }}" data-caption="{{ e($h['caption'] ?? '') }}"> <i class="fas fa-edit"></i></button>
                                        <button type="button" class="btn btn-sm btn-danger btn-delete-header" data-file="{{ $h['file'] ?? '' }}"> <i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan="4" class="text-center text-muted">Aucune image d'en-tête</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <p class="small text-muted">Gérez les images affichées dans le bandeau supérieur de la page 'Notre Mission'.</p>
        </div>
    </div>

    {{-- Mission principale (modal-managed) --}}
    <div class="card mb-4">
        <div class="card-header">Mission principale
            <button type="button" class="btn btn-sm btn-primary ms-2 btn-open-modal" data-bs-toggle="modal" data-bs-target="#modalMissionMain">Modifier</button>
        </div>
        <div class="card-body">
            <div class="p-3 bg-light rounded"> 
                @php $missionMain = $content->mission_main ?? 'Promouvoir le dialogue social, valoriser le métier d’enseignant, défendre les droits et améliorer les conditions de travail des enseignants du Mali.'; @endphp
                <div id="mission-main-display">{!! nl2br(e($missionMain)) !!}</div>
            </div>
        </div>
    </div>

    {{-- Image de la mission (modal-managed) --}}
    <div class="card mb-4">
        <div class="card-header">Image de la mission
            <button type="button" class="btn btn-sm btn-primary ms-2 btn-open-modal" data-bs-toggle="modal" data-bs-target="#modalMissionImage">Modifier</button>
        </div>
        <div class="card-body">
            @php $missionImage = $content->mission_image ?? 'template-siteweb/asset/img/mission-demo.jpg'; @endphp
            <div class="mb-2">
                <img src="{{ asset('storage/' . ($content->mission_image ?? '')) ?: asset('template-siteweb/asset/img/mission-demo.jpg') }}" alt="Image Mission" class="img-fluid mb-2" style="max-width:300px;" id="mission-image-preview">
            </div>
            <p class="small text-muted">Gérez l'image via le modal "Modifier".</p>
        </div>
    </div>

    {{-- Documents de mission (modal-managed) --}}
    <div class="card mb-4">
        <div class="card-header">Documents de mission
            <button type="button" class="btn btn-sm btn-primary ms-2 btn-open-modal" data-bs-toggle="modal" data-bs-target="#modalMissionDocuments">Gérer</button>
        </div>
        <div class="card-body">
            <ul class="list-group mb-2" id="mission-documents-list">
                @php
                    $docs = [];
                    if(!empty($content->mission_documents)){
                        $docs = is_array($content->mission_documents) ? $content->mission_documents : (json_decode($content->mission_documents, true) ?: []);
                    }
                @endphp
                @if(count($docs))
                    @foreach($docs as $d)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fa fa-file text-secondary"></i> {{ $d['title'] ?? ($d['file'] ?? 'Document') }}</span>
                            <div>
                                <a href="{{ asset('storage/mission_documents/' . ($d['file'] ?? '')) }}" target="_blank" class="btn btn-sm btn-outline-primary me-1">Télécharger</a>
                                <button type="button" class="btn btn-danger btn-sm btn-delete-doc" data-file="{{ $d['file'] ?? '' }}">Supprimer</button>
                            </div>
                        </li>
                    @endforeach
                @else
                    <li class="list-group-item text-muted">Aucun document enregistré</li>
                @endif
            </ul>
            <p class="small text-muted">Ajoutez ou supprimez les documents via le modal "Gérer".</p>
        </div>
    </div>
</div>

    {{-- Nos Missions Principales --}}
    <div class="card mb-4">
        <div class="card-header">Nos Missions Principales
            <button type="button" class="btn btn-sm btn-primary ms-2 btn-open-modal" data-bs-toggle="modal" data-bs-target="#modalMissionItem">Ajouter</button>
        </div>
        <div class="card-body">
            @php
                $missions = [];
                if(!empty($content->missions)){
                    $missions = is_array($content->missions) ? $content->missions : (json_decode($content->missions, true) ?: []);
                }
            @endphp
            <div class="table-responsive">
                <table class="table table-bordered" id="missions-table">
                    <thead><tr><th>Icône</th><th>Titre</th><th>Texte</th><th>Action</th></tr></thead>
                    <tbody>
                        @if(count($missions))
                            @foreach($missions as $i => $m)
                                <tr>
                                    <td><i class="{{ $m['icon'] ?? 'fa fa-circle' }}"></i></td>
                                    <td>{{ $m['title'] ?? '—' }}</td>
                                    <td>{{ $m['text'] ?? '—' }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-secondary btn-edit-mission" data-index="{{ $i }}" data-icon="{{ e($m['icon'] ?? '') }}" data-title="{{ e($m['title'] ?? '') }}" data-text="{{ e($m['text'] ?? '') }}"><i class="fas fa-edit"></i></button>
                                        <button type="button" class="btn btn-sm btn-danger btn-delete-mission" data-index="{{ $i }}"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan="4" class="text-center text-muted">Aucune mission enregistrée</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Nos Valeurs --}}
    <div class="card mb-4">
        <div class="card-header">Nos Valeurs
            <button type="button" class="btn btn-sm btn-primary ms-2 btn-open-modal" data-bs-toggle="modal" data-bs-target="#modalValueItem">Ajouter</button>
        </div>
        <div class="card-body">
            @php
                $values = [];
                if(!empty($content->values)){
                    $values = is_array($content->values) ? $content->values : (json_decode($content->values, true) ?: []);
                }
            @endphp
            <div class="table-responsive">
                <table class="table table-bordered" id="values-table">
                    <thead><tr><th>Icône</th><th>Titre</th><th>Texte</th><th>Action</th></tr></thead>
                    <tbody>
                        @if(count($values))
                            @foreach($values as $i => $v)
                                <tr>
                                    <td><i class="{{ $v['icon'] ?? 'fa fa-star' }}"></i></td>
                                    <td>{{ $v['title'] ?? '—' }}</td>
                                    <td>{{ $v['text'] ?? '—' }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-secondary btn-edit-value" data-index="{{ $i }}" data-icon="{{ e($v['icon'] ?? '') }}" data-title="{{ e($v['title'] ?? '') }}" data-text="{{ e($v['text'] ?? '') }}"><i class="fas fa-edit"></i></button>
                                        <button type="button" class="btn btn-sm btn-danger btn-delete-value" data-index="{{ $i }}"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan="4" class="text-center text-muted">Aucune valeur enregistrée</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Rejoignez Notre Mission (CTA) --}}
    <div class="card mb-4">
        <div class="card-header">Rejoignez Notre Mission
            <button type="button" class="btn btn-sm btn-primary ms-2 btn-open-modal" data-bs-toggle="modal" data-bs-target="#modalMissionCTA">Modifier</button>
        </div>
        <div class="card-body">
            @php
                $cta = $content->mission_cta ?? null;
            @endphp
            <div class="p-3 bg-light rounded">
                <h5 id="cta-title">{{ $cta['title'] ?? 'Rejoignez Notre Mission' }}</h5>
                <p id="cta-subtitle" class="mb-2">{{ $cta['subtitle'] ?? 'Ensemble, construisons un avenir meilleur pour l\'éducation au Mali.' }}</p>
                <a id="cta-button" class="btn btn-dark" href="{{ $cta['link'] ?? route('contact') }}">{{ $cta['button_text'] ?? 'Nous Rejoindre' }}</a>
            </div>
        </div>
    </div>

<!-- Modals for Mission management -->
<!-- Modal: Mission Main -->
<div class="modal fade" id="modalMissionMain" tabindex="-1" aria-labelledby="modalMissionMainLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="modalMissionMainForm" action="{{ route('administration.pages.mission.update.main') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalMissionMainLabel">Modifier la Mission Principale</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Texte principal</label>
                        <textarea name="mission_main" id="modal_mission_main_text" class="form-control" rows="6">{{ old('mission_main', $content->mission_main ?? '') }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" id="modalMissionMainSave" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Mission Image -->
<div class="modal fade" id="modalMissionImage" tabindex="-1" aria-labelledby="modalMissionImageLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="modalMissionImageForm" action="{{ route('administration.pages.mission.update.image') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalMissionImageLabel">Modifier l'image de la mission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 text-center">
                        <img id="modal_mission_image_preview" src="{{ asset('storage/' . ($content->mission_image ?? '')) ?: asset('template-siteweb/asset/img/mission-demo.jpg') }}" alt="Aperçu" class="img-fluid mb-2" style="max-width:320px;" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Choisir une image</label>
                        <input type="file" name="image" id="modal_mission_image_input" accept="image/*" class="form-control">
                        <small class="text-muted">Formats : JPG, PNG. Taille maximale des fichiers: 10 MB</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" id="modalMissionImageSave" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Mission Documents -->
<div class="modal fade" id="modalMissionDocuments" tabindex="-1" aria-labelledby="modalMissionDocumentsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="modalMissionDocumentsForm" action="{{ route('administration.pages.mission.update.documents') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalMissionDocumentsLabel">Gérer les documents de la mission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Documents existants</label>
                        <ul class="list-group mb-2" id="modal_mission_documents_list">
                            @if(count($docs))
                                @foreach($docs as $d)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>{{ $d['title'] ?? ($d['file'] ?? 'Document') }}</span>
                                        <div>
                                            <a href="{{ asset('storage/mission_documents/' . ($d['file'] ?? '')) }}" target="_blank" class="btn btn-sm btn-outline-primary me-1">Télécharger</a>
                                            <button type="button" class="btn btn-danger btn-sm modal-delete-doc" data-file="{{ $d['file'] ?? '' }}">Supprimer</button>
                                        </div>
                                    </li>
                                @endforeach
                            @else
                                <li class="list-group-item text-muted">Aucun document enregistré</li>
                            @endif
                        </ul>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ajouter des documents</label>
                        <input type="file" name="documents[]" multiple accept=".pdf,.doc,.docx,.xls,.xlsx" class="form-control">
                        <small class="text-muted">Formats acceptés : PDF, Word, Excel.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" id="modalMissionDocumentsSave" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
        <!-- Modal: Mission Header (add/edit) -->
        <div class="modal fade" id="modalMissionHeader" tabindex="-1" aria-labelledby="modalMissionHeaderLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="modalMissionHeaderForm" action="{{ route('administration.pages.mission.update.header') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="existing_file" id="modal_header_existing_file" value="">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalMissionHeaderLabel">Ajouter / Modifier une image d'en-tête</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Fichier image</label>
                                <input type="file" name="header_image" accept="image/*" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Légende / Caption</label>
                                <input type="text" name="caption" id="modal_header_caption" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="button" id="modalMissionHeaderSave" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal: Mission Item (add/edit) -->
        <div class="modal fade" id="modalMissionItem" tabindex="-1" aria-labelledby="modalMissionItemLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form id="modalMissionItemForm" action="{{ route('administration.pages.mission.update.items') }}" method="POST">
                        @csrf
                        <input type="hidden" name="item_index" id="modal_mission_item_index" value="">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalMissionItemLabel">Ajouter / Modifier une mission</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Classe d'icône (fontawesome)</label>
                                <input type="text" name="icon" id="modal_mission_icon" class="form-control" placeholder="fa fa-balance-scale">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Titre</label>
                                <input type="text" name="title" id="modal_mission_title" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Texte</label>
                                <textarea name="text" id="modal_mission_text" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="button" id="modalMissionItemSave" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal: Value Item (add/edit) -->
        <div class="modal fade" id="modalValueItem" tabindex="-1" aria-labelledby="modalValueItemLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form id="modalValueItemForm" action="{{ route('administration.pages.mission.update.values') }}" method="POST">
                        @csrf
                        <input type="hidden" name="value_index" id="modal_value_index" value="">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalValueItemLabel">Ajouter / Modifier une valeur</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Classe d'icône (fontawesome)</label>
                                <input type="text" name="icon" id="modal_value_icon" class="form-control" placeholder="fa fa-star">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Titre</label>
                                <input type="text" name="title" id="modal_value_title" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Texte</label>
                                <textarea name="text" id="modal_value_text" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="button" id="modalValueItemSave" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal: CTA -->
        <div class="modal fade" id="modalMissionCTA" tabindex="-1" aria-labelledby="modalMissionCTALabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form id="modalMissionCTAForm" action="{{ route('administration.pages.mission.update.cta') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalMissionCTALabel">Modifier le CTA 'Rejoignez Notre Mission'</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Titre</label>
                                <input type="text" name="title" id="modal_cta_title" class="form-control" value="{{ $cta['title'] ?? '' }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Sous-titre</label>
                                <textarea name="subtitle" id="modal_cta_subtitle" class="form-control" rows="3">{{ $cta['subtitle'] ?? '' }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Texte du bouton</label>
                                <input type="text" name="button_text" id="modal_cta_button_text" class="form-control" value="{{ $cta['button_text'] ?? '' }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Lien du bouton</label>
                                <input type="text" name="button_link" id="modal_cta_button_link" class="form-control" value="{{ $cta['link'] ?? '' }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="button" id="modalMissionCTASave" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

@php
$section = session('success_section');
@endphp

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // helper: get CSRF token
    function getCsrfToken(){
        const meta = document.querySelector('meta[name="csrf-token"]');
        if(meta) return meta.getAttribute('content');
        const input = document.querySelector('input[name="_token"]');
        return input ? input.value : '';
    }

    // Generic modal form submit via fetch (supports files)
    async function submitModalForm(formEl){
        if(!formEl) return;
        const url = formEl.getAttribute('action');
        const fd = new FormData();
        Array.from(formEl.elements).forEach(function(el){
            if(!el.name || el.disabled) return;
            const type = (el.type||'').toLowerCase();
            if(type === 'file'){
                const files = el.files || [];
                Array.from(files).forEach(function(f){
                    // skip empty file inputs (some browsers/clone actions create empty UploadedFile)
                    if(!f || !f.name || f.size === 0) return;
                    fd.append(el.name, f);
                });
            
            } else if(type === 'select-multiple'){
                Array.from(el.options).forEach(function(opt){ if(opt.selected) fd.append(el.name, opt.value); });
            } else if((type === 'checkbox' || type === 'radio')){
                if(el.checked) fd.append(el.name, el.value);
            } else {
                fd.append(el.name, el.value);
            }
        });
        if(!fd.get('_token')) fd.append('_token', getCsrfToken());

        // Prevent empty submissions: if only _token present or all values empty, warn and abort
        try{
            let nonEmpty = 0;
            for(const pair of fd.entries()){
                if(pair[0] === '_token') continue;
                const val = pair[1];
                if(val instanceof File){ if(val.name && val.size > 0) nonEmpty++; }
                else if(String(val).trim() !== '') nonEmpty++;
                if(nonEmpty) break;
            }
            if(nonEmpty === 0){
                return Swal.fire({ icon:'warning', title:'Aucune donnée', text:'Aucune donnée fournie pour l\'enregistrement.' });
            }
        }catch(e){ console.warn('Empty-check failed', e); }

        try{
            const res = await fetch(url, {
                method: 'POST',
                credentials: 'same-origin',
                headers: { 'X-Requested-With':'XMLHttpRequest', 'X-CSRF-TOKEN': getCsrfToken() },
                body: fd
            });
            const ct = res.headers.get('content-type') || '';
            if(res.ok && ct.indexOf('application/json') !== -1){
                const data = await res.json();
                if(data && data.success){
                    Swal.fire({ icon:'success', title:'Enregistré', text: data.message || 'Modifications enregistrées.' }).then(()=> location.reload());
                } else {
                    Swal.fire({ icon:'error', title:'Erreur', text: data.message || 'Impossible d\'enregistrer.' });
                }
            } else if(res.ok){
                location.reload();
            } else {
                const txt = await res.text();
                Swal.fire({ icon:'error', title:'Erreur', html: 'Échec (status '+res.status+')<br/>'+txt });
            }
        } catch(err){
            console.error('submitModalForm error', err);
            Swal.fire({ icon:'error', title:'Erreur réseau', text: err.message || String(err) });
        }
    }

    // Wire modal save buttons
    const mainSave = document.getElementById('modalMissionMainSave');
    if(mainSave){
        mainSave.addEventListener('click', function(){
            const form = document.getElementById('modalMissionMainForm');
            submitModalForm(form);
        });
    }

    const imageSave = document.getElementById('modalMissionImageSave');
    if(imageSave){
        // preview image when selecting
        const input = document.getElementById('modal_mission_image_input');
        const preview = document.getElementById('modal_mission_image_preview');
        if(input && preview){
            input.addEventListener('change', function(e){
                const f = e.target.files && e.target.files[0];
                if(f){
                    const url = URL.createObjectURL(f);
                    preview.src = url;
                }
            });
        }
        imageSave.addEventListener('click', function(){
            const form = document.getElementById('modalMissionImageForm');
            const input = document.getElementById('modal_mission_image_input');
            const MAX = 10 * 1024 * 1024; // 10 MB
            if(input && input.files && input.files.length){
                const f = input.files[0];
                if(f.size > MAX){
                    return Swal.fire({ icon: 'error', title: 'Fichier trop volumineux', text: 'La taille maximale autorisée est de 10 MB.' });
                }
            }
            submitModalForm(form);
        });
    }

    const docsSave = document.getElementById('modalMissionDocumentsSave');
    if(docsSave){
        docsSave.addEventListener('click', function(){
            const form = document.getElementById('modalMissionDocumentsForm');
            submitModalForm(form);
        });
    }

    // Document delete inside modal (send delete_file to same documents route)
    document.addEventListener('click', function(e){
        const btn = e.target.closest('.modal-delete-doc');
        if(!btn) return;
        const file = btn.getAttribute('data-file');
        if(!file) return;
        Swal.fire({ title:'Confirmer', text:'Supprimer ce document ?', icon:'warning', showCancelButton:true, confirmButtonText:'Oui' }).then(function(res){
            if(!res.isConfirmed) return;
            const fd = new FormData(); fd.append('_token', getCsrfToken()); fd.append('delete_file', file);
            fetch('{{ route("administration.pages.mission.update.documents") }}', { method:'POST', credentials:'same-origin', headers:{ 'X-Requested-With':'XMLHttpRequest','X-CSRF-TOKEN':getCsrfToken() }, body: fd })
                .then(r=>r.json()).then(data=>{
                    if(data && data.success){ Swal.fire({ icon:'success', title:'Supprimé' }).then(()=> location.reload()); }
                    else Swal.fire({ icon:'error', title:'Erreur', text: data.message || 'Impossible de supprimer.' });
                }).catch(err=>{ console.error(err); Swal.fire({ icon:'error', title:'Erreur réseau' }); });
        });
    });

    // Simple delete button for documents list on page (outside modal)
    document.querySelectorAll('.btn-delete-doc').forEach(function(btn){
        btn.addEventListener('click', function(){
            const file = btn.getAttribute('data-file');
            if(!file) return;
            Swal.fire({ title:'Confirmer', text:'Supprimer ce document ?', icon:'warning', showCancelButton:true, confirmButtonText:'Oui' }).then(function(res){
                if(!res.isConfirmed) return;
                const fd = new FormData(); fd.append('_token', getCsrfToken()); fd.append('delete_file', file);
                fetch('{{ route("administration.pages.mission.update.documents") }}', { method:'POST', credentials:'same-origin', headers:{ 'X-Requested-With':'XMLHttpRequest','X-CSRF-TOKEN':getCsrfToken() }, body: fd })
                    .then(r=>r.json()).then(data=>{ if(data && data.success){ Swal.fire({ icon:'success', title:'Supprimé' }).then(()=> location.reload()); } else Swal.fire({ icon:'error', title:'Erreur' }); }).catch(e=>{ console.error(e); Swal.fire({ icon:'error', title:'Erreur réseau' }); });
            });
        });
    });

    // Optionally clear modal inputs when opened (keep existing values otherwise)
    document.querySelectorAll('.btn-open-modal').forEach(function(btn){
        btn.addEventListener('click', function(e){
            // no-op for now; forms are prefilled from server
        });
    });

    // Handle 'Modifier' buttons that target a section (open the appropriate modal)
    document.querySelectorAll('.btn-open-section-modal').forEach(function(btn){
        btn.addEventListener('click', function(){
            const section = btn.getAttribute('data-section');
            if(!section) return;
            const mapping = {
                'mission_header': 'modalMissionHeader',
                'mission_main': 'modalMissionMain',
                'mission_image': 'modalMissionImage',
                'mission_documents': 'modalMissionDocuments',
                'missions': 'modalMissionItem',
                'values': 'modalValueItem',
                'mission_cta': 'modalMissionCTA'
            };
            const mid = mapping[section];
            if(!mid) return;
            const modalEl = document.getElementById(mid);
            if(!modalEl) return;
            // optionally prefill some modal fields from the card display
            try{
                const card = btn.closest('.card');
                if(section === 'mission_header'){
                    // try to prefill with the first header image row
                    const firstRow = document.querySelector('#mission-header-table tbody tr');
                    if(firstRow){
                        const fileCell = firstRow.querySelector('td:nth-child(1)');
                        const captionCell = firstRow.querySelector('td:nth-child(2)');
                        const file = fileCell ? fileCell.textContent.trim() : '';
                        const caption = captionCell ? captionCell.textContent.trim() : '';
                        const existingInput = modalEl.querySelector('#modal_header_existing_file');
                        const captionInput = modalEl.querySelector('#modal_header_caption');
                        if(existingInput) existingInput.value = file || '';
                        if(captionInput) captionInput.value = caption || '';
                    }
                } else if(card){
                    // fill simple text inputs if names match data-field attributes
                    card.querySelectorAll('[data-field]').forEach(function(dis){
                        const fname = dis.getAttribute('data-field');
                        if(!fname) return;
                        const input = modalEl.querySelector('[name="' + fname + '"]');
                        if(input) input.value = dis.textContent.trim();
                    });
                }
            }catch(e){ /* ignore prefill errors */ }
            new bootstrap.Modal(modalEl).show();
        });
    });

    // Header edit/delete handlers
    document.querySelectorAll('.btn-edit-header').forEach(function(b){
        b.addEventListener('click', function(){
            const file = b.getAttribute('data-file');
            const caption = b.getAttribute('data-caption') || '';
            document.getElementById('modal_header_existing_file').value = file || '';
            document.getElementById('modal_header_caption').value = caption;
            var m = new bootstrap.Modal(document.getElementById('modalMissionHeader'));
            m.show();
        });
    });
    document.querySelectorAll('.btn-delete-header').forEach(function(b){
        b.addEventListener('click', function(){
            const file = b.getAttribute('data-file');
            if(!file) return;
            Swal.fire({ title:'Confirmer', text:'Supprimer cette image ?', icon:'warning', showCancelButton:true, confirmButtonText:'Oui' }).then(function(res){
                if(!res.isConfirmed) return;
                const fd = new FormData(); fd.append('_token', getCsrfToken()); fd.append('delete_file', file);
                fetch('{{ route("administration.pages.mission.update.header") }}', { method:'POST', credentials:'same-origin', headers:{ 'X-Requested-With':'XMLHttpRequest','X-CSRF-TOKEN':getCsrfToken() }, body: fd })
                    .then(r=>r.json()).then(data=>{ if(data && data.success){ Swal.fire({ icon:'success' }).then(()=> location.reload()); } else Swal.fire({ icon:'error', title:'Erreur' }); }).catch(e=>{ console.error(e); Swal.fire({ icon:'error', title:'Erreur réseau' }); });
            });
        });
    });

    // Header save
    const headerSave = document.getElementById('modalMissionHeaderSave');
    if(headerSave){ headerSave.addEventListener('click', function(){
        const input = document.querySelector('#modalMissionHeaderForm input[name="header_image"]');
        const MAX = 10 * 1024 * 1024; // 10 MB
        if(input && input.files && input.files.length){
            const f = input.files[0];
            if(f.size > MAX){
                return Swal.fire({ icon: 'error', title: 'Fichier trop volumineux', text: 'La taille maximale autorisée est de 10 MB.' });
            }
        }
        submitModalForm(document.getElementById('modalMissionHeaderForm'));
    }); }

    // Missions items: open edit modal and delete
    document.querySelectorAll('.btn-edit-mission').forEach(function(b){
        b.addEventListener('click', function(){
            const idx = b.getAttribute('data-index');
            document.getElementById('modal_mission_item_index').value = idx;
            document.getElementById('modal_mission_icon').value = b.getAttribute('data-icon') || '';
            document.getElementById('modal_mission_title').value = b.getAttribute('data-title') || '';
            document.getElementById('modal_mission_text').value = b.getAttribute('data-text') || '';
            new bootstrap.Modal(document.getElementById('modalMissionItem')).show();
        });
    });
    document.querySelectorAll('.btn-delete-mission').forEach(function(b){
        b.addEventListener('click', function(){
            const idx = b.getAttribute('data-index');
            if(idx === null) return;
            Swal.fire({ title:'Confirmer', text:'Supprimer cet élément ?', icon:'warning', showCancelButton:true, confirmButtonText:'Oui' }).then(function(res){
                if(!res.isConfirmed) return;
                const fd = new FormData(); fd.append('_token', getCsrfToken()); fd.append('delete_index', idx);
                fetch('{{ route("administration.pages.mission.update.items") }}', { method:'POST', credentials:'same-origin', headers:{ 'X-Requested-With':'XMLHttpRequest','X-CSRF-TOKEN':getCsrfToken() }, body: fd })
                    .then(r=>r.json()).then(data=>{ if(data && data.success){ Swal.fire({ icon:'success' }).then(()=> location.reload()); } else Swal.fire({ icon:'error' }); }).catch(e=>{ console.error(e); Swal.fire({ icon:'error' }); });
            });
        });
    });
    const missionItemSave = document.getElementById('modalMissionItemSave');
    if(missionItemSave) missionItemSave.addEventListener('click', function(){ submitModalForm(document.getElementById('modalMissionItemForm')); });

    // Values items
    document.querySelectorAll('.btn-edit-value').forEach(function(b){
        b.addEventListener('click', function(){
            const idx = b.getAttribute('data-index');
            document.getElementById('modal_value_index').value = idx;
            document.getElementById('modal_value_icon').value = b.getAttribute('data-icon') || '';
            document.getElementById('modal_value_title').value = b.getAttribute('data-title') || '';
            document.getElementById('modal_value_text').value = b.getAttribute('data-text') || '';
            new bootstrap.Modal(document.getElementById('modalValueItem')).show();
        });
    });
    document.querySelectorAll('.btn-delete-value').forEach(function(b){
        b.addEventListener('click', function(){
            const idx = b.getAttribute('data-index');
            Swal.fire({ title:'Confirmer', text:'Supprimer cet élément ?', icon:'warning', showCancelButton:true, confirmButtonText:'Oui' }).then(function(res){
                if(!res.isConfirmed) return;
                const fd = new FormData(); fd.append('_token', getCsrfToken()); fd.append('delete_index', idx);
                fetch('{{ route("administration.pages.mission.update.values") }}', { method:'POST', credentials:'same-origin', headers:{ 'X-Requested-With':'XMLHttpRequest','X-CSRF-TOKEN':getCsrfToken() }, body: fd })
                    .then(r=>r.json()).then(data=>{ if(data && data.success){ Swal.fire({ icon:'success' }).then(()=> location.reload()); } else Swal.fire({ icon:'error' }); }).catch(e=>{ console.error(e); Swal.fire({ icon:'error' }); });
            });
        });
    });
    const valueSave = document.getElementById('modalValueItemSave');
    if(valueSave) valueSave.addEventListener('click', function(){ submitModalForm(document.getElementById('modalValueItemForm')); });

    // CTA save
    const ctaSave = document.getElementById('modalMissionCTASave');
    if(ctaSave) ctaSave.addEventListener('click', function(){ submitModalForm(document.getElementById('modalMissionCTAForm')); });

});
</script>
@endpush

@endsection
