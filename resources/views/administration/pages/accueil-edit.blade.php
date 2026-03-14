@extends('layouts.administration')

@section('title', 'Gestion de la page d\'accueil')

@section('content')
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Page d'accueil</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('administration.tableau-de-bord') }}"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Édition Page d'accueil</li>
            </ol>
        </nav>
    </div>
    <div class="ms-auto">
        <div class="btn-group">
            <a href="{{ route('administration.tableau-de-bord') }}" class="btn btn-primary">Retour au tableau de bord</a>
        </div>
    </div>
</div>
<hr />
<div class="container-fluid py-4">
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
            <div id="server-success-alert" class="alert alert-success">{{ session('success') }}</div>
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
            <div class="card-header">Carrousel
                <button type="button" class="btn btn-sm btn-primary ms-2" data-mode="add" data-bs-toggle="modal" data-bs-target="#modalSectionCarousel">Ajouter</button>
                <button type="button" class="btn btn-sm btn-outline-secondary ms-2 btn-open-section-modal" data-section="carousel">Modifier</button>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Titre principal</label>
                    <div class="p-2 bg-light rounded" data-field="carousel_title">{{ $content->carousel_title ?? '—' }}</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Sous-titre</label>
                    <div class="p-2 bg-light rounded" data-field="carousel_subtitle">{{ $content->carousel_subtitle ?? '—' }}</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Images du carrousel</label>
                    <p class="small text-muted">Gérez les images et la prévisualisation via le modal "Modifier" en haut de cette section.</p>
                    <div class="mb-3">
                        <label class="form-label">Images enregistrées</label>
                        <label for="carousel_table_search" class="visually-hidden">Filtrer les images</label>
                        <input type="text" id="carousel_table_search" name="carousel_table_search" class="form-control mb-2 table-search" data-target="#carousel-table" placeholder="Filtrer les images..." aria-label="Filtrer les images">
                        <div class="table-responsive">
                            <table id="carousel-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Fichier</th>
                                        <th>Titre</th>
                                        <th>Texte</th>
                                        <th>Aperçu</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($content->carouselImages) && count($content->carouselImages))
                                        @foreach($content->carouselImages as $i => $img)
                                            <tr class="{{ $i >= 5 ? 'd-none extra-row' : '' }}">
                                                <td>{{ $img->file }}</td>
                                                <td data-carousel-title>{{ $img->title ?? '—' }}</td>
                                                <td data-carousel-text>{{ \Illuminate\Support\Str::limit($img->text ?? '', 80) ?: '—' }}</td>
                                                <td>
                                                    <img src="{{ asset('storage/carousel/' . $img->file) }}" alt="Image carrousel" class="img-fluid" style="max-height:60px;">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary btn-edit-carousel" data-id="{{ $img->id }}" data-title="{{ e($img->title) }}" data-text="{{ e($img->text) }}" title="Modifier">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form method="POST" action="{{ route('administration.pages.accueil.carousel.delete', $img->id) }}" style="display:inline;" class="d-inline-block ms-1">
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
        <!-- Section À propos retirée (gérée ailleurs) -->
        <!-- Section Services (Nos Domaines d'Intervention) -->
        <div class="card mb-4">
            <div class="card-header">Nos Domaines d'Intervention
                <button type="button" class="btn btn-sm btn-primary ms-2" data-mode="add" data-bs-toggle="modal" data-bs-target="#modalSectionServices">Ajouter</button>
                <button type="button" class="btn btn-sm btn-outline-secondary ms-2 btn-open-section-modal" data-section="services">Modifier</button>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Titre</label>
                    <div class="p-2 bg-light rounded" data-field="services_title">{{ $content->services_title ?? '—' }}</div>
                </div>
                <div class="mb-3">
                    <p class="small text-muted">Les éléments affichés sur le site (trois blocs). Gérer via le modal "Modifier".</p>
                    <div class="row">
                        @php
                            $services = [];
                            if (!empty($content->services_items)) {
                                $services = is_array($content->services_items) ? $content->services_items : (json_decode($content->services_items, true) ?: []);
                            }
                        @endphp
                        @for($i = 0; $i < 3; $i++)
                            <div class="col-md-4 mb-3">
                                <div class="p-3 border rounded h-100 position-relative">
                                    <button type="button" class="btn btn-sm btn-outline-danger position-absolute" style="top:8px;right:8px;" data-service-index="{{ $i }}" title="Supprimer"><i class="fas fa-trash"></i></button>
                                    <h5 class="mb-2" data-field="service_title" data-index="{{ $i }}">{{ $services[$i]['title'] ?? 'Titre ' . ($i+1) }}</h5>
                                    <p class="mb-0 text-muted small" data-field="service_text" data-index="{{ $i }}">{{ $services[$i]['text'] ?? 'Description ...' }}</p>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
        <!-- Section Actualités -->
        <div class="card mb-4">
            <div class="card-header">Actualités
                <button type="button" class="btn btn-sm btn-primary ms-2" data-mode="add" data-bs-toggle="modal" data-bs-target="#modalSectionNews">Ajouter</button>
                <button type="button" class="btn btn-sm btn-outline-secondary ms-2 btn-open-section-modal" data-section="news">Modifier</button>
            </div>
            <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Titre de la section</label>
                        <div class="p-2 bg-light rounded">{{ $content->news_title ?? '—' }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Actualités</label>
                        <div class="p-2 bg-light rounded">
                            @php
                                $items = collect(explode("\n", trim((string)($content->news_items ?? ''))))->map(fn($v)=>trim($v))->filter()->values();
                            @endphp
                            @if($items->isEmpty())
                                <div class="text-muted">Aucune actualité enregistrée</div>
                            @else
                                <ul class="mb-0">
                                            @foreach($items as $idx => $it)
                                                <li data-news-index="{{ $idx }}" data-news-text="{{ e($it) }}">{{ $it }} <button type="button" class="btn btn-sm btn-link text-danger btn-delete-news" data-news-index="{{ $idx }}" title="Supprimer"><i class="fas fa-trash"></i></button></li>
                                            @endforeach
                                </ul>
                            @endif
                        </div>
                        <p class="small text-muted mt-2">Modifier les actualités via le modal.</p>
                    </div>
            </div>
        </div>
        {{-- Compte Rendu is managed separately via its modal (see below) --}}
        <!-- Section Documents -->
        <div class="card mb-4">
            <div class="card-header">Documents administratifs
                <button type="button" class="btn btn-sm btn-primary ms-2" id="btnAddDocument" data-bs-toggle="modal" data-bs-target="#modalSectionDocuments">Ajouter</button>
                <button type="button" class="btn btn-sm btn-outline-secondary ms-2 btn-open-section-modal" data-section="documents">Modifier</button>
            </div>
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
                <div class="mb-3">
                    <p class="small text-muted">Utilisez le bouton <strong>Ajouter</strong> dans l'en-tête de la section pour ouvrir le modal et ajouter / gérer les documents.</p>
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

                    <!-- Documents Edit Modal -->
                    <div class="modal fade" id="modalSectionDocuments" tabindex="-1" aria-labelledby="modalSectionDocumentsLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <form id="modalDocumentsForm" action="{{ route('administration.pages.accueil.update.documents') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="_section" value="documents">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalSectionDocumentsLabel">Gérer les documents administratifs</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div id="modal-documents-wrapper">
                                            @php
                                                $old_titles = old('new_document_title', []);
                                                $old_types = old('new_document_type', []);
                                                $rows = max(1, max(count($old_titles), count($old_types)));
                                            @endphp
                                            @for($i = 0; $i < $rows; $i++)
                                                <div class="row modal-new-document-row mb-2">
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
                                                        <button type="button" class="btn btn-danger btn-sm remove-modal-doc-row {{ $i > 0 ? '' : 'd-none' }}"><i class="fas fa-minus"></i></button>
                                                    </div>
                                                </div>
                                            @endfor
                                        </div>
                                        <div class="mt-2">
                                            <button type="button" id="modal-add-document-btn" class="btn btn-outline-primary btn-sm"><i class="fas fa-plus mr-1"></i>Ajouter un champ</button>
                                            <small class="text-muted d-block mt-2">Formats acceptés : PDF, Word (.doc/.docx), Excel (.xls/.xlsx).</small>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        <button type="button" id="modalDocumentsSave" class="btn btn-primary">Enregistrer</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
        <!-- global submit removed; sections saved via their modals -->
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
<!-- Section Modals: Carousel / About / News -->
<!-- Carousel Edit Modal -->
<div class="modal fade" id="modalSectionCarousel" tabindex="-1" aria-labelledby="modalSectionCarouselLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="modalCarouselForm" action="{{ route('administration.pages.accueil.update.carousel') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_section" value="carousel">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSectionCarouselLabel">Modifier Carrousel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Titre principal</label>
                        <input type="text" name="carousel_title" class="form-control" value="{{ $content->carousel_title ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sous-titre</label>
                        <input type="text" name="carousel_subtitle" class="form-control" value="{{ $content->carousel_subtitle ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ajouter des images</label>
                        <div id="modal-carousel-wrapper">
                            <div class="row modal-new-carousel-row mb-2">
                                <div class="col-md-10 mb-2">
                                    <input type="file" class="form-control" name="carousel_images[]" accept="image/*">
                                    <input type="text" class="form-control mt-2" name="carousel_image_title[]" placeholder="Titre de l'image (optionnel)">
                                    <textarea class="form-control mt-2" name="carousel_image_text[]" placeholder="Texte / légende (optionnel)" rows="2"></textarea>
                                </div>
                                <div class="col-md-2 mb-2 d-flex align-items-center">
                                    <button type="button" class="btn btn-danger btn-sm remove-modal-carousel-row d-none"><i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="button" id="modal-add-carousel-btn" class="btn btn-outline-primary btn-sm"><i class="fas fa-plus mr-1"></i>Ajouter une image</button>
                            <button type="button" id="modal-preview-carousel-btn" class="btn btn-outline-secondary btn-sm ms-2"><i class="fas fa-eye mr-1"></i>Prévisualiser</button>
                        </div>
                        <small class="text-muted d-block mt-2">Vous pouvez ajouter plusieurs images puis prévisualiser avant d'enregistrer.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" id="modalCarouselSave" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit carousel image metadata modal -->
<div class="modal fade" id="editCarouselImageModal" tabindex="-1" aria-labelledby="editCarouselImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editCarouselImageForm" method="POST" action="" class="p-0">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editCarouselImageModalLabel">Modifier l'image du carrousel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_carousel_title" class="form-label">Titre</label>
                        <input type="text" id="edit_carousel_title" name="title" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="edit_carousel_text" class="form-label">Texte</label>
                        <textarea id="edit_carousel_text" name="text" class="form-control" rows="4"></textarea>
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

<!-- About modal removed (managed in a-propos admin) -->

<!-- News Edit Modal -->
<div class="modal fade" id="modalSectionNews" tabindex="-1" aria-labelledby="modalSectionNewsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="modalNewsForm" action="{{ route('administration.pages.accueil.update.news') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_section" value="news">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSectionNewsLabel">Modifier Actualités</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Titre de la section</label>
                        <input type="text" name="news_title" class="form-control" value="{{ $content->news_title ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Actualités (séparées par un saut de ligne)</label>
                        <textarea name="news_items" class="form-control" rows="6">{{ $content->news_items ?? '' }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Images pour les actualités (optionnel)</label>
                        <input type="file" name="news_images[]" class="form-control" accept="image/*" multiple>
                        <small class="text-muted d-block">Vous pouvez joindre des images associées aux actualités.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" id="modalNewsSave" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Services Edit Modal -->
<div class="modal fade" id="modalSectionServices" tabindex="-1" aria-labelledby="modalSectionServicesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="modalServicesForm" action="{{ route('administration.pages.accueil.update.services') }}" method="POST">
                @csrf
                <input type="hidden" name="_section" value="services">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSectionServicesLabel">Modifier Nos Domaines d'Intervention</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Titre de la section</label>
                        <input type="text" name="services_title" class="form-control" value="{{ $content->services_title ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Éléments (3 blocs)</label>
                        @php
                            $services = [];
                            if (!empty($content->services_items)) {
                                $services = is_array($content->services_items) ? $content->services_items : (json_decode($content->services_items, true) ?: []);
                            }
                        @endphp
                        @for($i = 0; $i < 3; $i++)
                            <div class="mb-2 border rounded p-2">
                                <div class="mb-2">
                                    <label class="form-label">Titre #{{ $i+1 }}</label>
                                    <input type="text" name="service_title[]" class="form-control" value="{{ $services[$i]['title'] ?? '' }}">
                                </div>
                                <div>
                                    <label class="form-label">Texte #{{ $i+1 }}</label>
                                    <textarea name="service_text[]" class="form-control" rows="2">{{ $services[$i]['text'] ?? '' }}</textarea>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" id="modalServicesSave" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Section modal open/save handlers (Carousel / About / News)
    document.addEventListener('DOMContentLoaded', function(){
        // routes for section-specific update endpoints (normalize to same-origin relative paths if needed)
        const adminRoutes = {
            carousel: '{{ route("administration.pages.accueil.update.carousel") }}',
            about: '{{ route("administration.pages.accueil.update.about") }}',
            news: '{{ route("administration.pages.accueil.update.news") }}',
            documents: '{{ route("administration.pages.accueil.update.documents") }}',
            services: '{{ route("administration.pages.accueil.update.services") }}'
        };

        // If the generated route() returns an absolute URL pointing to a different origin (port),
        // convert it to a same-origin relative path so fetch sends cookies and uses the current host.
        (function normalizeAdminRoutes(){
            function toRelative(u){
                try{
                    const parsed = new URL(u, window.location.href);
                    if(parsed.origin !== window.location.origin){
                        return parsed.pathname + parsed.search + parsed.hash;
                    }
                }catch(e){ /* ignore, return as-is */ }
                return u;
            }
            for(const k in adminRoutes){
                if(Object.prototype.hasOwnProperty.call(adminRoutes, k)){
                    adminRoutes[k] = toRelative(adminRoutes[k]);
                }
            }
            // base for updating a single carousel image metadata (we'll append /{id})
            adminRoutes.carouselImageBase = '{{ url("administration/pages/accueil/carousel") }}';
            console.info('adminRoutes normalized', adminRoutes);
        })();

        // If we reloaded after a successful AJAX save we may have set a flag to
        // suppress the server-side session success alert (to avoid duplicate messages).
        try{
            if(window.localStorage && localStorage.getItem && localStorage.getItem('suppress_server_success')){
                const alertEl = document.getElementById('server-success-alert');
                if(alertEl) alertEl.remove();
                localStorage.removeItem('suppress_server_success');
            }
        }catch(e){ /* ignore */ }

        const sectionButtons = document.querySelectorAll('.btn-open-section-modal');
        const mainForm = document.getElementById('homepage-edit-form');
        const mainAction = mainForm ? mainForm.getAttribute('action') : null;

        // helper: get CSRF token from meta or form
        function getCsrfToken(){
            const meta = document.querySelector('meta[name="csrf-token"]');
            if(meta) return meta.getAttribute('content');
            const tokenInput = document.querySelector('input[name="_token"]');
            return tokenInput ? tokenInput.value : '';
        }

        sectionButtons && sectionButtons.forEach(function(btn){
            btn.addEventListener('click', function(){
                const section = btn.getAttribute('data-section');
                if(!section) return;
                // populate modal form values from displayed card before showing
                const card = btn.closest('.card');
                const modalId = {
                    'carousel': 'modalSectionCarousel',
                    'about': 'modalSectionAbout',
                    'news': 'modalSectionNews',
                    'documents': 'modalSectionDocuments',
                    'services': 'modalSectionServices'
                }[section];
                const el = document.getElementById(modalId);
                if(!el) return;
                // set modal title appropriately (Modifier vs Ajouter)
                try{
                    const triggerMode = btn.dataset && btn.dataset.mode ? btn.dataset.mode : 'edit';
                    const titleEl = el.querySelector('.modal-title');
                    const submitBtn = el.querySelector('button[type="submit"], button[id$="Save"]');
                    if(titleEl){
                        if(triggerMode === 'add') titleEl.textContent = (section === 'carousel' ? 'Ajouter au Carrousel' : 'Ajouter');
                        else titleEl.textContent = (section === 'carousel' ? 'Modifier Carrousel' : 'Modifier');
                    }
                    if(submitBtn){
                        if(triggerMode === 'add') submitBtn.textContent = submitBtn.dataset && submitBtn.dataset.addText ? submitBtn.dataset.addText : 'Ajouter';
                        else submitBtn.textContent = submitBtn.dataset && submitBtn.dataset.saveText ? submitBtn.dataset.saveText : 'Enregistrer';
                    }
                } catch(e){ /* ignore title set failures */ }
                // try to fill form fields using data-field attributes in the card
                try{
                    const form = el.querySelector('form') || el;
                    // find display fields
                    card.querySelectorAll('[data-field]').forEach(function(dis){
                        const fieldName = dis.getAttribute('data-field');
                        // handle repeated fields (service_title/service_text)
                        if(fieldName === 'service_title' || fieldName === 'service_text'){
                            const idx = dis.getAttribute('data-index');
                            const input = form.querySelector('[name="' + (fieldName === 'service_title' ? 'service_title[]' : 'service_text[]') + '"][data-index="' + idx + '"]') || form.querySelectorAll('[name="' + (fieldName === 'service_title' ? 'service_title[]' : 'service_text[]') + '"]')[idx];
                            if(input) input.value = dis.textContent.trim();
                        } else if(fieldName === 'about_image'){
                            // nothing to do for file input
                        } else if(fieldName){
                            const input = form.querySelector('[name="' + fieldName + '"]');
                            if(input) input.value = dis.textContent.trim();
                        }
                    });
                } catch(e){ console.warn('Prefill failed', e); }

                const bs = new bootstrap.Modal(el);
                bs.show();
            });
        });

        // Generic submit handler for a modal form via fetch
        async function submitModalForm(formEl){
            if(!formEl) return;
            const url = (formEl.getAttribute('action') || mainAction || window.location.href);
            const MAX_IMAGE_BYTES = (window.SYNEM_MAX_IMAGE_BYTES || (5 * 1024 * 1024)); // 5 Mo
            // Build FormData manually to ensure all text fields are included alongside files
            const fd = new FormData();
            Array.from(formEl.elements).forEach(function(el){
                if(!el.name || el.disabled) return;
                const name = el.name;
                const type = (el.type || '').toLowerCase();
                if(type === 'file'){
                    const files = el.files || [];
                    Array.from(files).forEach(function(f){ fd.append(name, f); });
                } else if(type === 'select-multiple'){
                    Array.from(el.options).forEach(function(opt){ if(opt.selected) fd.append(name, opt.value); });
                } else if((type === 'checkbox' || type === 'radio')){
                    if(el.checked) fd.append(name, el.value);
                } else {
                    fd.append(name, el.value);
                }
            });

            // Client-side guardrail: refuse images > 5MB before sending
            try{
                const oversized = [];
                for(const pair of fd.entries()){
                    const v = pair[1];
                    if(v instanceof File){
                        const isImage = (v.type || '').startsWith('image/');
                        if(isImage && v.size > MAX_IMAGE_BYTES){
                            oversized.push({ name: v.name, size: v.size });
                        }
                    }
                }
                if(oversized.length){
                    const items = oversized.map(o => `<li>${String(o.name)} — ${(o.size/1024/1024).toFixed(2)} Mo</li>`).join('');
                    Swal.fire({
                        icon: 'error',
                        title: 'Image trop volumineuse',
                        html: `Chaque image doit faire au maximum <b>5 Mo</b>.<br><ul class="text-start mb-0">${items}</ul>`
                    });
                    return;
                }
            }catch(e){ /* ignore client-side check failures */ }
            // ensure CSRF token present
            if(!fd.get('_token')) fd.append('_token', getCsrfToken());

            // Debug logging to help diagnose network failures
            try{
                console.info('Submitting modal form to', url);
                // list first few FormData entries (for debug only) and log files
                for (const pair of fd.entries()){
                    if(typeof pair[1] === 'string') console.info('FD', pair[0], pair[1]);
                    else if(pair[1] instanceof File) console.info('FD File', pair[0], pair[1].name, pair[1].size);
                }
                // additionally log file inputs in the form (helpful for multiple cloned inputs)
                try{
                    const fileInputs = Array.from(formEl.querySelectorAll('input[type="file"]'));
                    if(fileInputs.length){
                        fileInputs.forEach((inp, idx)=>{
                            const files = Array.from(inp.files || []);
                            console.info('File input', idx, inp.name, 'count=', files.length, files.map(f=>f.name));
                        });
                    }
                } catch(e){ console.warn('File inputs debug failed', e); }
            } catch(e){ console.warn('FormData debug failed', e); }

            try{
                const res = await fetch(url, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': getCsrfToken()
                    },
                    body: fd
                });

                // Read response as text first, then try to parse JSON.
                // (On 413, PHP may prepend warnings before JSON which breaks res.json())
                const contentType = res.headers.get('content-type') || '';
                const raw = await res.text().catch(()=> '');
                function tryParseJson(maybeJson){
                    if(!maybeJson) return null;
                    const t = String(maybeJson).trim();
                    try{ return JSON.parse(t); }catch(e){}
                    const start = t.indexOf('{');
                    const end = t.lastIndexOf('}');
                    if(start !== -1 && end !== -1 && end > start){
                        const slice = t.slice(start, end + 1);
                        try{ return JSON.parse(slice); }catch(e){}
                    }
                    return null;
                }
                const data = contentType.indexOf('application/json') !== -1 ? tryParseJson(raw) : null;

                if(res.ok){
                    if(data && data.success){
                        try{ localStorage.setItem('suppress_server_success','1'); }catch(e){}
                        Swal.fire({ icon: 'success', title: 'Enregistré', text: data.message || 'Modifications enregistrées.' }).then(()=>{ location.reload(); });
                    } else if(data) {
                        Swal.fire({ icon: 'error', title: 'Erreur', text: data.message || 'Impossible d\'enregistrer.' });
                    } else {
                        // success but not json (maybe redirected) -> reload
                        location.reload();
                    }
                } else {
                    console.error('Modal submit failed', res.status, data || raw);
                    let htmlMsg;
                    if(res.status === 413){
                        htmlMsg = "La requête est trop volumineuse. Réduisez la taille ou le nombre d'images, puis réessayez.";
                    } else {
                        htmlMsg = (data && data.message) ? data.message : ('Échec de l\'enregistrement (status ' + res.status + ').');
                    }
                    // For Laravel validation errors (422), show details if present
                    if(data && data.errors){
                        try{
                            const errs = data.errors;
                            const list = Array.isArray(errs) ? errs : Object.values(errs).flat();
                            if(list && list.length){
                                htmlMsg += '<br><ul class="text-start mb-0">' + list.map(e=>'<li>' + String(e) + '</li>').join('') + '</ul>';
                            }
                        }catch(e){ /* ignore */ }
                    }
                    Swal.fire({ icon: 'error', title: 'Erreur', html: htmlMsg });
                }
            } catch(err){
                console.error('Fetch error', err);
                const online = navigator.onLine;
                const message = err && err.message ? err.message : String(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur réseau',
                    html: `Impossible de se connecter au serveur.<br><b>Erreur:</b> ${message}<br><b>En ligne:</b> ${online ? 'oui' : 'non'}`,
                    showCancelButton: true,
                    confirmButtonText: 'Réessayer',
                    cancelButtonText: 'Envoyer autrement',
                }).then((choice) => {
                    if(choice.isConfirmed){
                        // retry
                        submitModalForm(formEl);
                    } else if(choice.isDismissed){
                        // fallback: perform a normal form submit as last resort
                        try{
                            // set form action and submit normally
                            formEl.action = url;
                            formEl.method = 'POST';
                            formEl.submit();
                        } catch(submitErr){
                            console.error('Fallback submit failed', submitErr);
                            Swal.fire({ icon: 'error', title: 'Échec', text: 'Impossible d\'envoyer le formulaire en mode fallback.' });
                        }
                    }
                });
            }
        }

        // wire save buttons
        const carouselSave = document.getElementById('modalCarouselSave');
        const aboutSave = document.getElementById('modalAboutSave');
        const newsSave = document.getElementById('modalNewsSave');
        const servicesSave = document.getElementById('modalServicesSave');
        const documentsSave = document.getElementById('modalDocumentsSave');

        carouselSave && carouselSave.addEventListener('click', function(){
            const form = document.getElementById('modalCarouselForm');
            // ensure we include the _method override if needed; using POST to main route with _section
            submitModalForm(form);
        });

        aboutSave && aboutSave.addEventListener('click', function(){
            const form = document.getElementById('modalAboutForm');
            submitModalForm(form);
        });

        newsSave && newsSave.addEventListener('click', function(){
            const form = document.getElementById('modalNewsForm');
            submitModalForm(form);
        });
        servicesSave && servicesSave.addEventListener('click', function(){
            const form = document.getElementById('modalServicesForm');
            submitModalForm(form);
        });
        documentsSave && documentsSave.addEventListener('click', function(){
            const form = document.getElementById('modalDocumentsForm');
            submitModalForm(form);
        });

        // Clear modal form when opened by an 'Ajouter' button (data-mode="add") to avoid leftover values
        ['modalSectionCarousel','modalSectionAbout','modalSectionNews','modalSectionServices','modalSectionDocuments'].forEach(function(mid){
            const m = document.getElementById(mid);
            if(!m) return;
            m.addEventListener('show.bs.modal', function(ev){
                const trigger = ev.relatedTarget;
                if(trigger && trigger.dataset && trigger.dataset.mode === 'add'){
                    const form = m.querySelector('form');
                    if(!form) return;
                    // clear text inputs/textarea and file inputs
                    form.querySelectorAll('input[type="text"], input[type="file"]').forEach(i=> i.value = '');
                    form.querySelectorAll('textarea').forEach(t=> t.value = '');
                    // clear array inputs (service_title[], service_text[])
                    form.querySelectorAll('input[name$="[]"]').forEach(i=> i.value = '');
                    // set modal title/button for add mode
                    try{
                        const titleEl = m.querySelector('.modal-title');
                        const submitBtn = m.querySelector('button[type="submit"], button[id$="Save"]');
                        if(titleEl) titleEl.textContent = (m.id === 'modalSectionCarousel' ? 'Ajouter au Carrousel' : 'Ajouter');
                        if(submitBtn) submitBtn.textContent = submitBtn.dataset && submitBtn.dataset.addText ? submitBtn.dataset.addText : 'Ajouter';
                    }catch(e){}
                    // Specific: when adding to carousel, hide & disable global title/subtitle inputs
                    if(m.id === 'modalSectionCarousel'){
                        try{
                            const titleWrapper = form.querySelector('input[name="carousel_title"]') ? form.querySelector('input[name="carousel_title"]').closest('.mb-3') : null;
                            const subtitleWrapper = form.querySelector('input[name="carousel_subtitle"]') ? form.querySelector('input[name="carousel_subtitle"]').closest('.mb-3') : null;
                            const titleInput = form.querySelector('input[name="carousel_title"]');
                            const subtitleInput = form.querySelector('input[name="carousel_subtitle"]');
                            if(titleWrapper) titleWrapper.classList.add('d-none');
                            if(subtitleWrapper) subtitleWrapper.classList.add('d-none');
                            if(titleInput) titleInput.disabled = true;
                            if(subtitleInput) subtitleInput.disabled = true;
                        }catch(e){console.warn('Hide title/subtitle failed', e);}
                    }
                }
                else {
                    // ensure for non-add (edit) the title/subtitle are visible and enabled
                    const form = m.querySelector('form');
                    if(form && m.id === 'modalSectionCarousel'){
                        try{
                            const titleWrapper = form.querySelector('input[name="carousel_title"]') ? form.querySelector('input[name="carousel_title"]').closest('.mb-3') : null;
                            const subtitleWrapper = form.querySelector('input[name="carousel_subtitle"]') ? form.querySelector('input[name="carousel_subtitle"]').closest('.mb-3') : null;
                            const titleInput = form.querySelector('input[name="carousel_title"]');
                            const subtitleInput = form.querySelector('input[name="carousel_subtitle"]');
                            if(titleWrapper) titleWrapper.classList.remove('d-none');
                            if(subtitleWrapper) subtitleWrapper.classList.remove('d-none');
                            if(titleInput) titleInput.disabled = false;
                            if(subtitleInput) subtitleInput.disabled = false;
                        }catch(e){}
                    }
                }
            });
        });

        // Delete a news item (index) using AJAX: build new news_items without that index
        document.querySelectorAll('.btn-delete-news').forEach(function(btn){
            btn.addEventListener('click', function(){
                const idx = parseInt(btn.getAttribute('data-news-index'));
                Swal.fire({
                    title: 'Confirmer',
                    text: 'Supprimer cette actualité ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui, supprimer'
                }).then((res)=>{
                    if(!res.isConfirmed) return;
                    // collect current items from DOM
                    const list = Array.from(document.querySelectorAll('[data-news-index]')).map(n=> (n.dataset.newsText || n.textContent).trim()).filter((v,i)=>i!==idx);
                    const payload = new FormData();
                    payload.append('_token', getCsrfToken());
                    payload.append('news_items', list.join('\n'));
                    fetch(adminRoutes.news, {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': getCsrfToken() },
                        body: payload
                    }).then(r=>r.json()).then(data=>{
                        if(data && data.success){
                            Swal.fire({ icon:'success', title:'Supprimé', text: data.message || 'Actualité supprimée.' }).then(()=> location.reload());
                        } else {
                            Swal.fire({ icon:'error', title:'Erreur', text: data.message || 'Impossible de supprimer.' });
                        }
                    }).catch(e=>{
                        console.error(e);
                        Swal.fire({ icon:'error', title:'Erreur réseau', text:'Impossible de contacter le serveur.' });
                    });
                });
            });
        });

        // Delete a service block by index using AJAX: rebuild service arrays and send to services endpoint
        document.querySelectorAll('button[data-service-index]').forEach(function(btn){
            btn.addEventListener('click', function(){
                const idx = parseInt(btn.getAttribute('data-service-index'));
                Swal.fire({
                    title: 'Confirmer',
                    text: 'Supprimer cet élément ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui, supprimer'
                }).then((res)=>{
                    if(!res.isConfirmed) return;
                    // collect titles/texts from DOM
                    const titles = [];
                    const texts = [];
                    document.querySelectorAll('[data-field="service_title"]').forEach(function(el, i){ if(i!==idx) titles.push(el.textContent.trim()); });
                    document.querySelectorAll('[data-field="service_text"]').forEach(function(el, i){ if(i!==idx) texts.push(el.textContent.trim()); });
                    const fd = new FormData();
                    fd.append('_token', getCsrfToken());
                    fd.append('services_title', document.querySelector('[data-field="services_title"]') ? document.querySelector('[data-field="services_title"]').textContent.trim() : '');
                    titles.forEach(t=>fd.append('service_title[]', t));
                    texts.forEach(t=>fd.append('service_text[]', t));
                    fetch(adminRoutes.services, {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': getCsrfToken() },
                        body: fd
                    }).then(r=>r.json()).then(data=>{
                        if(data && data.success){
                            Swal.fire({ icon:'success', title:'Supprimé', text: data.message || 'Élément supprimé.' }).then(()=> location.reload());
                        } else {
                            Swal.fire({ icon:'error', title:'Erreur', text: data.message || 'Impossible de supprimer.' });
                        }
                    }).catch(e=>{
                        console.error(e);
                        Swal.fire({ icon:'error', title:'Erreur réseau', text:'Impossible de contacter le serveur.' });
                    });
                });
            });
        });

        // Edit carousel image metadata
        const editCarouselModalEl = document.getElementById('editCarouselImageModal');
        let editCarouselModal = null;
        if(editCarouselModalEl) editCarouselModal = new bootstrap.Modal(editCarouselModalEl);
        document.querySelectorAll('.btn-edit-carousel').forEach(function(btn){
            btn.addEventListener('click', function(){
                const id = btn.getAttribute('data-id');
                const title = btn.getAttribute('data-title') || '';
                const text = btn.getAttribute('data-text') || '';
                const form = document.getElementById('editCarouselImageForm');
                // set action to base/id
                form.action = adminRoutes.carouselImageBase + '/' + id;
                document.getElementById('edit_carousel_title').value = title;
                document.getElementById('edit_carousel_text').value = text;
                if(editCarouselModal) editCarouselModal.show();
            });
        });

        // submit edit carousel image form via fetch
        const editCarouselForm = document.getElementById('editCarouselImageForm');
        if(editCarouselForm){
            editCarouselForm.addEventListener('submit', function(e){
                e.preventDefault();
                const url = editCarouselForm.getAttribute('action');
                if(!url) return;
                const fd = new FormData(editCarouselForm);
                if(!fd.get('_token')) fd.append('_token', getCsrfToken());
                fetch(url, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': getCsrfToken(), 'X-HTTP-Method-Override': 'PUT' },
                    body: fd
                }).then(r=>r.json()).then(data=>{
                    if(data && data.success){
                        try{ localStorage.setItem('suppress_server_success','1'); }catch(e){}
                        Swal.fire({ icon:'success', title:'Enregistré', text: data.message || 'Image mise à jour.' }).then(()=> location.reload());
                    } else {
                        Swal.fire({ icon:'error', title:'Erreur', text: data.message || 'Impossible de mettre à jour.' });
                    }
                }).catch(e=>{
                    console.error(e);
                    Swal.fire({ icon:'error', title:'Erreur réseau', text:'Impossible de contacter le serveur.' });
                });
            });
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Document add/remove: support both page and modal wrappers
        const addBtn = document.getElementById('add-document-btn');
        const wrapper = document.getElementById('new-documents-wrapper');
        const modalAddBtn = document.getElementById('modal-add-document-btn');
        const modalWrapper = document.getElementById('modal-documents-wrapper');

        function cloneDocumentRow(sourceRow, targetWrapper, removeClass){
            if(!sourceRow || !targetWrapper) return;
            const clone = sourceRow.cloneNode(true);
            const removeBtn = clone.querySelector(removeClass) || clone.querySelector('.remove-doc-row');
            if(removeBtn) removeBtn.classList.remove('d-none');
            clone.querySelectorAll('input').forEach(i => { if(i.type !== 'file') i.value = ''; else i.value = ''; });
            clone.querySelectorAll('select').forEach(s => s.selectedIndex = 0);
            targetWrapper.appendChild(clone);
        }

        if(addBtn && wrapper){
            addBtn.addEventListener('click', function(){
                const row = wrapper.querySelector('.new-document-row');
                cloneDocumentRow(row, wrapper, '.remove-doc-row');
            });
            // delegated remove for page rows
            wrapper.addEventListener('click', function(e){
                if(e.target.closest('.remove-doc-row')){
                    const row = e.target.closest('.new-document-row');
                    if(row) row.remove();
                }
            });
        }

        if(modalAddBtn && modalWrapper){
            modalAddBtn.addEventListener('click', function(){
                const row = modalWrapper.querySelector('.modal-new-document-row');
                cloneDocumentRow(row, modalWrapper, '.remove-modal-doc-row');
            });
            // delegated remove for modal rows
            modalWrapper.addEventListener('click', function(e){
                if(e.target.closest('.remove-modal-doc-row')){
                    const row = e.target.closest('.modal-new-document-row');
                    if(row) row.remove();
                }
            });
        }

        // Ensure modal has at least one empty row and focus the first input when opened
        const modalDocsEl = document.getElementById('modalSectionDocuments');
        if(modalDocsEl){
            modalDocsEl.addEventListener('shown.bs.modal', function(){
                // if no rows exist, add one
                const rows = modalWrapper.querySelectorAll('.modal-new-document-row');
                if(rows.length === 0){
                    modalAddBtn && modalAddBtn.click();
                }
                // focus first title input
                const firstTitle = modalWrapper.querySelector('input[name="new_document_title[]"]');
                if(firstTitle){
                    try{ firstTitle.focus(); } catch(e){}
                }
            });
        }

        // Carousel add-row and preview (modal-scoped)
        const carouselWrapper = document.getElementById('modal-carousel-wrapper') || document.getElementById('new-carousel-wrapper');
        const addCarouselBtn = document.getElementById('modal-add-carousel-btn') || document.getElementById('add-carousel-btn');
        const previewCarouselBtn = document.getElementById('modal-preview-carousel-btn') || document.getElementById('preview-carousel-btn');
        const previewList = document.getElementById('carousel-preview-list');
        const previewModalEl = document.getElementById('carouselPreviewModal');
        let previewModal = null;
        if (previewModalEl) previewModal = new bootstrap.Modal(previewModalEl);

        if (addCarouselBtn && carouselWrapper) {
            addCarouselBtn.addEventListener('click', function(){
                // find a template row inside the wrapper
                const row = carouselWrapper.querySelector('.modal-new-carousel-row') || document.querySelector('.new-carousel-row');
                if(!row) return;
                const clone = row.cloneNode(true);
                const removeBtn = clone.querySelector('.remove-modal-carousel-row') || clone.querySelector('.remove-carousel-row');
                if(removeBtn) removeBtn.classList.remove('d-none');
                // clear file inputs
                clone.querySelectorAll('input').forEach(i => { if(i.type === 'file') i.value = ''; else i.value = ''; });
                carouselWrapper.appendChild(clone);
            });

            // delegated remove for carousel rows (modal-scoped)
            carouselWrapper.addEventListener('click', function(e){
                if(e.target.closest('.remove-modal-carousel-row') || e.target.closest('.remove-carousel-row')){
                    const row = e.target.closest('.modal-new-carousel-row') || e.target.closest('.new-carousel-row');
                    if(row) row.remove();
                }
            });
        }

        function collectCarouselFiles(){
            // prefer inputs inside modal wrapper
            let inputs = [];
            if(carouselWrapper) inputs = Array.from(carouselWrapper.querySelectorAll('input[name="carousel_images[]"]'));
            if(inputs.length === 0) inputs = Array.from(document.querySelectorAll('input[name="carousel_images[]"]'));
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
            if(!previewList) return;
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
                    try{ entry.input.value = ''; }catch(e){}
                    if(col.parentNode) col.parentNode.removeChild(col);
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
                if(files.length === 0) return Swal.fire({ icon: 'info', title: 'Aucune image', text: 'Aucune image sélectionnée pour la prévisualisation.' });
                showCarouselPreview(files);
            });
        }

        // revoke object URLs on modal hide
        if(previewModalEl) {
            previewModalEl.addEventListener('hidden.bs.modal', function(){
                if(previewList) previewList.querySelectorAll('img').forEach(function(img){ if(img.src.startsWith('blob:')) URL.revokeObjectURL(img.src); });
                if(previewList) previewList.innerHTML = '';
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
@endpush
