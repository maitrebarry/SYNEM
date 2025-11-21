@extends('layouts.administration')

@section('content')
<div class="container-fluid py-4">
    <!-- <h2 class="mb-4">Historique - Gestion</h2> -->
        <div id="historique-routes" style="display:none"
            data-store-events="{{ route('administration.pages.historique.events.store') }}"
            data-update-event="{{ url('/administration/pages/historique/events') }}"
            data-reorder-events="{{ route('administration.pages.historique.events.reorder') }}"
            data-store-milestones="{{ route('administration.pages.historique.milestones.store') }}"
            data-update-milestone="{{ url('/administration/pages/historique/milestones') }}"
            data-reorder-milestones="{{ route('administration.pages.historique.milestones.reorder') }}"
            data-store-archives="{{ route('administration.pages.historique.archives.store') }}"
            data-update-archive="{{ url('/administration/pages/historique/archives') }}"
            data-reorder-archives="{{ route('administration.pages.historique.archives.reorder') }}"
            data-update-main="{{ route('administration.pages.historique.update.main') }}"
            data-update-image="{{ route('administration.pages.historique.update.image') }}"
        ></div>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('administration.tableau-de-bord') }}">Tableau de bord</a></li>
        <li class="breadcrumb-item active" aria-current="page">Historique - Gestion</li>
    </ol>
</nav>

<a href="{{ route('administration.tableau-de-bord') }}" class="btn btn-secondary mb-3">
    <i class="fas fa-arrow-left"></i> Retour au tableau de bord
</a>

    <!-- Card: Historique (Texte & Image) -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>Historique (texte & image)</div>
            <div>
                <button class="btn btn-sm btn-primary" id="btnEditHistoriqueMain">Modifier</button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                        <p class="text-muted">{{ Str::limit($main->text ?? 'Texte principal de la section Historique. Utilisez le bouton "Modifier" pour éditer le texte et l\'image.', 300) }}</p>
                </div>
                <div class="col-md-4 text-end">
                    <div id="historique-main-image-preview">
                                    <div id="hist_main_image_preview" class="border rounded p-2 text-center" style="min-height:80px">
                                        @if(!empty($main) && $main->image)
                                            <img src="{{ asset('storage/historique/' . $main->image) }}" style="max-height:120px;object-fit:cover;border-radius:6px" />
                                        @else
                                            <div class="text-muted small">Aucune image</div>
                                        @endif
                                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Edit Historique Main -->
    <div class="modal fade" id="modalHistoriqueMain" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="formHistoriqueMain" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Modifier la section Historique</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Texte</label>
                                <textarea name="text" id="hist_main_text" class="form-control" rows="6" placeholder="Saisir le texte principal...">{{ $main->text ?? '' }}</textarea>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label">Image (optionnel)</label>
                                <input type="file" name="image" id="hist_main_image" accept="image/*" class="form-control">
                                <small class="text-muted">Max 10 MB</small>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Aperçu</label>
                                <div id="hist_main_image_preview" class="border rounded p-2 text-center" style="min-height:80px"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="button" id="saveHistoriqueMain" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>Événements historiques</div>
            <div>
                <button class="btn btn-sm btn-outline-secondary me-2" id="btnSaveOrder">Enregistrer l'ordre</button>
                <button class="btn btn-sm btn-primary" id="btnAddEvent">Ajouter un événement</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="historique-events-table">
                    <thead>
                        <tr>
                            <th style="width:40px"></th>
                            <th style="width:90px">Année</th>
                            <th>Titre</th>
                            <th style="width:140px">Aperçu image / icône</th>
                            <th>Texte</th>
                            <th style="width:120px">Ordre</th>
                            <th style="width:140px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $ev)
                            <tr data-id="{{ $ev->id ?? $ev['id'] ?? '' }}">
                                <td class="align-middle text-center drag-handle" style="cursor:grab"><i class="fa fa-arrows-alt-v"></i></td>
                                <td class="align-middle"><strong>{{ $ev->year ?? $ev['year'] ?? '' }}</strong></td>
                                <td class="align-middle">{{ $ev->title ?? $ev['title'] ?? '' }}</td>
                                <td class="align-middle">
                                    @php $img = $ev->image ?? $ev['image'] ?? null; $icon = $ev->icon ?? $ev['icon'] ?? null; @endphp
                                    @if($img)
                                        <img src="{{ $img }}" alt="" style="height:60px;object-fit:cover;border-radius:6px;" />
                                    @elseif($icon)
                                        <div class="text-center"><i class="{{ $icon }} fa-2x"></i></div>
                                    @else
                                        <div class="text-center text-muted small">Aucun</div>
                                    @endif
                                </td>
                                <td class="align-middle small text-muted">{{ 
                                    Str::limit($ev->text ?? $ev['text'] ?? '', 140) }}</td>
                                <td class="align-middle"><input type="number" class="form-control form-control-sm input-order" value="{{ $ev->ordering ?? $ev['ordering'] ?? 0 }}" style="width:90px" /></td>
                                <td class="align-middle">
                                    <button class="btn btn-sm btn-outline-secondary btn-edit-event">Modifier</button>
                                    <button class="btn btn-sm btn-danger btn-delete-event">Supprimer</button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted">Aucun événement</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Card: Nos Réalisations (Milestones) -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>Nos Réalisations (Moments clés récapitulés)</div>
            <div>
                <button class="btn btn-sm btn-outline-secondary me-2" id="btnSaveOrderMilestones">Enregistrer l'ordre</button>
                <button class="btn btn-sm btn-primary" id="btnAddMilestone">Ajouter une réalisation</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="historique-milestones-table">
                    <thead>
                        <tr>
                            <th style="width:40px"></th>
                            <th style="width:80px">N°</th>
                            <th>Label</th>
                            <th style="width:120px">Icône</th>
                            <th style="width:200px">Description</th>
                            <th style="width:100px">Ordre</th>
                            <th style="width:140px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($milestones as $m)
                            <tr data-id="{{ $m->id }}">
                                <td class="align-middle text-center drag-handle" style="cursor:grab"><i class="fa fa-arrows-alt-v"></i></td>
                                <td class="align-middle">{{ $m->number }}</td>
                                <td class="align-middle">{{ $m->label }}</td>
                                <td class="align-middle text-center">@if($m->icon)<i class="{{ $m->icon }} fa-2x"></i>@else <span class="text-muted small">Aucun</span>@endif</td>
                                <td class="align-middle small text-muted">{{ Str::limit($m->description, 140) }}</td>
                                <td class="align-middle"><input type="number" class="form-control form-control-sm input-order-milestone" value="{{ $m->ordering ?? 0 }}" style="width:90px" /></td>
                                <td class="align-middle">
                                    <button class="btn btn-sm btn-outline-secondary btn-edit-milestone">Modifier</button>
                                    <button class="btn btn-sm btn-danger btn-delete-milestone">Supprimer</button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted">Aucune réalisation</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Card: Archives Historiques -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>Archives Historiques</div>
            <div>
                <button class="btn btn-sm btn-outline-secondary me-2" id="btnSaveOrderArchives">Enregistrer l'ordre</button>
                <button class="btn btn-sm btn-primary" id="btnAddArchive">Ajouter une archive</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="historique-archives-table">
                    <thead>
                        <tr>
                            <th style="width:40px"></th>
                            <th>Titre</th>
                            <th style="width:140px">Image</th>
                            <th>Texte</th>
                            <th style="width:120px">Lien</th>
                            <th style="width:100px">Ordre</th>
                            <th style="width:140px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($archives as $a)
                            <tr data-id="{{ $a->id }}">
                                <td class="align-middle text-center drag-handle" style="cursor:grab"><i class="fa fa-arrows-alt-v"></i></td>
                                <td class="align-middle">{{ $a->title }}</td>
                                <td class="align-middle">@if($a->image)<img src="{{ asset('storage/historique/'.$a->image) }}" style="height:60px;object-fit:cover;border-radius:6px" />@else <span class="text-muted small">Aucun</span>@endif</td>
                                <td class="align-middle small text-muted">{{ Str::limit($a->text, 120) }}</td>
                                <td class="align-middle"><a href="{{ $a->link }}" target="_blank">Lien</a></td>
                                <td class="align-middle"><input type="number" class="form-control form-control-sm input-order-archive" value="{{ $a->ordering ?? 0 }}" style="width:90px" /></td>
                                <td class="align-middle">
                                    <button class="btn btn-sm btn-outline-secondary btn-edit-archive">Modifier</button>
                                    <button class="btn btn-sm btn-danger btn-delete-archive">Supprimer</button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted">Aucune archive</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Modal: Add / Edit Event -->
<div class="modal fade" id="modalEvent" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="formEvent" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="event_id" />
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter / Modifier un événement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Année</label>
                            <input type="text" name="year" id="event_year" class="form-control" placeholder="1990">
                        </div>
                        <div class="col-md-9">
                            <label class="form-label">Titre</label>
                            <input type="text" name="title" id="event_title" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Texte</label>
                            <textarea name="text" id="event_text" class="form-control" rows="4"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Image (optionnel)</label>
                            <input type="file" name="image" id="event_image" accept="image/*" class="form-control">
                            <small class="text-muted">Max 10 MB</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Icône (fontawesome)</label>
                            <input type="text" name="icon" id="event_icon" class="form-control" placeholder="fa fa-history">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Ordre</label>
                            <input type="number" name="ordering" id="event_ordering" class="form-control">
                        </div>
                        <div class="col-12">
                            <div id="event_image_preview" class="mt-2"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" id="saveEvent" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Add / Edit Milestone -->
<div class="modal fade" id="modalMilestone" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="formMilestone">
                @csrf
                <input type="hidden" name="id" id="milestone_id" />
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter / Modifier une réalisation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">N°</label>
                            <input type="text" name="number" id="ms_number" class="form-control">
                        </div>
                        <div class="col-md-9">
                            <label class="form-label">Label</label>
                            <input type="text" name="label" id="ms_label" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" id="ms_description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Icône (fontawesome)</label>
                            <input type="text" name="icon" id="ms_icon" class="form-control" placeholder="fa fa-check">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Ordre</label>
                            <input type="number" name="ordering" id="ms_ordering" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" id="saveMilestone" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Add / Edit Archive -->
<div class="modal fade" id="modalArchive" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="formArchive" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="archive_id" />
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter / Modifier une archive</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Titre</label>
                            <input type="text" name="title" id="ar_title" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Image (optionnel)</label>
                            <input type="file" name="image" id="ar_image" accept="image/*" class="form-control">
                            <small class="text-muted">Max 10 MB</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Lien (optionnel)</label>
                            <input type="url" name="link" id="ar_link" class="form-control" placeholder="https://example.com">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Texte</label>
                            <textarea name="text" id="ar_text" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Ordre</label>
                            <input type="number" name="ordering" id="ar_ordering" class="form-control">
                        </div>
                        <div class="col-12">
                            <div id="archive_image_preview" class="mt-2"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" id="saveArchive" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
    const addBtn = document.getElementById('btnAddEvent');
    const modalEl = document.getElementById('modalEvent');
    const modal = new bootstrap.Modal(modalEl);
    const form = document.getElementById('formEvent');
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content || document.querySelector('input[name="_token"]')?.value;
    const ROUTES = (function(){
        const el = document.getElementById('historique-routes');
        return {
            // events
            storeEvent: el?.dataset?.storeEvents || '/administration/pages/historique/events',
            updateEventBase: el?.dataset?.updateEvent || '/administration/pages/historique/events',
            reorderEvents: el?.dataset?.reorderEvents || '/administration/pages/historique/events/reorder',
            // milestones
            storeMilestone: el?.dataset?.storeMilestones || '/administration/pages/historique/milestones',
            updateMilestoneBase: el?.dataset?.updateMilestone || '/administration/pages/historique/milestones',
            reorderMilestones: el?.dataset?.reorderMilestones || '/administration/pages/historique/milestones/reorder',
            // archives
            storeArchive: el?.dataset?.storeArchives || '/administration/pages/historique/archives',
            updateArchiveBase: el?.dataset?.updateArchive || '/administration/pages/historique/archives',
            reorderArchives: el?.dataset?.reorderArchives || '/administration/pages/historique/archives/reorder',
            // main
            updateMain: el?.dataset?.updateMain || '/administration/pages/historique/update/main',
            updateImage: el?.dataset?.updateImage || '/administration/pages/historique/update/image'
        };
    })();

    // Drag & drop (Sortable) initialization and helper
    const tbody = document.querySelector('#historique-events-table tbody');
    function updateOrderingNumbers(){
        if(!tbody) return;
        const rows = Array.from(tbody.querySelectorAll('tr[data-id]'));
        rows.forEach((r, idx) => {
            const input = r.querySelector('.input-order');
            if(input) input.value = idx;
        });
    }
    let _orderingDebounce = null;
    async function sendOrderingToServer(){
        const rows = Array.from(document.querySelectorAll('#historique-events-table tbody tr[data-id]'));
        const ordering = rows.map(r => ({ id: r.getAttribute('data-id'), ordering: parseInt(r.querySelector('.input-order').value || 0) }));
        try{
            const res = await fetch(ROUTES.reorderEvents, { method:'POST', credentials:'same-origin', headers:{ 'Content-Type':'application/json','X-CSRF-TOKEN': csrf }, body: JSON.stringify({ ordering }) });
            const data = await res.json().catch(()=>null);
            if(res.ok && data && data.success){
                if(window.Swal) Swal.fire({ icon:'success', title:'Ordre mis à jour', timer:900, showConfirmButton:false });
            } else {
                if(window.Swal) Swal.fire({ icon:'error', title:'Erreur', text: (data && data.message) ? data.message : 'Impossible de sauvegarder l\'ordre.' });
                else alert('Erreur: impossible de sauvegarder l\'ordre.');
            }
        }catch(e){
            console.error('ordering save failed', e);
            if(window.Swal) Swal.fire({ icon:'error', title:'Erreur réseau', text: e.message || String(e) });
        }
    }

    function autoSaveOrderDebounced(){
        if(_orderingDebounce) clearTimeout(_orderingDebounce);
        _orderingDebounce = setTimeout(()=> sendOrderingToServer(), 300);
    }

    if(typeof Sortable !== 'undefined' && tbody){
        new Sortable(tbody, {
            animation: 150,
            handle: '.drag-handle',
            onEnd: function(){ updateOrderingNumbers(); autoSaveOrderDebounced(); }
        });
    }

    // Milestones Sortable
    const tbodyMs = document.querySelector('#historique-milestones-table tbody');
    if(typeof Sortable !== 'undefined' && tbodyMs){
        new Sortable(tbodyMs, { animation:150, handle:'.drag-handle', onEnd: function(){ updateOrderingNumbersMilestones(); autoSaveOrderDebouncedMilestones(); } });
    }

    // Archives Sortable
    const tbodyAr = document.querySelector('#historique-archives-table tbody');
    if(typeof Sortable !== 'undefined' && tbodyAr){
        new Sortable(tbodyAr, { animation:150, handle:'.drag-handle', onEnd: function(){ updateOrderingNumbersArchives(); autoSaveOrderDebouncedArchives(); } });
    }

    // Milestones helpers
    function updateOrderingNumbersMilestones(){
        const rows = Array.from(document.querySelectorAll('#historique-milestones-table tbody tr[data-id]'));
        rows.forEach((r, idx) => { const input = r.querySelector('.input-order-milestone'); if(input) input.value = idx; });
    }
    let _orderingDebounceMs = null;
    async function sendOrderingMilestones(){
        const rows = Array.from(document.querySelectorAll('#historique-milestones-table tbody tr[data-id]'));
        const ordering = rows.map(r => ({ id: r.getAttribute('data-id'), ordering: parseInt(r.querySelector('.input-order-milestone').value || 0) }));
        try{
            const res = await fetch(ROUTES.reorderMilestones, { method:'POST', credentials:'same-origin', headers:{ 'Content-Type':'application/json','X-CSRF-TOKEN': csrf }, body: JSON.stringify({ ordering }) });
            const data = await res.json().catch(()=>null);
            if(res.ok && data && data.success){ if(window.Swal) Swal.fire({ icon:'success', title:'Ordre mis à jour', timer:900, showConfirmButton:false }); }
            else { if(window.Swal) Swal.fire({ icon:'error', title:'Erreur', text: data?.message || 'Impossible' }); else alert('Erreur'); }
        }catch(e){ console.error(e); if(window.Swal) Swal.fire({ icon:'error', title:'Erreur réseau', text: e.message || String(e) }); }
    }
    function autoSaveOrderDebouncedMilestones(){ if(_orderingDebounceMs) clearTimeout(_orderingDebounceMs); _orderingDebounceMs = setTimeout(()=> sendOrderingMilestones(), 300); }

    // Archives helpers
    function updateOrderingNumbersArchives(){
        const rows = Array.from(document.querySelectorAll('#historique-archives-table tbody tr[data-id]'));
        rows.forEach((r, idx) => { const input = r.querySelector('.input-order-archive'); if(input) input.value = idx; });
    }
    let _orderingDebounceAr = null;
    async function sendOrderingArchives(){
        const rows = Array.from(document.querySelectorAll('#historique-archives-table tbody tr[data-id]'));
        const ordering = rows.map(r => ({ id: r.getAttribute('data-id'), ordering: parseInt(r.querySelector('.input-order-archive').value || 0) }));
        try{
            const res = await fetch(ROUTES.reorderArchives, { method:'POST', credentials:'same-origin', headers:{ 'Content-Type':'application/json','X-CSRF-TOKEN': csrf }, body: JSON.stringify({ ordering }) });
            const data = await res.json().catch(()=>null);
            if(res.ok && data && data.success){ if(window.Swal) Swal.fire({ icon:'success', title:'Ordre mis à jour', timer:900, showConfirmButton:false }); }
            else { if(window.Swal) Swal.fire({ icon:'error', title:'Erreur', text: data?.message || 'Impossible' }); else alert('Erreur'); }
        }catch(e){ console.error(e); if(window.Swal) Swal.fire({ icon:'error', title:'Erreur réseau', text: e.message || String(e) }); }
    }
    function autoSaveOrderDebouncedArchives(){ if(_orderingDebounceAr) clearTimeout(_orderingDebounceAr); _orderingDebounceAr = setTimeout(()=> sendOrderingArchives(), 300); }

    function clearForm(){
        form.reset();
        document.getElementById('event_id').value = '';
        document.getElementById('event_image_preview').innerHTML = '';
    }

    addBtn.addEventListener('click', function(){ clearForm(); modal.show(); });

    // Edit handlers
    document.querySelectorAll('.btn-edit-event').forEach(function(b){
        b.addEventListener('click', function(){
            const tr = b.closest('tr');
            const id = tr.getAttribute('data-id');
            const year = tr.querySelector('td:nth-child(1)').textContent.trim();
            const title = tr.querySelector('td:nth-child(2)').textContent.trim();
            const text = tr.querySelector('td:nth-child(4)').textContent.trim();
            const ordering = tr.querySelector('.input-order').value || 0;
            const img = tr.querySelector('td:nth-child(3) img');
            const iconEl = tr.querySelector('td:nth-child(3) i');

            document.getElementById('event_id').value = id;
            document.getElementById('event_year').value = year;
            document.getElementById('event_title').value = title;
            document.getElementById('event_text').value = text;
            document.getElementById('event_ordering').value = ordering;
            document.getElementById('event_icon').value = iconEl ? (iconEl.className || '') : '';
            const preview = document.getElementById('event_image_preview');
            preview.innerHTML = '';
            if(img) preview.innerHTML = '<img src="'+img.src+'" style="max-height:120px;object-fit:cover;border-radius:6px"/>';
            modal.show();
        });
    });

    // Delete handlers (use SweetAlert2 when available)
    document.querySelectorAll('.btn-delete-event').forEach(function(b){
        b.addEventListener('click', function(){
            const tr = b.closest('tr');
            const id = tr.getAttribute('data-id');
            const doDelete = function(){
                fetch('/administration/pages/historique/events/' + id, { method: 'DELETE', credentials:'same-origin', headers: { 'X-CSRF-TOKEN': csrf } })
                    .then(r=>r.json()).then(data=>{ 
                        if(data && data.success){ location.reload(); } 
                        else { 
                            if(window.Swal) Swal.fire({ icon:'error', title:'Erreur', text: data.message || 'Erreur suppression' }); 
                            else alert('Erreur suppression'); 
                        } 
                    }).catch(e=>{ console.error(e); if(window.Swal) Swal.fire({ icon:'error', title:'Erreur', text: e.message || String(e) }); else alert('Erreur'); });
            };

            if(window.Swal){
                Swal.fire({ title:'Confirmer', text:'Supprimer cet événement ?', icon:'warning', showCancelButton:true, confirmButtonText:'Oui, supprimer', cancelButtonText:'Annuler' }).then(function(res){ if(res.isConfirmed) doDelete(); });
            } else {
                if(confirm('Confirmer la suppression ?')) doDelete();
            }
        });
    });

    // Preview image select
    document.getElementById('event_image')?.addEventListener('change', function(e){
        const f = e.target.files && e.target.files[0];
        const preview = document.getElementById('event_image_preview');
        preview.innerHTML = '';
        if(f){ preview.innerHTML = '<img src="'+URL.createObjectURL(f)+'" style="max-height:120px;object-fit:cover;border-radius:6px"/>'; }
    });

    // Save event (create or update)
    document.getElementById('saveEvent').addEventListener('click', function(){
        const id = document.getElementById('event_id').value;
        const url = id ? '/administration/pages/historique/events/' + id : ROUTES.storeEvent;
        const method = id ? 'PUT' : 'POST';
        const fd = new FormData(form);
        if(!fd.get('_token')) fd.append('_token', csrf);
        // file size check
        const f = fd.get('image');
        if(f instanceof File && f.size > 10 * 1024 * 1024){ 
            if(window.Swal) Swal.fire({ icon:'error', title:'Fichier trop volumineux', text:'Image trop volumineuse (max 10 MB)'} );
            else alert('Image trop volumineuse (max 10 MB)');
            return; 
        }

        fetch(url, { method: method, credentials:'same-origin', headers: { 'X-CSRF-TOKEN': csrf }, body: fd })
            .then(async r => {
                const ct = r.headers.get('content-type') || '';
                if(r.ok && ct.includes('application/json')){
                    const data = await r.json();
                    if(data && data.success){ location.reload(); }
                    else { if(window.Swal) Swal.fire({ icon:'error', title:'Erreur', text: data.message || 'Erreur' }); else alert(data.message || 'Erreur'); }
                } else if(r.ok){ location.reload(); } else { const t = await r.text(); if(window.Swal) Swal.fire({ icon:'error', title:'Erreur', text: 'Erreur: '+r.status+'\n'+t }); else alert('Erreur: '+r.status+'\n'+t); }
            }).catch(e=>{ console.error(e); if(window.Swal) Swal.fire({ icon:'error', title:'Erreur réseau', text: e.message || String(e) }); else alert('Erreur réseau'); });
    });

    // ---- Milestones: add / edit / delete handlers ----
    const btnAddMs = document.getElementById('btnAddMilestone');
    const modalMsEl = document.getElementById('modalMilestone');
    const modalMs = modalMsEl ? new bootstrap.Modal(modalMsEl) : null;
    const formMs = document.getElementById('formMilestone');

    if(btnAddMs){ btnAddMs.addEventListener('click', function(){ formMs.reset(); document.getElementById('milestone_id').value=''; modalMs.show(); }); }

    document.querySelectorAll('.btn-edit-milestone').forEach(function(b){ b.addEventListener('click', function(){ const tr = b.closest('tr'); const id = tr.getAttribute('data-id'); document.getElementById('milestone_id').value = id; document.getElementById('ms_number').value = tr.children[1].textContent.trim(); document.getElementById('ms_label').value = tr.children[2].textContent.trim(); document.getElementById('ms_icon').value = (tr.querySelector('td:nth-child(4) i')||{}).className || ''; document.getElementById('ms_description').value = tr.querySelector('td:nth-child(5)').textContent.trim(); document.getElementById('ms_ordering').value = tr.querySelector('.input-order-milestone')?.value || 0; modalMs.show(); }); });

    document.querySelectorAll('.btn-delete-milestone').forEach(function(b){ b.addEventListener('click', function(){ const tr = b.closest('tr'); const id = tr.getAttribute('data-id'); const doDelete = function(){ fetch('/administration/pages/historique/milestones/' + id, { method:'DELETE', credentials:'same-origin', headers:{ 'X-CSRF-TOKEN': csrf } }).then(r=>r.json()).then(d=>{ if(d && d.success) location.reload(); else { if(window.Swal) Swal.fire({ icon:'error', title:'Erreur', text: d.message || 'Erreur suppression' }); else alert('Erreur suppression'); } }).catch(e=>{ console.error(e); if(window.Swal) Swal.fire({ icon:'error', title:'Erreur réseau', text: e.message || String(e) }); else alert('Erreur'); }); };
        if(window.Swal){ Swal.fire({ title:'Confirmer', text:'Supprimer cette réalisation ?', icon:'warning', showCancelButton:true }).then(res=>{ if(res.isConfirmed) doDelete(); }); } else { if(confirm('Supprimer ?')) doDelete(); }
    }); });

    document.getElementById('saveMilestone')?.addEventListener('click', function(){ const id = document.getElementById('milestone_id').value; const url = id ? ('/administration/pages/historique/milestones/' + id) : ROUTES.storeMilestone; const method = id ? 'PUT' : 'POST'; const fd = new FormData(formMs); if(!fd.get('_token')) fd.append('_token', csrf); fetch(url, { method: method, credentials:'same-origin', headers:{ 'X-CSRF-TOKEN': csrf }, body: fd }).then(async r=>{ const ct = r.headers.get('content-type')||''; if(r.ok){ const data = ct.includes('application/json') ? await r.json().catch(()=>null) : null; if(!data || data.success) location.reload(); else { if(window.Swal) Swal.fire({ icon:'error', title:'Erreur', text: data.message||'Erreur' }); else alert('Erreur'); } } else { const t = await r.text(); if(window.Swal) Swal.fire({ icon:'error', title:'Erreur', text: t }); else alert('Erreur'); } }).catch(e=>{ console.error(e); if(window.Swal) Swal.fire({ icon:'error', title:'Erreur réseau', text: e.message||String(e) }); else alert('Erreur'); }); });

    // ---- Archives: add / edit / delete handlers ----
    const btnAddAr = document.getElementById('btnAddArchive');
    const modalArEl = document.getElementById('modalArchive');
    const modalAr = modalArEl ? new bootstrap.Modal(modalArEl) : null;
    const formAr = document.getElementById('formArchive');

    if(btnAddAr){ btnAddAr.addEventListener('click', function(){ formAr.reset(); document.getElementById('archive_id').value=''; document.getElementById('archive_image_preview').innerHTML=''; modalAr.show(); }); }

    document.querySelectorAll('.btn-edit-archive').forEach(function(b){ b.addEventListener('click', function(){ const tr = b.closest('tr'); const id = tr.getAttribute('data-id'); document.getElementById('archive_id').value = id; document.getElementById('ar_title').value = tr.children[1].textContent.trim(); document.getElementById('ar_text').value = tr.children[3].textContent.trim(); const linkEl = tr.querySelector('td:nth-child(5) a'); document.getElementById('ar_link').value = linkEl ? linkEl.href : ''; const img = tr.querySelector('td:nth-child(3) img'); document.getElementById('archive_image_preview').innerHTML = img ? ('<img src="'+img.src+'" style="max-height:120px;object-fit:cover;border-radius:6px"/>') : ''; document.getElementById('ar_ordering').value = tr.querySelector('.input-order-archive')?.value || 0; modalAr.show(); }); });

    document.querySelectorAll('.btn-delete-archive').forEach(function(b){ b.addEventListener('click', function(){ const tr = b.closest('tr'); const id = tr.getAttribute('data-id'); const doDelete = function(){ fetch('/administration/pages/historique/archives/' + id, { method:'DELETE', credentials:'same-origin', headers:{ 'X-CSRF-TOKEN': csrf } }).then(r=>r.json()).then(d=>{ if(d && d.success) location.reload(); else { if(window.Swal) Swal.fire({ icon:'error', title:'Erreur', text: d.message || 'Erreur suppression' }); else alert('Erreur suppression'); } }).catch(e=>{ console.error(e); if(window.Swal) Swal.fire({ icon:'error', title:'Erreur réseau', text: e.message || String(e) }); else alert('Erreur'); }); };
        if(window.Swal){ Swal.fire({ title:'Confirmer', text:'Supprimer cette archive ?', icon:'warning', showCancelButton:true }).then(res=>{ if(res.isConfirmed) doDelete(); }); } else { if(confirm('Supprimer ?')) doDelete(); }
    }); });

    document.getElementById('ar_image')?.addEventListener('change', function(e){ const f = e.target.files && e.target.files[0]; const preview = document.getElementById('archive_image_preview'); preview.innerHTML = ''; if(f){ if(f.size > 10 * 1024 * 1024){ if(window.Swal) Swal.fire({ icon:'error', title:'Fichier trop volumineux', text:'Image trop volumineuse (max 10 MB)'}); else alert('Image trop volumineuse (max 10 MB)'); e.target.value=''; return; } preview.innerHTML = '<img src="'+URL.createObjectURL(f)+'" style="max-height:120px;object-fit:cover;border-radius:6px"/>'; } });

    document.getElementById('saveArchive')?.addEventListener('click', function(){ const id = document.getElementById('archive_id').value; const url = id ? ('/administration/pages/historique/archives/' + id) : ROUTES.storeArchive; const method = id ? 'PUT' : 'POST'; const fd = new FormData(formAr); if(!fd.get('_token')) fd.append('_token', csrf); const f = fd.get('image'); if(f instanceof File && f.size > 10 * 1024 * 1024){ if(window.Swal) Swal.fire({ icon:'error', title:'Fichier trop volumineux', text:'Image trop volumineuse (max 10 MB)'}); else alert('Image trop volumineuse (max 10 MB)'); return; } fetch(url, { method: method, credentials:'same-origin', headers:{ 'X-CSRF-TOKEN': csrf }, body: fd }).then(async r=>{ if(r.ok){ location.reload(); } else { const t = await r.text(); if(window.Swal) Swal.fire({ icon:'error', title:'Erreur', text: t }); else alert('Erreur'); } }).catch(e=>{ console.error(e); if(window.Swal) Swal.fire({ icon:'error', title:'Erreur réseau', text: e.message||String(e) }); else alert('Erreur'); }); });

    // Save order
    document.getElementById('btnSaveOrder').addEventListener('click', function(){
        const rows = Array.from(document.querySelectorAll('#historique-events-table tbody tr[data-id]'));
        const ordering = rows.map(r => ({ id: r.getAttribute('data-id'), ordering: parseInt(r.querySelector('.input-order').value || 0) }));
        fetch(ROUTES.reorderEvents, { method:'POST', credentials:'same-origin', headers:{ 'Content-Type':'application/json','X-CSRF-TOKEN': csrf }, body: JSON.stringify({ ordering }) })
            .then(r=>r.json()).then(data=>{ if(data && data.success){ alert('Ordre enregistré'); location.reload(); } else alert('Erreur'); }).catch(e=>{ console.error(e); alert('Erreur'); });
    });

    // Save order Milestones
    document.getElementById('btnSaveOrderMilestones')?.addEventListener('click', function(){
        const rows = Array.from(document.querySelectorAll('#historique-milestones-table tbody tr[data-id]'));
        const ordering = rows.map(r => ({ id: r.getAttribute('data-id'), ordering: parseInt(r.querySelector('.input-order-milestone').value || 0) }));
        fetch(ROUTES.reorderMilestones, { method:'POST', credentials:'same-origin', headers:{ 'Content-Type':'application/json','X-CSRF-TOKEN': csrf }, body: JSON.stringify({ ordering }) })
            .then(r=>r.json()).then(data=>{ if(data && data.success){ alert('Ordre enregistré'); location.reload(); } else alert('Erreur'); }).catch(e=>{ console.error(e); alert('Erreur'); });
    });

    // Save order Archives
    document.getElementById('btnSaveOrderArchives')?.addEventListener('click', function(){
        const rows = Array.from(document.querySelectorAll('#historique-archives-table tbody tr[data-id]'));
        const ordering = rows.map(r => ({ id: r.getAttribute('data-id'), ordering: parseInt(r.querySelector('.input-order-archive').value || 0) }));
        fetch(ROUTES.reorderArchives, { method:'POST', credentials:'same-origin', headers:{ 'Content-Type':'application/json','X-CSRF-TOKEN': csrf }, body: JSON.stringify({ ordering }) })
            .then(r=>r.json()).then(data=>{ if(data && data.success){ alert('Ordre enregistré'); location.reload(); } else alert('Erreur'); }).catch(e=>{ console.error(e); alert('Erreur'); });
    });

    // ---- Historique Main: modal handlers (texte + image) ----
    const btnEditMain = document.getElementById('btnEditHistoriqueMain');
    const modalMainEl = document.getElementById('modalHistoriqueMain');
    const modalMain = modalMainEl ? new bootstrap.Modal(modalMainEl) : null;
    const formMain = document.getElementById('formHistoriqueMain');

    if(btnEditMain){
        btnEditMain.addEventListener('click', function(){
            // Prefill modal using server-rendered values already present in the textarea/preview
            // Clear any selected file input before opening
            const imgInput = document.getElementById('hist_main_image'); if(imgInput) imgInput.value = '';
            modalMain.show();
        });
    }

    document.getElementById('hist_main_image')?.addEventListener('change', function(e){
        const f = e.target.files && e.target.files[0];
        const preview = document.getElementById('hist_main_image_preview');
        preview.innerHTML = '';
        if(f){
            if(f.size > 10 * 1024 * 1024){
                if(window.Swal) Swal.fire({ icon:'error', title:'Fichier trop volumineux', text:'Image trop volumineuse (max 10 MB)'});
                else alert('Image trop volumineuse (max 10 MB)');
                e.target.value = '';
                return;
            }
            preview.innerHTML = '<img src="'+URL.createObjectURL(f)+'" style="max-height:120px;object-fit:cover;border-radius:6px"/>';
        }
    });

    document.getElementById('saveHistoriqueMain')?.addEventListener('click', function(){
        const fd = new FormData(formMain);
        if(!fd.get('_token')) fd.append('_token', csrf);
        const f = fd.get('image');
        if(f instanceof File && f.size > 10 * 1024 * 1024){ if(window.Swal) Swal.fire({ icon:'error', title:'Fichier trop volumineux', text:'Image trop volumineuse (max 10 MB)'}); else alert('Image trop volumineux (max 10 MB)'); return; }
        const url = ROUTES.updateMain || '/administration/pages/historique/update/main';
        fetch(url, { method:'POST', credentials:'same-origin', headers:{ 'X-CSRF-TOKEN': csrf }, body: fd })
            .then(async r => {
                if(r.ok){
                    if(window.Swal) Swal.fire({ icon:'success', title:'Enregistré', timer:900, showConfirmButton:false });
                    setTimeout(()=> location.reload(), 700);
                } else {
                    const t = await r.text();
                    if(window.Swal) Swal.fire({ icon:'error', title:'Erreur', text: t }); else alert('Erreur: '+t);
                }
            }).catch(e=>{ console.error(e); if(window.Swal) Swal.fire({ icon:'error', title:'Erreur réseau', text: e.message||String(e) }); else alert('Erreur réseau'); });
    });
});
</script>
@endpush

@endsection
