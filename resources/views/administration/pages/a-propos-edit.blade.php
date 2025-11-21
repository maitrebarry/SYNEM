@extends('layouts.administration')

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('administration.tableau-de-bord') }}">Tableau de bord</a></li>
        <li class="breadcrumb-item active" aria-current="page">Édition de la page À propos du SYNEM</li>
    </ol>
</nav>

<a href="{{ route('administration.tableau-de-bord') }}" class="btn btn-secondary mb-3">
    <i class="fas fa-arrow-left"></i> Retour au tableau de bord
</a>

<div class="container-fluid py-4">
    <!-- <h2 class="mb-4">Édition de la page À propos du SYNEM</h2> -->
    <form method="POST" action="/administration/pages/a-propos/update" enctype="multipart/form-data">
        @csrf
        <div class="card mb-4">
            <div class="card-header">Image SYNEM équipe</div>
            <div class="card-body">
                <div class="mb-2 d-flex align-items-start">
                    @php $placeholderImg = asset('images/static/synem-demo.jpg'); @endphp
                    @if(!empty($about->image))
                        <img id="about-image-preview" src="{{ asset('storage/about/' . $about->image) }}" data-placeholder="{{ $placeholderImg }}" alt="Image SYNEM" class="img-fluid mb-2 me-3" style="max-width:300px;">
                    @else
                        <img id="about-image-preview" src="{{ $placeholderImg }}" data-placeholder="{{ $placeholderImg }}" alt="Image SYNEM" class="img-fluid mb-2 me-3" style="max-width:300px;">
                    @endif
                    <div>
                        <input id="image-input" type="file" name="image" class="form-control mb-2">
                        <div class="d-flex gap-2">
                            <button type="button" id="btn-save-image" class="btn btn-primary btn-sm">Enregistrer l'image</button>
                            @if(!empty($about->image))
                                <button type="button" id="btn-delete-image" class="btn btn-outline-danger btn-sm" data-delete-url="{{ route('administration.pages.a-propos.image.delete') }}">Supprimer l'image</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">À propos du SYNEM</div>
            <div class="card-body">
                @php $presentation = $about->about_text ?? null; @endphp
                <div class="mb-3">
                    <table class="table table-sm">
                        <thead><tr><th>Présentation</th><th style="width:160px">Actions</th></tr></thead>
                        <tbody>
                            @if($presentation)
                                <tr>
                                    <td class="text-truncate" style="max-width:720px">{!! nl2br(e($presentation)) !!}</td>
                                    <td>
                                        <button type="button" id="btn-edit-presentation" class="btn btn-sm btn-outline-secondary" data-update-url="{{ route('administration.pages.a-propos.update.presentation') }}">Éditer</button>
                                        <button type="button" id="btn-delete-presentation" class="btn btn-sm btn-outline-danger">Supprimer</button>
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td class="text-muted">Aucune présentation définie.</td>
                                    <td>
                                        <button type="button" id="btn-edit-presentation" class="btn btn-sm btn-outline-primary" data-update-url="{{ route('administration.pages.a-propos.update.presentation') }}">Ajouter</button>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{-- Presentation modal will handle editing; keep global form free of the presentation textarea so add fields remain empty --}}
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">Statistiques</div>
            <div class="card-body row">
                <div class="col-md-3 mb-2">
                    <label>Membres actifs</label>
                    <input type="text" name="stats_members" class="form-control" value="{{ old('stats_members', $about->stats_members ?? '') }}">
                </div>
                <div class="col-md-3 mb-2">
                    <label>Années d'expérience</label>
                    <input type="text" name="stats_years" class="form-control" value="{{ old('stats_years', $about->stats_years ?? '') }}">
                </div>
                <div class="col-md-3 mb-2">
                    <label>Régions couvertes</label>
                    <input type="text" name="stats_regions" class="form-control" value="{{ old('stats_regions', $about->stats_regions ?? '') }}">
                </div>
                <div class="col-md-3 mb-2">
                    <label>Formations organisées</label>
                    <input type="text" name="stats_trainings" class="form-control" value="{{ old('stats_trainings', $about->stats_trainings ?? '') }}">
                </div>
                <div class="mt-2">
                    <button type="button" id="btn-save-stats" class="btn btn-primary btn-sm">Enregistrer les statistiques</button>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">Notre Histoire en Dates</div>
            <div class="card-body">
                {{-- Existing timeline entries table (shows up to 5, filterable) --}}
                @php $existingTimeline = $about->timeline ?? []; @endphp
                <div class="mb-3">
                    <input type="text" id="filter-timeline" class="form-control form-control-sm" placeholder="Filtrer la timeline...">
                </div>
                <div class="table-responsive mb-3">
                    <table class="table table-sm table-striped" id="timeline-table">
                        <thead>
                            <tr>
                                <th style="width:100px">Année</th>
                                <th>Titre</th>
                                <th>Texte</th>
                                <th style="width:140px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach(array_slice($existingTimeline, 0, 5) as $i => $event)
                            <tr data-index="{{ $i }}">
                                <td>{{ $event['year'] ?? '' }}</td>
                                <td>{{ $event['title'] ?? '' }}</td>
                                <td class="text-truncate" style="max-width:320px">{{ $event['text'] ?? '' }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-secondary btn-open-timeline-modal" data-index="{{ $i }}" data-update-url="{{ url('administration/pages/a-propos/timeline/'.$i) }}"><i class="fa fa-edit"></i></button>
                                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-delete-url="{{ url('administration/pages/a-propos/timeline/'.$i) }}" data-type="timeline" data-index="{{ $i }}"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                

                {{-- edit handled in modal (see bottom of page) --}}

                {{-- Add via modal instead of global form submission --}}
                <button type="button" id="add-timeline-btn" class="btn btn-outline-primary btn-sm">Ajouter un événement</button>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">Notre Bureau Exécutif</div>
            <div class="card-body">
                {{-- Existing team entries table (shows up to 5, filterable) --}}
                @php $existingTeam = $about->team ?? []; @endphp
                <div class="mb-3">
                    <input type="text" id="filter-team" class="form-control form-control-sm" placeholder="Filtrer les membres...">
                </div>
                <div class="table-responsive mb-3">
                    <table class="table table-sm table-striped" id="team-table">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Nom</th>
                                <th>Fonction</th>
                                <th style="width:160px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach(array_slice($existingTeam, 0, 5) as $i => $member)
                            <tr data-index="{{ $i }}">
                                <td style="width:80px">
                                    @if(!empty($member['photo']))
                                        <img src="{{ asset('storage/team/' . $member['photo']) }}" style="max-width:60px;" alt="">
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>{{ $member['name'] ?? '' }}</td>
                                <td>{{ $member['role'] ?? '' }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-secondary btn-open-team-modal" data-index="{{ $i }}" data-update-url="{{ url('administration/pages/a-propos/team/'.$i) }}"><i class="fa fa-edit"></i></button>
                                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-delete-url="{{ url('administration/pages/a-propos/team/'.$i) }}" data-type="team" data-index="{{ $i }}"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                

                {{-- Inline edit form for team entries (hidden by default) --}}
                <div id="team-edit-form" class="card card-body mb-3" style="display:none;">
                    <form id="team-edit" method="POST" action="" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="row g-2">
                            <div class="col-md-4"><input type="text" id="edit-name" name="name" class="form-control" placeholder="Nom"></div>
                            <div class="col-md-4"><input type="text" id="edit-role" name="role" class="form-control" placeholder="Fonction"></div>
                            <div class="col-md-3"><input type="file" id="edit-photo" name="photo" class="form-control"></div>
                            <div class="col-md-1 d-flex align-items-center"><button type="submit" class="btn btn-primary btn-sm">Mettre à jour</button></div>
                        </div>
                    </form>
                </div>

                {{-- Add via modal instead of global form submission --}}
                <button type="button" id="add-team-btn" class="btn btn-outline-primary btn-sm">Ajouter un membre</button>
            </div>
        </div>
        
    </form>
</div>


@php
$section = session('success_section');
@endphp

<div id="session-success" data-success="{{ session('success') ? '1' : '0' }}" style="display:none"></div>
<div id="debug-config" data-local="{{ app()->environment() === 'local' ? '1' : '0' }}" data-action="/administration/pages/a-propos/update" style="display:none"></div>

<!-- Modals placed outside the main form to avoid nested forms -->
<!-- Timeline Edit Modal -->
<div class="modal fade" id="modalTimelineEdit" tabindex="-1" aria-labelledby="modalTimelineEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTimelineEditLabel">Éditer un événement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="modalTimelineForm">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div id="modal-timeline-rows">
                        <!-- rows will be added here by JS -->
                    </div>
                    <div class="mt-2">
                        <button type="button" id="modal-add-timeline-row" class="btn btn-sm btn-outline-secondary">Ajouter une ligne</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" id="modalTimelineSave" class="btn btn-primary">Enregistrer</button>
            </div>
        </div>
    </div>
</div>

<!-- Team Edit Modal -->
<div class="modal fade" id="modalTeamEdit" tabindex="-1" aria-labelledby="modalTeamEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTeamEditLabel">Éditer un membre</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="modalTeamForm" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div id="modal-team-rows">
                        <!-- team rows added here -->
                    </div>
                    <div class="mt-2">
                        <button type="button" id="modal-add-team-row" class="btn btn-sm btn-outline-secondary">Ajouter une ligne</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" id="modalTeamSave" class="btn btn-primary">Enregistrer</button>
            </div>
        </div>
    </div>
</div>

            <!-- Presentation Edit Modal -->
            <div class="modal fade" id="modalPresentationEdit" tabindex="-1" aria-labelledby="modalPresentationEditLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalPresentationEditLabel">Éditer la présentation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="modalPresentationForm">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="mb-2">
                                    <textarea id="modal-presentation-text" name="about_text" class="form-control" rows="6"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="button" id="modalPresentationSave" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </div>
                </div>
            </div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Add-row functionality moved to modals. Inline add/remove rows have been removed to avoid confusion.

    // Table filters and inline edit handlers
    const filterTimeline = document.getElementById('filter-timeline');
    const timelineTable = document.getElementById('timeline-table');
    if (filterTimeline && timelineTable) {
        filterTimeline.addEventListener('input', function () {
            const q = this.value.toLowerCase();
            timelineTable.querySelectorAll('tbody tr').forEach(tr => {
                tr.style.display = (q === '' || tr.textContent.toLowerCase().includes(q)) ? '' : 'none';
            });
        });
    }

    // Timeline modal (create multiple rows or edit single)
    let currentTimelineUrl = null;
    let timelineModalMode = 'create'; // 'create' or 'edit'
    const modalTimeline = document.getElementById('modalTimelineEdit');
    const modalTimelineRows = document.getElementById('modal-timeline-rows');

    function addTimelineModalRow(year = '', title = '', text = '') {
        const idx = modalTimelineRows.querySelectorAll('.modal-timeline-row').length;
        const row = document.createElement('div');
        row.className = 'modal-timeline-row row g-2 mb-2';
        row.innerHTML = `
            <div class="col-md-2"><input type="text" name="timeline[${idx}][year]" class="form-control" placeholder="Année" value="${year}"></div>
            <div class="col-md-4"><input type="text" name="timeline[${idx}][title]" class="form-control" placeholder="Titre" value="${title}"></div>
            <div class="col-md-5"><input type="text" name="timeline[${idx}][text]" class="form-control" placeholder="Texte" value="${text}"></div>
            <div class="col-md-1 d-flex align-items-center">
                <button type="button" class="btn btn-outline-danger btn-sm btn-remove-modal-timeline" title="Supprimer cette ligne">&times;</button>
            </div>
        `;
        modalTimelineRows.appendChild(row);
    }

    document.getElementById('modal-add-timeline-row').addEventListener('click', function () {
        addTimelineModalRow();
    });

    modalTimelineRows.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-remove-modal-timeline');
        if (!btn) return;
        btn.closest('.modal-timeline-row').remove();
        // reindex names
        modalTimelineRows.querySelectorAll('.modal-timeline-row').forEach((r, i) => {
            r.querySelectorAll('input').forEach(inp => {
                const name = inp.getAttribute('name') || '';
                const newName = name.replace(/timeline\[\d+\]/, `timeline[${i}]`);
                inp.setAttribute('name', newName);
            });
        });
    });

    document.querySelectorAll('.btn-open-timeline-modal').forEach(btn => {
        btn.addEventListener('click', function () {
            const tr = this.closest('tr');
            const year = tr.querySelector('td:nth-child(1)').textContent.trim();
            const title = tr.querySelector('td:nth-child(2)').textContent.trim();
            const text = tr.querySelector('td:nth-child(3)').textContent.trim();
            currentTimelineUrl = this.dataset.updateUrl;
            timelineModalMode = 'edit';
            modalTimelineRows.innerHTML = '';
            addTimelineModalRow(year, title, text);
            var modal = new bootstrap.Modal(modalTimeline);
            modal.show();
        });
    });

    // Add timeline: open modal in create mode
    const addTimelineBtnEl = document.getElementById('add-timeline-btn');
    if (addTimelineBtnEl) {
        addTimelineBtnEl.addEventListener('click', function () {
            const dbg = document.getElementById('debug-config');
            currentTimelineUrl = dbg && dbg.dataset.local === '1' ? dbg.dataset.action.replace('/update','/timeline') : '{{ url("administration/pages/a-propos/timeline") }}';
            timelineModalMode = 'create';
            modalTimelineRows.innerHTML = '';
            addTimelineModalRow();
            var modal = new bootstrap.Modal(modalTimeline);
            modal.show();
        });
    }

    const filterTeam = document.getElementById('filter-team');
    const teamTable = document.getElementById('team-table');
    if (filterTeam && teamTable) {
        filterTeam.addEventListener('input', function () {
            const q = this.value.toLowerCase();
            teamTable.querySelectorAll('tbody tr').forEach(tr => {
                tr.style.display = (q === '' || tr.textContent.toLowerCase().includes(q)) ? '' : 'none';
            });
        });
    }

    // Team modal (create multiple rows or edit single)
    let currentTeamUrl = null;
    let teamModalMode = 'create';
    const modalTeam = document.getElementById('modalTeamEdit');
    const modalTeamRows = document.getElementById('modal-team-rows');

    function addTeamModalRow(name = '', role = '') {
        const idx = modalTeamRows.querySelectorAll('.modal-team-row').length;
        const row = document.createElement('div');
        row.className = 'modal-team-row row g-2 mb-2 align-items-center';
        row.innerHTML = `
            <div class="col-md-4"><input type="text" name="team[${idx}][name]" class="form-control" placeholder="Nom" value="${name}"></div>
            <div class="col-md-4"><input type="text" name="team[${idx}][role]" class="form-control" placeholder="Fonction" value="${role}"></div>
            <div class="col-md-3"><input type="file" name="team[${idx}][photo]" class="form-control"></div>
            <div class="col-md-1 d-flex align-items-center"><button type="button" class="btn btn-outline-danger btn-sm btn-remove-modal-team">&times;</button></div>
        `;
        modalTeamRows.appendChild(row);
    }

    document.getElementById('modal-add-team-row').addEventListener('click', function () {
        addTeamModalRow();
    });

    modalTeamRows.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-remove-modal-team');
        if (!btn) return;
        btn.closest('.modal-team-row').remove();
        // reindex names
        modalTeamRows.querySelectorAll('.modal-team-row').forEach((r, i) => {
            r.querySelectorAll('input').forEach(inp => {
                const name = inp.getAttribute('name') || '';
                const newName = name.replace(/team\[\d+\]/, `team[${i}]`);
                inp.setAttribute('name', newName);
            });
        });
    });

    document.querySelectorAll('.btn-open-team-modal').forEach(btn => {
        btn.addEventListener('click', function () {
            const tr = this.closest('tr');
            const name = tr.children[1].textContent.trim();
            const role = tr.children[2].textContent.trim();
            currentTeamUrl = this.dataset.updateUrl;
            teamModalMode = 'edit';
            modalTeamRows.innerHTML = '';
            addTeamModalRow(name, role);
            var modal = new bootstrap.Modal(modalTeam);
            modal.show();
        });
    });

    const addTeamBtnEl = document.getElementById('add-team-btn');
    if (addTeamBtnEl) {
        addTeamBtnEl.addEventListener('click', function () {
            const dbg = document.getElementById('debug-config');
            currentTeamUrl = dbg && dbg.dataset.local === '1' ? dbg.dataset.action.replace('/update','/team') : '{{ url("administration/pages/a-propos/team") }}';
            teamModalMode = 'create';
            modalTeamRows.innerHTML = '';
            addTeamModalRow();
            var modal = new bootstrap.Modal(modalTeam);
            modal.show();
        });
    }

    // Delete handlers using SweetAlert & fetch (avoid nested forms)
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function () {
            const url = this.dataset.deleteUrl;
            const type = this.dataset.type;
            Swal.fire({
                title: 'Confirmer la suppression',
                text: "Êtes-vous sûr de vouloir supprimer cet élément ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(url, {
                        method: 'DELETE',
                        credentials: 'same-origin',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    }).then(r => {
                        if (r.ok) {
                            Swal.fire('Supprimé', 'L\'élément a été supprimé.', 'success').then(()=> location.reload());
                        } else return r.json().then(j=> Promise.reject(j));
                    }).catch(err => {
                        Swal.fire('Erreur', 'La suppression a échoué.', 'error');
                    });
                }
            });
        });
    });

    // Réinitialisation des champs après soumission
    const sessionNode = document.getElementById('session-success');
    const hasSuccess = sessionNode && sessionNode.dataset && sessionNode.dataset.success === '1';

    // Modal save actions for timeline: support multiple rows in create mode, single row in edit mode
    document.getElementById('modalTimelineSave').addEventListener('click', async function () {
        if (!currentTimelineUrl) return;
        const rows = Array.from(modalTimelineRows.querySelectorAll('.modal-timeline-row'));
        if (rows.length === 0) return Swal.fire('Erreur','Aucune ligne à enregistrer.','warning');

        // validation: ensure required fields present
        for (const r of rows) {
            const year = r.querySelector('input[name$="[year]"]').value.trim();
            const title = r.querySelector('input[name$="[title]"]').value.trim();
            if (!year || !title) return Swal.fire('Erreur','Veuillez remplir au moins l\'année et le titre pour chaque ligne.','warning');
        }

        Swal.fire({title: timelineModalMode === 'create' ? 'Création...' : 'Mise à jour...', allowOutsideClick:false, didOpen: ()=> Swal.showLoading()});
        try {
            if (timelineModalMode === 'create') {
                // send one POST per row sequentially
                for (const r of rows) {
                    const fd = new FormData();
                    fd.append('_token', csrfToken);
                    fd.append('year', r.querySelector('input[name$="[year]"]').value.trim());
                    fd.append('title', r.querySelector('input[name$="[title]"]').value.trim());
                    fd.append('text', r.querySelector('input[name$="[text]"]').value.trim());
                    const res = await fetch(currentTimelineUrl, { method: 'POST', credentials: 'same-origin', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }, body: fd });
                    if (!res.ok) throw new Error('Enregistrement échoué');
                }
                Swal.fire('Succès','Événements créés.','success').then(()=> location.reload());
            } else {
                // edit mode: only single row expected
                const r = rows[0];
                const fd = new FormData();
                fd.append('_token', csrfToken);
                fd.append('_method', 'PUT');
                fd.append('year', r.querySelector('input[name$="[year]"]').value.trim());
                fd.append('title', r.querySelector('input[name$="[title]"]').value.trim());
                fd.append('text', r.querySelector('input[name$="[text]"]').value.trim());
                const res = await fetch(currentTimelineUrl, { method: 'POST', credentials: 'same-origin', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }, body: fd });
                if (!res.ok) throw new Error('Mise à jour échouée');
                Swal.fire('Succès','Événement mis à jour.','success').then(()=> location.reload());
            }
        } catch (err) {
            Swal.close();
            console.error(err);
            Swal.fire('Erreur','Échec de l\'enregistrement.','error');
        }
    });

    document.getElementById('modalTeamSave').addEventListener('click', async function () {
        if (!currentTeamUrl) return;
        const rows = Array.from(modalTeamRows.querySelectorAll('.modal-team-row'));
        if (rows.length === 0) return Swal.fire('Erreur','Aucune ligne à enregistrer.','warning');

        // basic validation
        for (const r of rows) {
            const name = r.querySelector('input[name$="[name]"]').value.trim();
            const role = r.querySelector('input[name$="[role]"]').value.trim();
            if (!name || !role) return Swal.fire('Erreur','Veuillez renseigner le nom et la fonction pour chaque membre.','warning');
        }

        Swal.fire({title: teamModalMode === 'create' ? 'Création...' : 'Mise à jour...', allowOutsideClick:false, didOpen: ()=> Swal.showLoading()});
        try {
            if (teamModalMode === 'create') {
                for (const r of rows) {
                    const fd = new FormData();
                    fd.append('_token', csrfToken);
                    fd.append('name', r.querySelector('input[name$="[name]"]').value.trim());
                    fd.append('role', r.querySelector('input[name$="[role]"]').value.trim());
                    const fileInput = r.querySelector('input[type="file"]');
                    if (fileInput && fileInput.files && fileInput.files[0]) fd.append('photo', fileInput.files[0]);
                    const res = await fetch(currentTeamUrl, { method: 'POST', credentials: 'same-origin', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }, body: fd });
                    if (!res.ok) throw new Error('Enregistrement échoué');
                }
                Swal.fire('Succès','Membres créés.','success').then(()=> location.reload());
            } else {
                const r = rows[0];
                const fd = new FormData();
                fd.append('_token', csrfToken);
                fd.append('_method', 'PUT');
                fd.append('name', r.querySelector('input[name$="[name]"]').value.trim());
                fd.append('role', r.querySelector('input[name$="[role]"]').value.trim());
                const fileInput = r.querySelector('input[type="file"]');
                if (fileInput && fileInput.files && fileInput.files[0]) fd.append('photo', fileInput.files[0]);
                const res = await fetch(currentTeamUrl, { method: 'POST', credentials: 'same-origin', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }, body: fd });
                if (!res.ok) throw new Error('Mise à jour échouée');
                Swal.fire('Succès','Membre mis à jour.','success').then(()=> location.reload());
            }
        } catch (err) {
            Swal.close();
            console.error(err);
            Swal.fire('Erreur','Échec de l\'enregistrement.','error');
        }
    });

    // Presentation edit/add/delete handlers
    const btnEditPresentation = document.getElementById('btn-edit-presentation');
    const btnDeletePresentation = document.getElementById('btn-delete-presentation');
    let currentPresentationUrl = null;
    if (btnEditPresentation) {
        btnEditPresentation.addEventListener('click', function () {
            currentPresentationUrl = this.dataset.updateUrl;
            const tr = this.closest('tr');
            const cell = tr ? tr.querySelector('td') : null;
            const text = cell ? cell.textContent.trim() : '';
            document.getElementById('modal-presentation-text').value = text || '';
            var modal = new bootstrap.Modal(document.getElementById('modalPresentationEdit'));
            modal.show();
        });
    }
    if (btnDeletePresentation) {
        btnDeletePresentation.addEventListener('click', function () {
            const url = btnEditPresentation ? btnEditPresentation.dataset.updateUrl : null;
            if (!url) return;
            Swal.fire({
                title: 'Confirmer la suppression',
                text: "Supprimer la présentation ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    const fd = new FormData();
                    fd.append('_token', csrfToken);
                    fd.append('about_text', '');
                    fetch(url, {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                        body: fd
                    }).then(r => {
                        if (r.ok) return r.json();
                        return r.json().then(j => Promise.reject(j));
                    }).then(()=> Swal.fire('Supprimé','La présentation a été supprimée.','success').then(()=> location.reload()))
                    .catch(()=> Swal.fire('Erreur','La suppression a échoué.','error'));
                }
            });
        });
    }

    document.getElementById('modalPresentationSave').addEventListener('click', function () {
        if (!currentPresentationUrl) return;
        const textarea = document.getElementById('modal-presentation-text');
        const fd = new FormData();
        fd.append('_token', csrfToken);
        fd.append('about_text', textarea.value || '');
        fetch(currentPresentationUrl, {
            method: 'POST',
            credentials: 'same-origin',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body: fd
        }).then(r => {
            if (r.ok) return r.json();
            return r.json().then(j => Promise.reject(j));
        }).then(()=> Swal.fire('Mis à jour','Présentation mise à jour.','success').then(()=> location.reload()))
        .catch(()=> Swal.fire('Erreur','La mise à jour a échoué.','error'));
    });

    // Debug: intercept global form submit (local only) to show server response for troubleshooting
    (function(){
        const dbg = document.getElementById('debug-config');
        if (!dbg || dbg.dataset.local !== '1') return;
        const mainForm = document.querySelector('form[action="' + dbg.dataset.action + '"]');
        if (!mainForm) return;
        mainForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const fd = new FormData(mainForm);
            Swal.fire({title:'Envoi...', text:'Envoi des données au serveur...', allowOutsideClick:false, didOpen: ()=> Swal.showLoading()});
            fetch(mainForm.action, {
                method: 'POST',
                credentials: 'same-origin',
                headers: { 'X-CSRF-TOKEN': csrfToken },
                body: fd
            }).then(async (res) => {
                const text = await res.text();
                Swal.close();
                if (res.ok) {
                    Swal.fire('Succès','Requête réussie (HTTP '+res.status+'). Voir console pour réponse complète.','success');
                } else {
                    Swal.fire('Erreur','Statut HTTP: '+res.status+' — Voir console pour la réponse.', 'error');
                }
                console.log('Response status:', res.status, 'URL:', res.url);
                console.log('Response text:', text);
            }).catch((err)=>{
                Swal.close();
                Swal.fire('Erreur réseau', err.message, 'error');
                console.error(err);
            });
        });
    })();

    // Image preview and delete handlers for main about image
    const imageInput = document.getElementById('image-input');
    const imagePreview = document.getElementById('about-image-preview');
    const btnDeleteImage = document.getElementById('btn-delete-image');
    if (imageInput && imagePreview) {
        imageInput.addEventListener('change', function () {
            const f = this.files && this.files[0];
            if (!f) return;
            const reader = new FileReader();
            reader.onload = function (e) {
                imagePreview.src = e.target.result;
            };
            reader.readAsDataURL(f);
        });
    }
    if (btnDeleteImage) {
        btnDeleteImage.addEventListener('click', function () {
            const url = this.dataset.deleteUrl;
            Swal.fire({
                title: 'Confirmer la suppression',
                text: "Supprimer l'image principale ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (!result.isConfirmed) return;
                fetch(url, {
                    method: 'DELETE',
                    credentials: 'same-origin',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                }).then(r => {
                    if (r.ok) return r.json();
                    return r.json().then(j => Promise.reject(j));
                }).then(()=> {
                    imagePreview.src = imagePreview.dataset.placeholder || '';
                    btnDeleteImage.remove();
                    Swal.fire('Supprimé','Image supprimée.','success');
                }).catch(()=> Swal.fire('Erreur','La suppression a échoué.','error'));
            });
        });
    }

    // Save image via AJAX
    const btnSaveImage = document.getElementById('btn-save-image');
    if (btnSaveImage) {
        btnSaveImage.addEventListener('click', function () {
            const inp = document.getElementById('image-input');
            if (!inp || !inp.files || !inp.files[0]) return Swal.fire('Erreur','Veuillez choisir un fichier.','warning');
            const fd = new FormData();
            fd.append('_token', csrfToken);
            fd.append('image', inp.files[0]);
            Swal.fire({title:'Envoi image...', allowOutsideClick:false, didOpen: ()=> Swal.showLoading()});
            fetch('{{ route("administration.pages.a-propos.update.image") }}', {
                method: 'POST',
                credentials: 'same-origin',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                body: fd
            }).then(async r => {
                const j = await r.json().catch(()=>null);
                Swal.close();
                if (r.ok && j && j.image) {
                    imagePreview.src = j.image;
                    Swal.fire('Succès','Image enregistrée.','success');
                } else {
                    Swal.fire('Erreur','Enregistrement de l\'image échoué.','error');
                    console.error('Image save response', r.status, j);
                }
            }).catch(err=> { Swal.close(); Swal.fire('Erreur réseau', err.message, 'error'); console.error(err); });
        });
    }

    // Save stats via AJAX
    const btnSaveStats = document.getElementById('btn-save-stats');
    if (btnSaveStats) {
        btnSaveStats.addEventListener('click', function () {
            const fd = new FormData();
            fd.append('_token', csrfToken);
            fd.append('stats_members', document.querySelector('input[name="stats_members"]').value || '');
            fd.append('stats_years', document.querySelector('input[name="stats_years"]').value || '');
            fd.append('stats_regions', document.querySelector('input[name="stats_regions"]').value || '');
            fd.append('stats_trainings', document.querySelector('input[name="stats_trainings"]').value || '');
            Swal.fire({title:'Enregistrement...', allowOutsideClick:false, didOpen: ()=> Swal.showLoading()});
            fetch('{{ route("administration.pages.a-propos.update.stats") }}', {
                method: 'POST',
                credentials: 'same-origin',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                body: fd
            }).then(async r => {
                const j = await r.json().catch(()=>null);
                Swal.close();
                if (r.ok) {
                    Swal.fire('Succès','Statistiques enregistrées.','success');
                } else {
                    Swal.fire('Erreur','Enregistrement des statistiques échoué.','error');
                    console.error('Stats save response', r.status, j);
                }
            }).catch(err=> { Swal.close(); Swal.fire('Erreur réseau', err.message, 'error'); console.error(err); });
        });
    }
});
</script>
@endpush

@endsection
