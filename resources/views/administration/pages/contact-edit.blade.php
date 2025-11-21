@extends('layouts.administration')

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('administration.tableau-de-bord') }}">Tableau de bord</a></li>
        <li class="breadcrumb-item active" aria-current="page">Contact SYNEM</li>
    </ol>
</nav>

<a href="{{ route('administration.tableau-de-bord') }}" class="btn btn-secondary mb-3">
    <i class="fas fa-arrow-left"></i> Retour au tableau de bord
</a>

<div class="container-fluid py-4">
    <h2 class="mb-4">Contact SYNEM</h2>
    {{-- Carousel (images d'en-tête) --}}
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>Carousel - Images d'en-tête</div>
            <div>
                <button class="btn btn-sm btn-primary" id="btnAddCarousel">Ajouter une image</button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-sm" id="carouselTable">
                <thead>
                    <tr>
                        <th></th>
                        <th>#</th>
                        <th>Image</th>
                        <th>Titre</th>
                        <th>Texte</th>
                        <th>Ordre</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($carousels as $c)
                        <tr data-id="{{ $c->id }}">
                            <td><i class="fas fa-grip-vertical drag-handle"></i></td>
                            <td>{{ $c->id }}</td>
                            <td style="width:120px;"><img src="{{ $c->image ? asset('storage/contact/carousel/'.$c->image) : asset('template-admin/assets/images/no-image.png') }}" alt="" class="img-fluid rounded" style="max-height:60px;"></td>
                            <td>{{ $c->title }}</td>
                            <td>{{ Str::limit($c->caption, 80) }}</td>
                            <td>{{ $c->ordering }}</td>
                            <td>
                                <button class="btn btn-sm btn-info btn-edit-carousel" data-id="{{ $c->id }}"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger btn-delete-carousel" data-id="{{ $c->id }}"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Contact Infos (cards like Address / Phone / Email) --}}
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>Coordonnées (Cartes)</div>
            <div>
                <button class="btn btn-sm btn-primary" id="btnAddInfo">Ajouter</button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-sm" id="infosTable">
                <thead>
                    <tr>
                        <th></th>
                        <th>#</th>
                        <th>Type</th>
                        <th>Label</th>
                        <th>Valeur</th>
                        <th>Ordre</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($infos as $i)
                        <tr data-id="{{ $i->id }}" data-type="{{ $i->type }}" data-label="{{ e($i->label) }}" data-value="{{ e($i->value) }}">
                            <td><i class="fas fa-grip-vertical drag-handle"></i></td>
                            <td>{{ $i->id }}</td>
                            <td>{{ $i->type }}</td>
                            <td>{{ $i->label }}</td>
                            <td>{{ Str::limit($i->value, 80) }}</td>
                            <td>{{ $i->ordering }}</td>
                            <td>
                                <button class="btn btn-sm btn-info btn-edit-info" data-id="{{ $i->id }}"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger btn-delete-info" data-id="{{ $i->id }}"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Horaires --}}
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>Horaires</div>
            <div>
                <button class="btn btn-sm btn-primary" id="btnAddHour">Ajouter</button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-sm" id="hoursTable">
                <thead>
                    <tr>
                        <th></th>
                        <th>#</th>
                        <th>Jour</th>
                        <th>Ouverture</th>
                        <th>Fermeture</th>
                        <th>Ferme</th>
                        <th>Ordre</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hours as $h)
                        <tr data-id="{{ $h->id }}" data-day="{{ e($h->day) }}" data-open="{{ e($h->open) }}" data-close="{{ e($h->close) }}" data-closed="{{ $h->closed ? 1 : 0 }}">
                            <td><i class="fas fa-grip-vertical drag-handle"></i></td>
                            <td>{{ $h->id }}</td>
                            <td>{{ $h->day }}</td>
                            <td>{{ $h->open }}</td>
                            <td>{{ $h->close }}</td>
                            <td>{{ $h->closed ? 'Oui' : 'Non' }}</td>
                            <td>{{ $h->ordering }}</td>
                            <td>
                                <button class="btn btn-sm btn-info btn-edit-hour" data-id="{{ $h->id }}"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger btn-delete-hour" data-id="{{ $h->id }}"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- FAQs --}}
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>FAQ</div>
            <div>
                <button class="btn btn-sm btn-primary" id="btnAddFaq">Ajouter</button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-sm" id="faqsTable">
                <thead>
                    <tr>
                        <th></th>
                        <th>#</th>
                        <th>Question</th>
                        <th>Réponse</th>
                        <th>Ordre</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($faqs as $f)
                        <tr data-id="{{ $f->id }}" data-question="{{ e($f->question) }}" data-answer="{{ e($f->answer) }}" data-link="{{ e($f->link ?? '') }}" data-link_type="{{ $f->link_type ?? '' }}">
                            <td><i class="fas fa-grip-vertical drag-handle"></i></td>
                            <td>{{ $f->id }}</td>
                            <td>{{ Str::limit($f->question, 80) }}</td>
                            <td>{{ Str::limit($f->answer, 120) }}</td>
                            <td>{{ $f->ordering }}</td>
                            <td>
                                <button class="btn btn-sm btn-info btn-edit-faq" data-id="{{ $f->id }}"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger btn-delete-faq" data-id="{{ $f->id }}"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Map --}}
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>Carte / Map (iframe)</div>
            <div>
                <button class="btn btn-sm btn-primary" id="btnEditMap">Modifier</button>
            </div>
        </div>
        <div class="card-body">
            <div id="mapPreview">
                @if($map)
                    {!! $map->value !!}
                @else
                    <p>Aucune carte configurée.</p>
                @endif
            </div>
        </div>
    </div>
</div>

@php
$section = session('success_section');
@endphp

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Aperçu image upload
    document.querySelectorAll('input[type="file"][name="image"]').forEach(function(input) {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(ev) {
                    const img = input.closest('.card-body').querySelector('img');
                    if (img) img.src = ev.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    });

    // Reset section après succès
    var section = "{{ $section }}";
    if (section) {
        if (section === 'infos') {
            document.querySelector('textarea[name="contact_infos"]').value = '';
        } else if (section === 'image') {
            document.querySelector('input[name="image"]').value = '';
        } else if (section === 'documents') {
            document.querySelector('input[name="documents[]"]').value = '';
        }
    }
});
</script>
<script>
const baseInfosUrl = "{{ url('administration/pages/contact/infos') }}";
const baseHoursUrl = "{{ url('administration/pages/contact/hours') }}";
const baseFaqsUrl = "{{ url('administration/pages/contact/faqs') }}";
const baseCarouselsUrl = "{{ url('administration/pages/contact/carousels') }}";
const mapUrl = "{{ url('administration/pages/contact/map') }}";
</script>
<script>
// Infos / Hours / FAQ / Map modal-first handlers
(function(){
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Generic helper to create and show a modal from HTML
    function showModal(html) {
        const wrapper = document.createElement('div');
        wrapper.innerHTML = html;
        document.body.appendChild(wrapper);
        const modalEl = wrapper.querySelector('.modal');
        const bs = new bootstrap.Modal(modalEl);
        bs.show();
        modalEl.addEventListener('hidden.bs.modal', function(){ wrapper.remove(); });
        return { wrapper, modalEl, bs };
    }

    // ------- Infos -------
    document.getElementById('btnAddInfo').addEventListener('click', function(){
        const html = `
        <div class="modal fade" id="infoModal" tabindex="-1">
            <div class="modal-dialog">
                <form id="infoForm">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header"><h5 class="modal-title">Ajouter Coordonnée</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
                        <div class="modal-body">
                            <div class="mb-2"><label>Type</label><input name="type" class="form-control"></div>
                            <div class="mb-2"><label>Label</label><input name="label" class="form-control"></div>
                            <div class="mb-2"><label>Valeur</label><input name="value" class="form-control"></div>
                        </div>
                        <div class="modal-footer"><button class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button><button class="btn btn-primary" type="submit">Enregistrer</button></div>
                    </div>
                </form>
            </div>
        </div>`;
        const { modalEl } = showModal(html);
        const form = modalEl.querySelector('#infoForm');
        form.addEventListener('submit', function(e){
            e.preventDefault();
            const fd = new FormData(form);
            fetch(baseInfosUrl, { method: 'POST', headers: {'X-CSRF-TOKEN': token}, body: fd })
            .then(r=> r.ok ? r.json() : r.json().then(t=>Promise.reject(t)))
            .then(()=> { Swal.fire('Succès', 'Coordonnée ajoutée', 'success').then(() => location.reload()); })
            .catch(()=> Swal.fire('Erreur', 'Erreur lors de l\'enregistrement', 'error'));
        });
    });

    document.querySelectorAll('.btn-edit-info').forEach(btn => {
        btn.addEventListener('click', function(){
            const tr = this.closest('tr');
            const id = tr.dataset.id;
            const type = tr.dataset.type || '';
            const label = tr.dataset.label || '';
            const value = tr.dataset.value || '';
            const html = `
            <div class="modal fade" id="infoModalEdit" tabindex="-1">
                <div class="modal-dialog">
                    <form id="infoEditForm">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <div class="modal-content">
                            <div class="modal-header"><h5 class="modal-title">Modifier Coordonnée</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
                            <div class="modal-body">
                                <div class="mb-2"><label>Type</label><input name="type" class="form-control" value="${type}"></div>
                                <div class="mb-2"><label>Label</label><input name="label" class="form-control" value="${label}"></div>
                                <div class="mb-2"><label>Valeur</label><input name="value" class="form-control" value="${value}"></div>
                            </div>
                            <div class="modal-footer"><button class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button><button class="btn btn-primary" type="submit">Enregistrer</button></div>
                        </div>
                    </form>
                </div>
            </div>`;
            const { modalEl } = showModal(html);
            const form = modalEl.querySelector('#infoEditForm');
            form.addEventListener('submit', function(e){
                e.preventDefault();
                const fd = new FormData(form);
                fetch(`${baseInfosUrl}/${id}`, { method: 'POST', headers: {'X-CSRF-TOKEN': token}, body: fd })
                .then(r=> r.ok ? r.json() : r.json().then(t=>Promise.reject(t)))
                .then(()=> { Swal.fire('Succès', 'Coordonnée modifiée', 'success').then(() => location.reload()); })
                .catch(()=> Swal.fire('Erreur', 'Erreur lors de la mise à jour', 'error'));
            });
        });
    });

    document.querySelectorAll('.btn-delete-info').forEach(btn => {
        btn.addEventListener('click', function(){
            const id = this.dataset.id;
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: 'Cette coordonnée sera supprimée définitivement.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`${baseInfosUrl}/${id}`, { method: 'DELETE', headers: {'X-CSRF-TOKEN': token} })
                    .then(r => { if (r.ok) { Swal.fire('Succès', 'Coordonnée supprimée', 'success').then(() => location.reload()); } else { Swal.fire('Erreur', 'Erreur lors de la suppression', 'error'); } });
                }
            });
        });
    });

    // ------- Hours -------
    document.getElementById('btnAddHour').addEventListener('click', function(){
        const html = `
        <div class="modal fade" id="hourModal" tabindex="-1">
            <div class="modal-dialog">
                <form id="hourForm">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header"><h5 class="modal-title">Ajouter Horaire</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
                        <div class="modal-body">
                            <div class="mb-2"><label>Jour</label><input name="day" class="form-control"></div>
                            <div class="mb-2"><label>Ouverture</label><input name="open" class="form-control" placeholder="09:00"></div>
                            <div class="mb-2"><label>Fermeture</label><input name="close" class="form-control" placeholder="17:30"></div>
                            <div class="mb-2"><label>Fermé ?</label><select name="closed" class="form-control"><option value="0">Non</option><option value="1">Oui</option></select></div>
                        </div>
                        <div class="modal-footer"><button class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button><button class="btn btn-primary" type="submit">Enregistrer</button></div>
                    </div>
                </form>
            </div>
        </div>`;
        const { modalEl } = showModal(html);
        const form = modalEl.querySelector('#hourForm');
        form.addEventListener('submit', function(e){
            e.preventDefault();
            const fd = new FormData(form);
            fetch(baseHoursUrl, { method: 'POST', headers: {'X-CSRF-TOKEN': token}, body: fd })
            .then(r=> r.ok ? r.json() : r.json().then(t=>Promise.reject(t)))
            .then(()=> { Swal.fire('Succès', 'Horaire ajouté', 'success').then(() => location.reload()); })
            .catch(()=> Swal.fire('Erreur', 'Erreur lors de l\'enregistrement', 'error'));
        });
    });

    document.querySelectorAll('.btn-edit-hour').forEach(btn=>{
        btn.addEventListener('click', function(){
            const tr = this.closest('tr');
            const id = tr.dataset.id; const day = tr.dataset.day||''; const open = tr.dataset.open||''; const close = tr.dataset.close||''; const closed = tr.dataset.closed||0;
            const html = `
            <div class="modal fade" id="hourEditModal" tabindex="-1">
                <div class="modal-dialog">
                    <form id="hourEditForm">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <div class="modal-content">
                            <div class="modal-header"><h5 class="modal-title">Modifier Horaire</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
                            <div class="modal-body">
                                <div class="mb-2"><label>Jour</label><input name="day" class="form-control" value="${day}"></div>
                                <div class="mb-2"><label>Ouverture</label><input name="open" class="form-control" value="${open}"></div>
                                <div class="mb-2"><label>Fermeture</label><input name="close" class="form-control" value="${close}"></div>
                                <div class="mb-2"><label>Fermé ?</label><select name="closed" class="form-control"><option value="0" ${closed==0? 'selected':''}>Non</option><option value="1" ${closed==1? 'selected':''}>Oui</option></select></div>
                            </div>
                            <div class="modal-footer"><button class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button><button class="btn btn-primary" type="submit">Enregistrer</button></div>
                        </div>
                    </form>
                </div>
            </div>`;
            const { modalEl } = showModal(html);
            const form = modalEl.querySelector('#hourEditForm');
            form.addEventListener('submit', function(e){
                e.preventDefault();
                const fd = new FormData(form);
                fetch(`${baseHoursUrl}/${id}`, { method: 'POST', headers: {'X-CSRF-TOKEN': token}, body: fd })
                .then(r=> r.ok ? r.json() : r.json().then(t=>Promise.reject(t)))
                .then(()=> { Swal.fire('Succès', 'Horaire modifié', 'success').then(() => location.reload()); })
                .catch(()=> Swal.fire('Erreur', 'Erreur lors de la mise à jour', 'error'));
            });
        });
    });

    document.querySelectorAll('.btn-delete-hour').forEach(btn => {
        btn.addEventListener('click', function(){
            const id = this.dataset.id;
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: 'Cet horaire sera supprimé définitivement.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`${baseHoursUrl}/${id}`, { method: 'DELETE', headers: {'X-CSRF-TOKEN': token} })
                    .then(r => { if (r.ok) { Swal.fire('Succès', 'Horaire supprimé', 'success').then(() => location.reload()); } else { Swal.fire('Erreur', 'Erreur lors de la suppression', 'error'); } });
                }
            });
        });
    });

    // ------- FAQ -------
    document.getElementById('btnAddFaq').addEventListener('click', function(){
        const html = `
        <div class="modal fade" id="faqModal" tabindex="-1">
            <div class="modal-dialog">
                <form id="faqForm">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header"><h5 class="modal-title">Ajouter FAQ</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
                        <div class="modal-body">
                            <div class="mb-2"><label>Question</label><input name="question" class="form-control"></div>
                            <div class="mb-2"><label>Réponse</label><textarea name="answer" class="form-control"></textarea></div>
                            <div class="mb-2"><label>Lien (optionnel)</label><input name="link" class="form-control" placeholder="https://..."></div>
                            <div class="mb-2"><label>Type de lien</label><select name="link_type" class="form-control"><option value="">Aucun</option><option value="internal">Interne</option><option value="external">Externe</option></select></div>
                        </div>
                        <div class="modal-footer"><button class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button><button class="btn btn-primary" type="submit">Enregistrer</button></div>
                    </div>
                </form>
            </div>
        </div>`;
        const { modalEl } = showModal(html);
        const form = modalEl.querySelector('#faqForm');
        form.addEventListener('submit', function(e){
            e.preventDefault();
            const fd = new FormData(form);
            fetch(baseFaqsUrl, { method: 'POST', headers: {'X-CSRF-TOKEN': token}, body: fd })
            .then(r=> r.ok ? r.json() : r.json().then(t=>Promise.reject(t)))
            .then(()=> { Swal.fire('Succès', 'FAQ ajoutée', 'success').then(() => location.reload()); })
            .catch(()=> Swal.fire('Erreur', 'Erreur lors de l\'enregistrement', 'error'));
        });
    });

    document.querySelectorAll('.btn-edit-faq').forEach(btn=>{
        btn.addEventListener('click', function(){
            const tr = this.closest('tr');
            const id = tr.dataset.id; const q = tr.dataset.question || ''; const a = tr.dataset.answer || ''; const link = tr.dataset.link || ''; const linkType = tr.dataset.link_type || '';
            const html = `
            <div class="modal fade" id="faqEditModal" tabindex="-1">
                <div class="modal-dialog">
                    <form id="faqEditForm">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <div class="modal-content">
                            <div class="modal-header"><h5 class="modal-title">Modifier FAQ</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
                            <div class="modal-body">
                                <div class="mb-2"><label>Question</label><input name="question" class="form-control" value="${q}"></div>
                                <div class="mb-2"><label>Réponse</label><textarea name="answer" class="form-control">${a}</textarea></div>
                                <div class="mb-2"><label>Lien (optionnel)</label><input name="link" class="form-control" value="${link}" placeholder="https://..."></div>
                                <div class="mb-2"><label>Type de lien</label><select name="link_type" class="form-control"><option value="" ${linkType===''?'selected':''}>Aucun</option><option value="internal" ${linkType==='internal'?'selected':''}>Interne</option><option value="external" ${linkType==='external'?'selected':''}>Externe</option></select></div>
                            </div>
                            <div class="modal-footer"><button class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button><button class="btn btn-primary" type="submit">Enregistrer</button></div>
                        </div>
                    </form>
                </div>
            </div>`;
            const { modalEl } = showModal(html);
            const form = modalEl.querySelector('#faqEditForm');
            form.addEventListener('submit', function(e){
                e.preventDefault();
                const fd = new FormData(form);
                fetch(`${baseFaqsUrl}/${id}`, { method: 'POST', headers: {'X-CSRF-TOKEN': token}, body: fd })
                .then(r=> r.ok ? r.json() : r.json().then(t=>Promise.reject(t)))
                .then(()=> { Swal.fire('Succès', 'FAQ modifiée', 'success').then(() => location.reload()); })
                .catch(()=> Swal.fire('Erreur', 'Erreur lors de la mise à jour', 'error'));
            });
        });
    });

    document.querySelectorAll('.btn-delete-faq').forEach(btn => {
        btn.addEventListener('click', function(){
            const id = this.dataset.id;
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: 'Cette FAQ sera supprimée définitivement.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`${baseFaqsUrl}/${id}`, { method: 'DELETE', headers: {'X-CSRF-TOKEN': token} })
                    .then(r => { if (r.ok) { Swal.fire('Succès', 'FAQ supprimée', 'success').then(() => location.reload()); } else { Swal.fire('Erreur', 'Erreur lors de la suppression', 'error'); } });
                }
            });
        });
    });

    // ------- Map -------
    document.getElementById('btnEditMap').addEventListener('click', function(){
        const current = document.getElementById('mapPreview').innerHTML || '';
        const html = `
        <div class="modal fade" id="mapModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <form id="mapForm">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header"><h5 class="modal-title">Modifier Carte (iframe)</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
                        <div class="modal-body">
                            <div class="mb-2"><label>Iframe / HTML</label><textarea name="value" class="form-control" rows="8">${current.replace(/`/g,'')}</textarea></div>
                        </div>
                        <div class="modal-footer"><button class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button><button class="btn btn-primary" type="submit">Enregistrer</button></div>
                    </div>
                </form>
            </div>
        </div>`;
        const { modalEl } = showModal(html);
        const form = modalEl.querySelector('#mapForm');
        form.addEventListener('submit', function(e){
            e.preventDefault();
            const fd = new FormData(form);
            fetch(mapUrl, { method: 'POST', headers: {'X-CSRF-TOKEN': token}, body: fd })
            .then(r=> r.ok ? r.json() : r.json().then(t=>Promise.reject(t)))
            .then(()=> { Swal.fire('Succès', 'Carte mise à jour', 'success').then(() => location.reload()); })
            .catch(()=> Swal.fire('Erreur', 'Erreur lors de la mise à jour', 'error'));
        });
    });

    // Optional: initialize Sortable for tables if Sortable is loaded
    try {
            if (typeof Sortable !== 'undefined') {
            const reorderPairs = [
                ['carouselTable', "{{ route('administration.pages.contact.carousels.reorder') }}"],
                ['infosTable', "{{ route('administration.pages.contact.infos.reorder') }}"],
                ['hoursTable', "{{ route('administration.pages.contact.hours.reorder') }}"],
                ['faqsTable', "{{ route('administration.pages.contact.faqs.reorder') }}"]
            ];
            reorderPairs.forEach(function(pair){
                const table = document.getElementById(pair[0]);
                if (!table) return;
                const tbody = table.querySelector('tbody');
                Sortable.create(tbody, { handle: '.drag-handle', animation:150, onEnd: function(){
                    const ids = Array.from(tbody.querySelectorAll('tr')).map(tr=>tr.dataset.id);
                    fetch(pair[1], { method: 'POST', headers: {'X-CSRF-TOKEN': token, 'Content-Type':'application/json'}, body: JSON.stringify({ids}) });
                }});
            });
        }
    } catch(e){}

})();
</script>
<script>
// Carousel modal handling
const carouselModalHtml = `
<div class="modal fade" id="carouselModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="carouselForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter / Modifier image du carousel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label>Titre</label>
                        <input name="title" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label>Texte (caption)</label>
                        <textarea name="caption" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-2">
                        <label>Image (JPG/PNG)</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </div>
        </form>
    </div>
</div>`;

document.body.insertAdjacentHTML('beforeend', carouselModalHtml);
const carouselModalEl = document.getElementById('carouselModal');
const carouselModal = new bootstrap.Modal(carouselModalEl);
const carouselForm = document.getElementById('carouselForm');

    document.getElementById('btnAddCarousel').addEventListener('click', function() {
    carouselForm.action = baseCarouselsUrl;
        carouselForm.querySelector('input[name="title"]').value = '';
        carouselForm.querySelector('textarea[name="caption"]').value = '';
        carouselForm.querySelector('input[name="image"]').value = '';
        // remove _method if present
        const methodInput = carouselForm.querySelector('input[name="_method"]');
        if (methodInput) methodInput.remove();
        carouselModal.show();
});

document.querySelectorAll('.btn-edit-carousel').forEach(btn => {
        btn.addEventListener('click', function() {
                const id = this.dataset.id;
                // Fetch item data via admin route
                fetch(`${baseCarouselsUrl}/${id}`)
                        .then(r => r.ok ? r.json() : Promise.reject(r))
                        .then(data => {
                                carouselForm.action = `${baseCarouselsUrl}/${id}`;
                                // add hidden _method=PUT
                                let methodInput = carouselForm.querySelector('input[name="_method"]');
                                if (!methodInput) {
                                        methodInput = document.createElement('input');
                                        methodInput.type = 'hidden';
                                        methodInput.name = '_method';
                                        carouselForm.appendChild(methodInput);
                                }
                                methodInput.value = 'PUT';
                                carouselForm.querySelector('input[name="title"]').value = data.title || '';
                                carouselForm.querySelector('textarea[name="caption"]').value = data.caption || '';
                                carouselModal.show();
                        }).catch(()=>Swal.fire('Erreur', 'Impossible de charger la donnée', 'error'));
        });
});

// Delete handlers
document.querySelectorAll('.btn-delete-carousel').forEach(btn => {
        btn.addEventListener('click', function() {
                const id = this.dataset.id;
                Swal.fire({
                    title: 'Êtes-vous sûr ?',
                    text: 'Cette image du carousel sera supprimée définitivement.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Oui, supprimer',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`${baseCarouselsUrl}/${id}`, {method: 'DELETE', headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')}})
                        .then(r => { if (r.ok) { Swal.fire('Succès', 'Image supprimée', 'success').then(() => location.reload()); } else { Swal.fire('Erreur', 'Erreur lors de la suppression', 'error'); } });
                    }
                });
        });
});
</script>
@endpush

@endsection
