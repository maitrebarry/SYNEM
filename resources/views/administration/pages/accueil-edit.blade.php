@extends('layouts.administration')

@section('title', 'Gestion de la page d\'accueil')

@section('content')
<div class="container">
    <h2 class="mb-4">Édition de la page d'accueil du site</h2>
    <div class="mb-3">
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#compteRenduAdminModal">
            Gérer le Compte Rendu (Dernières Actualités)
        </button>
    </div>
    <form id="homepage-edit-form" method="POST" action="{{ route('administration.pages.accueil.update') }}" enctype="multipart/form-data">
        @csrf
        {{-- Afficher les messages d'erreur / succès pour feedback utilisateur --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- Section Carrousel -->
        <div class="card mb-4">
            <div class="card-header">Carrousel</div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="carousel_title" class="form-label">Titre principal</label>
                    <div class="d-flex">
                        <input type="text" class="form-control me-2" id="carousel_title" name="carousel_title" value="{{ $content->carousel_title ?? '' }}">
                        <button type="button" class="btn btn-outline-secondary btn-edit-field" data-field="carousel_title" data-type="text" data-value="{{ $content->carousel_title ?? '' }}" title="Modifier le titre"><i class="fas fa-edit"></i></button>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="carousel_subtitle" class="form-label">Sous-titre</label>
                    <div class="d-flex">
                        <input type="text" class="form-control me-2" id="carousel_subtitle" name="carousel_subtitle" value="{{ $content->carousel_subtitle ?? '' }}">
                        <button type="button" class="btn btn-outline-secondary btn-edit-field" data-field="carousel_subtitle" data-type="text" data-value="{{ $content->carousel_subtitle ?? '' }}" title="Modifier le sous-titre"><i class="fas fa-edit"></i></button>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Images du carrousel</label>
                    <div id="new-carousel-wrapper">
                        <div class="row new-carousel-row mb-2">
                            <div class="col-md-10 mb-2">
                                <input type="file" class="form-control" name="carousel_images[]" accept="image/*">
                            </div>
                            <div class="col-md-2 mb-2 d-flex align-items-center">
                                <button type="button" class="btn btn-danger btn-sm remove-carousel-row d-none"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="button" id="add-carousel-btn" class="btn btn-outline-primary btn-sm"><i class="fas fa-plus mr-1"></i>Ajouter une image</button>
                        <button type="button" id="preview-carousel-btn" class="btn btn-outline-secondary btn-sm ms-2"><i class="fas fa-eye mr-1"></i>Prévisualiser</button>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Images enregistrées</label>
                        <label for="carousel_table_search" class="visually-hidden">Filtrer les images</label>
                        <input type="text" id="carousel_table_search" name="carousel_table_search" class="form-control mb-2 table-search" data-target="#carousel-table" placeholder="Filtrer les images..." aria-label="Filtrer les images">
                        <div class="table-responsive">
                            <table id="carousel-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Fichier</th>
                                        <th>Aperçu</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($content->carouselImages) && count($content->carouselImages))
                                        @foreach($content->carouselImages as $i => $img)
                                            <tr class="{{ $i >= 5 ? 'd-none extra-row' : '' }}">
                                                <td>{{ $img->file }}</td>
                                                <td>
                                                    <img src="{{ asset('storage/carousel/' . $img->file) }}" alt="Image carrousel" class="img-fluid" style="max-height:60px;">
                                                </td>
                                                <td>
                                                    <form method="POST" action="{{ route('administration.pages.accueil.carousel.delete', $img->id) }}" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Supprimer">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr><td colspan="3" class="text-center text-muted">Aucune image enregistrée</td></tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        @if(isset($content->carouselImages) && count($content->carouselImages) > 5)
                            <div class="mt-2">
                                <button type="button" class="btn btn-sm btn-outline-secondary toggle-more" data-target="#carousel-table">Afficher tout</button>
                            </div>
                        @endif
                    </div>
                    <small class="text-muted">Formats acceptés : JPG, PNG, JPEG, GIF</small>
                </div>
            </div>
        </div>
        <!-- Section À propos -->
        <div class="card mb-4">
            <div class="card-header">Section À propos</div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="about_title" class="form-label">Titre</label>
                    <div class="d-flex">
                        <input type="text" class="form-control me-2" id="about_title" name="about_title" value="{{ $content->about_title ?? '' }}">
                        <button type="button" class="btn btn-outline-secondary btn-edit-field" data-field="about_title" data-type="text" data-value="{{ $content->about_title ?? '' }}" title="Modifier le titre"><i class="fas fa-edit"></i></button>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="about_text" class="form-label">Texte</label>
                    <textarea class="form-control" id="about_text" name="about_text" rows="4">{{ $content->about_text ?? '' }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="about_image" class="form-label">Image</label>
                    <input type="file" class="form-control" id="about_image" name="about_image">
                    @if(!empty($content->about_image))
                        <img src="{{ asset('storage/' . $content->about_image) }}" alt="Image à propos" class="img-fluid mt-2" style="max-height:120px;">
                    @endif
                </div>
            </div>
        </div>
        <!-- Section Actualités -->
        <div class="card mb-4">
            <div class="card-header">Actualités</div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="news_title" class="form-label">Titre section</label>
                    <div class="d-flex">
                        <input type="text" class="form-control me-2" id="news_title" name="news_title" value="{{ $content->news_title ?? '' }}">
                        <button type="button" class="btn btn-outline-secondary btn-edit-field" data-field="news_title" data-type="text" data-value="{{ $content->news_title ?? '' }}" title="Modifier le titre de la section"><i class="fas fa-edit"></i></button>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="news_items" class="form-label">Actualités (séparées par un saut de ligne)</label>
                    <textarea class="form-control" id="news_items" name="news_items" rows="4">{{ $content->news_items ?? '' }}</textarea>
                </div>
            </div>
        </div>
        {{-- Compte Rendu is managed separately via its modal (see below) --}}
        <!-- Section Documents -->
        <div class="card mb-4">
            <div class="card-header">Documents administratifs</div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="documents_title" class="form-label">Titre section</label>
                    <div class="d-flex">
                        <input type="text" class="form-control me-2" id="documents_title" name="documents_title" value="{{ $content->documents_title ?? '' }}">
                        <button type="button" class="btn btn-outline-secondary btn-edit-field" data-field="documents_title" data-type="text" data-value="{{ $content->documents_title ?? '' }}" title="Modifier le titre des documents"><i class="fas fa-edit"></i></button>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Documents existants</label>
                    <div class="table-responsive">
                        <label for="documents_table_search" class="visually-hidden">Filtrer les documents</label>
                        <input type="text" id="documents_table_search" name="documents_table_search" class="form-control mb-2 table-search" data-target="#documents-table" placeholder="Filtrer les documents..." aria-label="Filtrer les documents">
                        <table id="documents-table" class="table table-bordered">
                                @if(isset($content->documents) && count($content->documents))
                                    @foreach($content->documents as $i => $doc)
                                        <tr class="{{ $i >= 5 ? 'd-none extra-row' : '' }}">
                                            <td>{{ $doc->title }}</td>
                                            <!-- <td>{{ strtoupper(pathinfo($doc->file, PATHINFO_EXTENSION)) }}</td> -->
                                            <td>
                                                <a href="{{ asset('storage/documents/' . $doc->file) }}" target="_blank">{{ $doc->file }}</a>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-secondary btn-edit-doc" data-id="{{ $doc->id }}" data-title="{{ e($doc->title) }}" data-type="{{ e($doc->type) }}" title="Modifier">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form method="POST" action="{{ route('administration.pages.accueil.document.delete', $doc->id) }}" style="display:inline;" class="d-inline-block ms-1 confirm-delete">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Supprimer">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                            @endforeach
                                @else
                                    <tr><td colspan="4" class="text-center text-muted">Aucun document enregistré</td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    @if(isset($content->documents) && count($content->documents) > 5)
                        <div class="mt-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary toggle-more" data-target="#documents-table">Afficher tout</button>
                        </div>
                    @endif
                </div>
                <!-- Modal for editing a document -->
                <div class="modal fade" id="editDocumentModal" tabindex="-1" aria-labelledby="editDocumentModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form id="editDocumentForm" method="POST" action="" class="p-0">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editDocumentModalLabel">Modifier le document</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="edit_doc_title" class="form-label">Titre</label>
                                        <input type="text" id="edit_doc_title" name="title" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_doc_type" class="form-label">Type</label>
                                        <select id="edit_doc_type" name="type" class="form-control">
                                            <option value="pdf">PDF</option>
                                            <option value="word">Word</option>
                                            <option value="excel">Excel</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Generic modal to edit any field in the form -->
                <div class="modal fade" id="editFieldModal" tabindex="-1" aria-labelledby="editFieldModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form id="editFieldForm" method="POST" action="#">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editFieldModalLabel">Modifier le texte</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="_target_field" value="">
                                    <input type="text" id="edit_field_text" name="edit_field_text" class="form-control">
                                    <textarea id="edit_field_textarea" name="edit_field_textarea" class="form-control d-none" rows="5"></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="mb-3 border p-3 rounded">
                    <label class="form-label">Ajouter des documents</label>
                    <div id="new-documents-wrapper">
                        @php
                            $old_titles = old('new_document_title', []);
                            $old_types = old('new_document_type', []);
                            $rows = max(1, max(count($old_titles), count($old_types)));
                        @endphp
                        @for($i = 0; $i < $rows; $i++)
                            <div class="row new-document-row mb-2">
                                <div class="col-md-4 mb-2">
                                    <input type="text" class="form-control" name="new_document_title[]" placeholder="Titre du document" value="{{ $old_titles[$i] ?? '' }}">
                                </div>
                                <div class="col-md-3 mb-2">
                                    <select class="form-control" name="new_document_type[]">
                                        <option value="pdf" {{ (isset($old_types[$i]) && $old_types[$i] === 'pdf') ? 'selected' : '' }}>PDF</option>
                                        <option value="word" {{ (isset($old_types[$i]) && $old_types[$i] === 'word') ? 'selected' : '' }}>Word</option>
                                        <option value="excel" {{ (isset($old_types[$i]) && $old_types[$i] === 'excel') ? 'selected' : '' }}>Excel</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <input type="file" class="form-control" name="new_document_file[]" accept=".pdf,.doc,.docx,.xls,.xlsx">
                                </div>
                                <div class="col-md-1 mb-2 d-flex align-items-center">
                                    <button type="button" class="btn btn-danger btn-sm remove-doc-row {{ $i > 0 ? '' : 'd-none' }}"><i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                        @endfor
                    </div>
                    <div class="mt-2">
                        <button type="button" id="add-document-btn" class="btn btn-outline-primary btn-sm"><i class="fas fa-plus mr-1"></i>Ajouter un champ</button>
                    </div>
                    <small class="text-muted d-block mt-2">Formats acceptés : PDF, Word (.doc/.docx), Excel (.xls/.xlsx). Cliquez sur + pour ajouter plusieurs fichiers.</small>
                </div>
            </div>
        </div>
        <!-- Modal pour aperçu des images sélectionnées -->
        <div class="modal fade" id="carouselPreviewModal" tabindex="-1" aria-labelledby="carouselPreviewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="carouselPreviewModalLabel">Aperçu des images sélectionnées</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row" id="carousel-preview-list"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
    </form>
</div>
<!-- Compte Rendu Admin Modal (separate form, not nested) -->
<div class="modal fade" id="compteRenduAdminModal" tabindex="-1" aria-labelledby="compteRenduAdminLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('administration.pages.accueil.compte_rendu.update') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="compteRenduAdminLabel">Gérer le Compte Rendu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="cr_title" class="form-label">Titre</label>
                        <input type="text" id="cr_title" name="compte_rendu_title" class="form-control" value="{{ $content->compte_rendu_title ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label for="cr_content" class="form-label">Contenu</label>
                        <textarea id="cr_content" name="compte_rendu_content" class="form-control" rows="6">{{ $content->compte_rendu_content ?? '' }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ajouter des images</label>
                        <input type="file" class="form-control" name="compte_rendu_images[]" accept="image/*" multiple>
                        <small class="text-muted">Optionnel — vous pouvez ajouter plusieurs images.</small>
                    </div>
                    @php
                        $crImages = [];
                        if (!empty($content->compte_rendu_images)) {
                            $crImages = is_array($content->compte_rendu_images)
                                ? $content->compte_rendu_images
                                : (json_decode($content->compte_rendu_images, true) ?: []);
                        }
                    @endphp
                    @if(count($crImages))
                        <div class="mb-3">
                            <label class="form-label">Images existantes</label>
                            <div class="row">
                                @foreach($crImages as $file)
                                    <div class="col-md-4 mb-2">
                                        <div class="card">
                                            <img src="{{ asset('storage/compte_rendu/' . $file) }}" class="card-img-top" style="height:120px;object-fit:cover;" alt="{{ $file }}">
                                            <div class="card-body p-2 text-center">
                                                <form method="POST" action="{{ route('administration.pages.accueil.compte_rendu.update') }}">
                                                    @csrf
                                                    <input type="hidden" name="delete_image" value="{{ $file }}">
                                                    <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addBtn = document.getElementById('add-document-btn');
        const wrapper = document.getElementById('new-documents-wrapper');

        addBtn && addBtn.addEventListener('click', function() {
            const row = document.querySelector('.new-document-row');
            if (!row) return;
            const clone = row.cloneNode(true);
            // show remove button on clones (remove d-none class)
            const removeBtn = clone.querySelector('.remove-doc-row');
            if (removeBtn) removeBtn.classList.remove('d-none');
            // clear inputs (file inputs cleared by setting value to empty string)
            clone.querySelectorAll('input').forEach(i => { if(i.type !== 'file') i.value = ''; else i.value = ''; });
            clone.querySelectorAll('select').forEach(s => s.selectedIndex = 0);
            wrapper.appendChild(clone);
        });

        // delegated remove
        wrapper.addEventListener('click', function(e) {
            if (e.target.closest('.remove-doc-row')) {
                const row = e.target.closest('.new-document-row');
                if (row) row.remove();
            }
        });

        // Carousel add-row and preview
        const carouselWrapper = document.getElementById('new-carousel-wrapper');
        const addCarouselBtn = document.getElementById('add-carousel-btn');
        const previewCarouselBtn = document.getElementById('preview-carousel-btn');
        const previewList = document.getElementById('carousel-preview-list');
        const previewModalEl = document.getElementById('carouselPreviewModal');
        let previewModal = null;
        if (previewModalEl) previewModal = new bootstrap.Modal(previewModalEl);

        if (addCarouselBtn && carouselWrapper) {
            addCarouselBtn.addEventListener('click', function(){
                const row = document.querySelector('.new-carousel-row');
                if(!row) return;
                const clone = row.cloneNode(true);
                const removeBtn = clone.querySelector('.remove-carousel-row');
                if(removeBtn) removeBtn.classList.remove('d-none');
                // clear file
                clone.querySelectorAll('input').forEach(i => { if(i.type === 'file') i.value = ''; else i.value = ''; });
                carouselWrapper.appendChild(clone);
            });

            // delegated remove for carousel rows
            carouselWrapper.addEventListener('click', function(e){
                if(e.target.closest('.remove-carousel-row')){
                    const row = e.target.closest('.new-carousel-row');
                    if(row) row.remove();
                }
            });
        }

        function collectCarouselFiles(){
            const inputs = Array.from(document.querySelectorAll('input[name="carousel_images[]"]'));
            let entries = [];
            inputs.forEach(function(inp, inpIndex){
                if(inp.files && inp.files.length){
                    Array.from(inp.files).forEach(function(f, fileIndex){
                        entries.push({ file: f, input: inp, inputIndex: inpIndex, fileIndex: fileIndex });
                    });
                }
            });
            return entries;
        }

        function showCarouselPreview(entries){
            previewList.innerHTML = '';
            entries.forEach(function(entry, idx){
                const f = entry.file;
                if(!f.type.startsWith('image/')) return;
                const url = URL.createObjectURL(f);
                const col = document.createElement('div');
                col.className = 'col-md-3 mb-3 text-center carousel-preview-item';
                col.innerHTML = `
                    <div class="card">
                        <img src="${url}" class="card-img-top" style="max-height:160px;object-fit:contain;">
                        <div class="card-body p-2 d-flex justify-content-between align-items-center">
                            <p class="card-text small text-truncate mb-0" style="max-width:80%">${f.name}</p>
                            <button type="button" class="btn btn-sm btn-outline-danger btn-remove-preview" data-input-idx="${entry.inputIndex}">Supprimer</button>
                        </div>
                    </div>
                `;
                // attach cleanup info
                col.querySelector('.btn-remove-preview').addEventListener('click', function(){
                    // clear the corresponding input value to exclude the file
                    try{
                        entry.input.value = '';
                    }catch(e){}
                    // remove this preview card
                    if(col.parentNode) col.parentNode.removeChild(col);
                    // revoke URL
                    if(url && url.startsWith('blob:')) URL.revokeObjectURL(url);
                });
                previewList.appendChild(col);
            });
            if(previewModal) previewModal.show();
        }

        // preview button
        if(previewCarouselBtn){
            previewCarouselBtn.addEventListener('click', function(){
                const files = collectCarouselFiles();
                if(files.length === 0) return alert('Aucune image sélectionnée pour la prévisualisation.');
                showCarouselPreview(files);
            });
        }

        // revoke object URLs on modal hide
        if(previewModalEl) {
            previewModalEl.addEventListener('hidden.bs.modal', function(){
                previewList.querySelectorAll('img').forEach(function(img){ if(img.src.startsWith('blob:')) URL.revokeObjectURL(img.src); });
                previewList.innerHTML = '';
            });
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function(){
        // Table search/filter for tables with .table-search inputs
        document.querySelectorAll('.table-search').forEach(function(input){
            const targetSelector = input.getAttribute('data-target');
            const table = document.querySelector(targetSelector);
            if(!table) return;
            input.addEventListener('input', function(){
                const q = input.value.trim().toLowerCase();
                table.querySelectorAll('tbody tr').forEach(function(row){
                    const text = row.textContent.trim().toLowerCase();
                    if(text.indexOf(q) !== -1) {
                        row.classList.remove('d-none');
                    } else {
                        // keep extra-row state (only hide if not matching)
                        if(row.classList.contains('extra-row')) row.classList.add('d-none'); else row.classList.add('d-none');
                    }
                });
            });
        });

        // Toggle 'Afficher tout' buttons
        document.querySelectorAll('.toggle-more').forEach(function(btn){
            btn.addEventListener('click', function(){
                const targetSelector = btn.getAttribute('data-target');
                const table = document.querySelector(targetSelector);
                if(!table) return;
                const extras = table.querySelectorAll('tbody tr.extra-row');
                let anyHidden = false;
                extras.forEach(function(r){ if(r.classList.contains('d-none')) anyHidden = true; });
                if(anyHidden) {
                    extras.forEach(function(r){ r.classList.remove('d-none'); });
                    btn.textContent = 'Réduire';
                } else {
                    extras.forEach(function(r){ r.classList.add('d-none'); });
                    btn.textContent = 'Afficher tout';
                }
            });
        });

        // SweetAlert confirm for delete forms
        document.querySelectorAll('form.confirm-delete').forEach(function(form){
            form.addEventListener('submit', function(e){
                e.preventDefault();
                const submitForm = form;
                Swal.fire({
                    title: 'Confirmer la suppression',
                    text: 'Voulez-vous vraiment supprimer cet élément ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui, supprimer',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if(result.isConfirmed){
                        submitForm.submit();
                    }
                });
            });
        });

        // Edit document modal
        const editModalEl = document.getElementById('editDocumentModal');
        let editModal = null;
        if(editModalEl) editModal = new bootstrap.Modal(editModalEl);
        document.querySelectorAll('.btn-edit-doc').forEach(function(btn){
            btn.addEventListener('click', function(){
                const id = btn.getAttribute('data-id');
                const title = btn.getAttribute('data-title');
                const type = btn.getAttribute('data-type');
                const form = document.getElementById('editDocumentForm');
                form.action = '{{ route("administration.pages.accueil.document.update", "__ID__") }}'.replace('__ID__', id);
                document.getElementById('edit_doc_title').value = title;
                document.getElementById('edit_doc_type').value = type;
                if(editModal) editModal.show();
            });
        });

        // Generic field edit modal wiring
        const editFieldModalEl = document.getElementById('editFieldModal');
        let editFieldModal = null;
        if(editFieldModalEl) editFieldModal = new bootstrap.Modal(editFieldModalEl);
        document.querySelectorAll('.btn-edit-field').forEach(function(btn){
            btn.addEventListener('click', function(){
                const field = btn.getAttribute('data-field');
                const type = btn.getAttribute('data-type') || 'text';
                const value = btn.getAttribute('data-value') || '';
                const targetInput = document.querySelector('[name="' + field + '"]');
                if(!editFieldModalEl) return;
                // set hidden target
                editFieldModalEl.querySelector('input[name="_target_field"]').value = field;
                // choose control
                const textControl = editFieldModalEl.querySelector('#edit_field_text');
                const textareaControl = editFieldModalEl.querySelector('#edit_field_textarea');
                if(type === 'textarea'){
                    textControl.classList.add('d-none');
                    textareaControl.classList.remove('d-none');
                    textareaControl.value = targetInput ? targetInput.value : value;
                } else {
                    textareaControl.classList.add('d-none');
                    textControl.classList.remove('d-none');
                    textControl.value = targetInput ? targetInput.value : value;
                }
                if(editFieldModal) editFieldModal.show();
            });
        });

        // submit from field modal: write back to target input
        const editFieldForm = document.getElementById('editFieldForm');
        if(editFieldForm){
            editFieldForm.addEventListener('submit', function(e){
                e.preventDefault();
                const target = editFieldForm.querySelector('input[name="_target_field"]').value;
                const textVal = editFieldForm.querySelector('#edit_field_text').value;
                const textareaVal = editFieldForm.querySelector('#edit_field_textarea').value;
                const targetInput = document.querySelector('[name="' + target + '"]');
                if(!targetInput) return;
                if(!editFieldForm.querySelector('#edit_field_text').classList.contains('d-none')){
                    targetInput.value = textVal;
                } else {
                    targetInput.value = textareaVal;
                }
                if(editFieldModal) editFieldModal.hide();
            });
        }
    });
</script>
<script>
    // Prevent submitting extremely large payloads and show loading state
    (function(){
        const form = document.getElementById('homepage-edit-form');
        if(!form) return;
        const submitBtn = form.querySelector('button[type="submit"]');
        const MAX_TOTAL_BYTES = 50 * 1024 * 1024; // 50 MB default
        const MAX_FILES = 50; // max total files

        form.addEventListener('submit', function(e){
            // collect all file inputs
            let totalFiles = 0;
            let totalBytes = 0;
            form.querySelectorAll('input[type="file"]').forEach(function(inp){
                Array.from(inp.files || []).forEach(function(f){
                    totalFiles++;
                    totalBytes += (f.size || 0);
                });
            });

            if(totalFiles > MAX_FILES || totalBytes > MAX_TOTAL_BYTES){
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Taille trop importante',
                    html: 'Vous avez sélectionné <b>' + totalFiles + '</b> fichiers (total ' + Math.round(totalBytes/1024/1024) + ' Mo).<br>Limite : ' + MAX_FILES + ' fichiers ou ' + (MAX_TOTAL_BYTES/1024/1024) + ' Mo.',
                });
                return false;
            }

            // disable button to indicate working
            if(submitBtn){
                submitBtn.disabled = true;
                const originalHtml = submitBtn.innerHTML;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enregistrement...';
                // re-enable after 30s as fallback
                setTimeout(function(){ try{ submitBtn.disabled = false; submitBtn.innerHTML = originalHtml; }catch(e){} }, 30000);
            }
        });
    })();
</script>
@endsection
