@extends('layouts.site')

@section('title', 'Documents Réservés - ' . $militant->name)

@section('styles')
<style>
    .member-camera-shell {
        background: #0f172a;
        border-radius: 1rem;
        overflow: hidden;
        position: relative;
        min-height: 260px;
    }

    .member-camera-video,
    .member-camera-canvas {
        width: 100%;
        height: 260px;
        object-fit: cover;
        display: block;
        background: #020617;
    }

    .member-camera-overlay {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: #e2e8f0;
        padding: 1rem;
        background: rgba(2, 6, 23, 0.45);
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <!-- Welcome Header -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="text-primary mb-2">
                                <i class="fas fa-user-check me-2"></i>
                                Bienvenue, {{ $militant->name }}
                            </h2>
                            <p class="text-muted mb-0">
                                <i class="fas fa-envelope me-1"></i>{{ $militant->email }} |
                                <i class="fas fa-id-card me-1"></i>Carte #{{ $militant->n_cartes_syndicale }}
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            <form action="{{ route('militant.documents.logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-sign-out-alt me-1"></i>
                                    Se déconnecter
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents List -->
            <div class="card">
                <div class="card-header bg-success text-white">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h4 class="mb-0">
                                <i class="fas fa-file-alt me-2"></i>
                                Documents Réservés aux Militants
                            </h4>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-6">
                                    <div class="btn-group-vertical btn-group-sm w-100" role="group" aria-label="Filtrer par type">
                                        <input type="radio" class="btn-check" name="documentFilter" id="filter-all" autocomplete="off" checked>
                                        <label class="btn btn-outline-light" for="filter-all">
                                            <i class="fas fa-list me-1"></i>Tous
                                        </label>
                                        <input type="radio" class="btn-check" name="documentFilter" id="filter-pdf" autocomplete="off">
                                        <label class="btn btn-outline-light" for="filter-pdf">
                                            <i class="fas fa-file-pdf me-1"></i>PDF
                                        </label>
                                        <input type="radio" class="btn-check" name="documentFilter" id="filter-word" autocomplete="off">
                                        <label class="btn btn-outline-light" for="filter-word">
                                            <i class="fas fa-file-word me-1"></i>Word
                                        </label>
                                        <input type="radio" class="btn-check" name="documentFilter" id="filter-excel" autocomplete="off">
                                        <label class="btn btn-outline-light" for="filter-excel">
                                            <i class="fas fa-file-excel me-1"></i>Excel
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="btn-group-vertical btn-group-sm w-100" role="group" aria-label="Filtrer par catégorie">
                                        <input type="radio" class="btn-check category-filter" name="categoryFilter" id="cat-all" autocomplete="off" checked>
                                        <label class="btn btn-outline-light" for="cat-all">
                                            <i class="fas fa-folder me-1"></i>Toutes
                                        </label>
                                        <input type="radio" class="btn-check category-filter" name="categoryFilter" id="cat-administratif" autocomplete="off">
                                        <label class="btn btn-outline-light" for="cat-administratif">
                                            <i class="fas fa-building me-1"></i>Admin
                                        </label>
                                        <input type="radio" class="btn-check category-filter" name="categoryFilter" id="cat-formation" autocomplete="off">
                                        <label class="btn btn-outline-light" for="cat-formation">
                                            <i class="fas fa-graduation-cap me-1"></i>Formation
                                        </label>
                                        <input type="radio" class="btn-check category-filter" name="categoryFilter" id="cat-activite" autocomplete="off">
                                        <label class="btn btn-outline-light" for="cat-activite">
                                            <i class="fas fa-chart-line me-1"></i>Activité
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row" id="documentsContainer">
                        @forelse($documents as $document)
                        <div class="col-md-6 col-lg-4 mb-4 document-item" data-type="{{ strtolower($document['type']) }}" data-category="{{ $document['category'] ?? 'divers' }}">
                            <div class="card h-100 border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0">
                                        <i class="fas fa-file-{{ strtolower($document['type']) }} me-2"></i>
                                        {{ $document['title'] }}
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <p class="card-text text-muted small">
                                        {{ $document['description'] }}
                                    </p>
                                    <div class="mb-3">
                                        <small class="text-muted">
                                            <i class="fas fa-weight me-1"></i>{{ $document['size'] }} |
                                            <i class="fas fa-file me-1"></i>{{ $document['type'] }}
                                        </small>
                                    </div>
                                    <a href="{{ route('militant.documents.download', $document['filename']) }}"
                                       class="btn btn-primary btn-sm w-100"
                                       target="_blank">
                                        <i class="fas fa-download me-1"></i>
                                        Télécharger
                                    </a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle fa-2x mb-3"></i>
                                <h5>Aucun document disponible</h5>
                                <p class="mb-0">Les documents réservés seront bientôt disponibles.</p>
                            </div>
                        </div>
                        @endforelse
                    </div>

                    <!-- Statistics -->
                    <div class="row mt-4" id="documentStats">
                        <div class="col-12">
                            <div class="alert alert-light border">
                                <div class="row text-center">
                                    <div class="col-md-2">
                                        <h5 class="text-primary mb-1" id="totalDocs">{{ count($documents) }}</h5>
                                        <small class="text-muted">Total</small>
                                    </div>
                                    <div class="col-md-2">
                                        <h5 class="text-danger mb-1" id="pdfCount">{{ collect($documents)->where('type', 'PDF')->count() }}</h5>
                                        <small class="text-muted">PDF</small>
                                    </div>
                                    <div class="col-md-2">
                                        <h5 class="text-primary mb-1" id="wordCount">{{ collect($documents)->where('type', 'WORD')->count() }}</h5>
                                        <small class="text-muted">Word</small>
                                    </div>
                                    <div class="col-md-2">
                                        <h5 class="text-success mb-1" id="excelCount">{{ collect($documents)->where('type', 'EXCEL')->count() }}</h5>
                                        <small class="text-muted">Excel</small>
                                    </div>
                                    <div class="col-md-2">
                                        <h5 class="text-warning mb-1" id="adminCount">{{ collect($documents)->where('category', 'administratif')->count() }}</h5>
                                        <small class="text-muted">Admin</small>
                                    </div>
                                    <div class="col-md-2">
                                        <h5 class="text-info mb-1" id="formationCount">{{ collect($documents)->where('category', 'formation')->count() }}</h5>
                                        <small class="text-muted">Formation</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Information Card -->
            <div class="card mt-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="text-primary">
                                <i class="fas fa-shield-alt me-2"></i>
                                Sécurité
                            </h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success me-2"></i>Vérification d'identité obligatoire</li>
                                <li><i class="fas fa-check text-success me-2"></i>Accès réservé aux militants approuvés</li>
                                <li><i class="fas fa-check text-success me-2"></i>Logs d'accès sécurisés</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-primary">
                                <i class="fas fa-question-circle me-2"></i>
                                Support
                            </h5>
                            <p class="mb-2">
                                En cas de problème d'accès, contactez votre section régionale SYNEM.
                            </p>
                            <p class="mb-0">
                                <i class="fas fa-envelope me-1"></i>
                                <a href="mailto:support@synem.ml">support@synem.ml</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            @if($activeMemberCardCampaign)
                @php
                    $submissionStatusClasses = [
                        'pending' => 'warning text-dark',
                        'approved' => 'success',
                        'revision_requested' => 'danger',
                    ];
                @endphp
                <div class="card mt-4 border-primary shadow-sm" id="memberCardPhotoRequest">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h5 class="mb-1"><i class="fas fa-id-card me-2"></i>Confection de votre carte SYNEM</h5>
                            <small>Demande envoyée le {{ optional($activeMemberCardCampaign->sent_at)->format('d/m/Y H:i') }}</small>
                        </div>
                        @if($memberCardSubmission)
                            <span class="badge bg-light text-dark">{{ $memberCardSubmission->status_label }}</span>
                        @else
                            <span class="badge bg-warning text-dark">Photo attendue</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <p class="mb-3">{{ $activeMemberCardCampaign->message }}</p>

                        @if($memberCardSubmission)
                            <div class="alert alert-{{ $memberCardSubmission->status === 'approved' ? 'success' : ($memberCardSubmission->status === 'revision_requested' ? 'danger' : 'warning') }}">
                                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                                    <div>
                                        <strong>Statut :</strong> {{ $memberCardSubmission->status_label }}<br>
                                        <small>Envoyée le {{ optional($memberCardSubmission->submitted_at)->format('d/m/Y H:i') }}</small>
                                        @if($memberCardSubmission->admin_comment)
                                            <p class="mb-0 mt-2">Commentaire admin : {{ $memberCardSubmission->admin_comment }}</p>
                                        @endif
                                    </div>
                                    <img src="{{ $memberCardSubmission->photo_url }}" alt="Votre photo" class="rounded border" style="width: 110px; height: 140px; object-fit: cover;">
                                </div>
                            </div>
                        @endif

                        @if(!$memberCardSubmission || $memberCardSubmission->status === 'revision_requested')
                            <form action="{{ route('militant.member-card-photo.store') }}" method="POST" enctype="multipart/form-data" class="row g-3" id="memberCardPhotoForm">
                                @csrf
                                <input type="hidden" name="campaign_id" value="{{ $activeMemberCardCampaign->id }}">
                                <input type="hidden" name="webcam_photo" id="webcam_photo">
                                <div class="col-12">
                                    <div class="border rounded p-3 bg-light">
                                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                                            <div>
                                                <h6 class="mb-1">Prise de photo avec la caméra</h6>
                                                <small class="text-muted">Sur téléphone comme sur ordinateur, vous pouvez ouvrir la caméra, cadrer votre photo et la capturer directement.</small>
                                            </div>
                                            <div class="d-flex gap-2 flex-wrap">
                                                <button class="btn btn-sm btn-primary" type="button" id="openCameraBtn">
                                                    <i class="fas fa-camera me-1"></i>Ouvrir la caméra
                                                </button>
                                                <button class="btn btn-sm btn-success d-none" type="button" id="takePhotoBtn">
                                                    <i class="fas fa-camera-retro me-1"></i>Capturer
                                                </button>
                                                <button class="btn btn-sm btn-outline-secondary d-none" type="button" id="retakePhotoBtn">
                                                    <i class="fas fa-redo me-1"></i>Reprendre
                                                </button>
                                            </div>
                                        </div>
                                        <div class="member-camera-shell">
                                            <video id="memberCameraVideo" class="member-camera-video" playsinline autoplay muted></video>
                                            <canvas id="memberCameraCanvas" class="member-camera-canvas d-none"></canvas>
                                            <div class="member-camera-overlay" id="memberCameraOverlay">
                                                <div>
                                                    <i class="fas fa-camera fa-2x mb-3"></i>
                                                    <div>La caméra peut s'ouvrir ici pour prendre directement votre photo de carte.</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="alert alert-danger d-none mt-3 mb-0" id="memberCameraError"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="captured_photo">Prendre une photo avec la caméra</label>
                                    <input type="file" class="form-control" id="captured_photo" name="captured_photo" accept="image/*" capture="user">
                                    <small class="text-muted">Sur mobile, la caméra peut s'ouvrir directement.</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="uploaded_photo">Téléverser depuis l'appareil</label>
                                    <input type="file" class="form-control" id="uploaded_photo" name="uploaded_photo" accept="image/png,image/jpeg,image/jpg,image/webp">
                                    <small class="text-muted">Formats acceptés : JPG, PNG, WEBP. Taille max : 5 Mo.</small>
                                </div>
                                <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    <small class="text-muted">La photo sera automatiquement liée à votre profil militant.</small>
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-cloud-upload-alt me-1"></i>
                                        Envoyer ma photo
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            @endif

            @php
                $chatStatusLabels = [
                    'pending' => 'En attente',
                    'answered' => 'Répondu',
                ];
            @endphp
            <div class="card mt-4" id="militantChatCard">
                <div class="card-header d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="mb-1 text-primary">
                            <i class="fas fa-comments me-2"></i>
                            Questions & réponses
                        </h5>
                        <small class="text-muted">Envoyez une question aux admins et recevez une réponse sous peu.</small>
                    </div>
                    <span class="badge bg-warning text-dark" id="pendingChatBadge">{{ $messages->where('status', 'pending')->count() }}</span>
                </div>
                <div class="card-body">
                    <div id="chatFeedback" class="alert alert-success d-none" role="alert"></div>
                    <div id="militantChatList" class="militant-chat-list mb-4" style="max-height: 360px; overflow-y: auto;">
                        @forelse($messages as $message)
                            <div class="mb-3 chat-entry" data-status="{{ $message->status }}">
                                <div class="bg-light rounded p-3 border">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <strong>Vous</strong>
                                            <small class="text-muted ms-2">{{ $message->created_at->format('d/m/Y H:i') }}</small>
                                        </div>
                                        <span class="badge {{ $message->status === 'pending' ? 'bg-warning text-dark' : ($message->status === 'answered' ? 'bg-success text-white' : 'bg-secondary text-white') }}">
                                            {{ $chatStatusLabels[$message->status] ?? ucfirst($message->status) }}
                                        </span>
                                    </div>
                                    <p class="mb-2 text-break">{!! nl2br(e($message->question)) !!}</p>
                                    @if($message->answer)
                                        <div class="bg-dark text-white rounded p-3 mt-2">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <strong>Admin SYNEM</strong>
                                                <small class="text-muted ms-2">{{ $message->updated_at->format('d/m/Y H:i') }}</small>
                                            </div>
                                            <p class="mb-0">{!! nl2br(e($message->answer)) !!}</p>
                                        </div>
                                    @else
                                        <small class="text-warning">En attente d'une réponse</small>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted">Aucune question n'a encore été envoyée.</div>
                        @endforelse
                    </div>
                    <form id="militantChatForm">
                        @csrf
                        <div class="mb-3">
                            <label for="questionInput" class="form-label">Votre question</label>
                            <textarea id="questionInput" name="question" class="form-control" rows="3" required placeholder="Décrivez votre besoin en détail..."></textarea>
                        </div>
                        <button class="btn btn-primary" id="submitQuestionBtn" type="submit">
                            <i class="fas fa-paper-plane me-1"></i>
                            Envoyer la question
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    let currentTypeFilter = 'all';
    let currentCategoryFilter = 'all';

    // Document type filtering
    $('input[name="documentFilter"]').on('change', function() {
        currentTypeFilter = $(this).attr('id').replace('filter-', '');
        applyFilters();
    });

    // Document category filtering
    $('input[name="categoryFilter"]').on('change', function() {
        currentCategoryFilter = $(this).attr('id').replace('cat-', '');
        applyFilters();
    });

    // Function to apply combined filters
    function applyFilters() {
        $('.document-item').each(function() {
            const $item = $(this);
            const itemType = $item.data('type');
            const itemCategory = $item.data('category') || 'divers';

            const typeMatch = currentTypeFilter === 'all' || itemType === currentTypeFilter;
            const categoryMatch = currentCategoryFilter === 'all' || itemCategory === currentCategoryFilter;

            if (typeMatch && categoryMatch) {
                $item.show();
            } else {
                $item.hide();
            }
        });

        // Update statistics
        updateStats();
    }

    // Function to update statistics
    function updateStats() {
        const visibleDocuments = $('.document-item:visible');

        // Update total count
        $('#totalDocs').text(visibleDocuments.length);

        // Update type counts
        const pdfCount = visibleDocuments.filter('[data-type="pdf"]').length;
        const wordCount = visibleDocuments.filter('[data-type="word"]').length;
        const excelCount = visibleDocuments.filter('[data-type="excel"]').length;

        $('#pdfCount').text(pdfCount);
        $('#wordCount').text(wordCount);
        $('#excelCount').text(excelCount);

        // Update category counts
        const adminCount = visibleDocuments.filter('[data-category="administratif"]').length;
        const formationCount = visibleDocuments.filter('[data-category="formation"]').length;
        const activiteCount = visibleDocuments.filter('[data-category="activite"]').length;

        $('#adminCount').text(adminCount);
        $('#formationCount').text(formationCount);
        $('#activiteCount').text(activiteCount);
    }

    // Track download clicks for analytics
    $('.btn-primary').on('click', function() {
        const documentName = $(this).closest('.card').find('h6').text().trim();
        console.log('Document downloaded:', documentName);
        // You can add analytics tracking here
    });

    // Initialize stats on page load
    updateStats();

    // Add smooth transitions
    $('.document-item').css('transition', 'opacity 0.3s ease');

    // Add search functionality
    const searchInput = $('<div class="mb-3"><input type="text" class="form-control" placeholder="Rechercher un document..." id="documentSearch"></div>');

    // Insert search input before the documents container
    $('#documentsContainer').before(searchInput);

    // Search functionality
    $('#documentSearch').on('input', function() {
        const searchTerm = $(this).val().toLowerCase();

        $('.document-item').each(function() {
            const $item = $(this);
            const title = $item.find('h6').text().toLowerCase();
            const description = $item.find('.card-text').text().toLowerCase();
            const type = $item.data('type');
            const category = $item.data('category') || '';

            // Check if item matches current filters and search term
            const typeMatch = currentTypeFilter === 'all' || type === currentTypeFilter;
            const categoryMatch = currentCategoryFilter === 'all' || category === currentCategoryFilter;
            const searchMatch = searchTerm === '' ||
                title.includes(searchTerm) ||
                description.includes(searchTerm) ||
                type.includes(searchTerm) ||
                category.includes(searchTerm);

            if (typeMatch && categoryMatch && searchMatch) {
                $item.show();
            } else {
                $item.hide();
            }
        });

        // Update stats after search
        updateStats();
    });

    // Add keyboard shortcuts
    $(document).on('keydown', function(e) {
        // Ctrl+F to focus search
        if (e.ctrlKey && e.key === 'f') {
            e.preventDefault();
            $('#documentSearch').focus();
        }

        // Escape to clear search
        if (e.key === 'Escape') {
            $('#documentSearch').val('').trigger('input');
        }
    });

    const chatForm = $('#militantChatForm');
    const chatList = $('#militantChatList');
    const chatFeedback = $('#chatFeedback');
    const pendingChatBadge = $('#pendingChatBadge');
    const submitQuestionBtn = $('#submitQuestionBtn');
    const chatRoute = "{{ route('militant.messages.store') }}";
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const memberCardPhotoForm = document.getElementById('memberCardPhotoForm');
    const openCameraBtn = document.getElementById('openCameraBtn');
    const takePhotoBtn = document.getElementById('takePhotoBtn');
    const retakePhotoBtn = document.getElementById('retakePhotoBtn');
    const cameraVideo = document.getElementById('memberCameraVideo');
    const cameraCanvas = document.getElementById('memberCameraCanvas');
    const cameraOverlay = document.getElementById('memberCameraOverlay');
    const cameraError = document.getElementById('memberCameraError');
    const webcamPhotoInput = document.getElementById('webcam_photo');
    const mobileCameraInput = document.getElementById('captured_photo');
    const uploadedPhotoInput = document.getElementById('uploaded_photo');
    let memberCameraStream = null;
    let capturedFromCamera = false;

    function escapeHtml(value) {
        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }

    function scrollChatToBottom() {
        if (chatList.length) {
            chatList.scrollTop(chatList[0].scrollHeight);
        }
    }

    function showChatFeedback(message, type = 'success') {
        chatFeedback
            .removeClass('d-none alert-success alert-danger')
            .addClass(`alert-${type}`)
            .text(message);
    }

    function appendChatEntry(entry) {
        const html = `
            <div class="mb-3 chat-entry" data-status="${entry.status}">
                <div class="bg-light rounded p-3 border">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <strong>Vous</strong>
                            <small class="text-muted ms-2">${entry.created_at}</small>
                        </div>
                        <span class="badge bg-warning text-dark">En attente</span>
                    </div>
                    <p class="mb-2 text-break">${escapeHtml(entry.question).replace(/\n/g, '<br>')}</p>
                    <small class="text-warning">En attente d'une réponse</small>
                </div>
            </div>`;

        chatList.append(html);
        scrollChatToBottom();

        const currentCount = Number(pendingChatBadge.text()) || 0;
        pendingChatBadge.text(currentCount + 1);
    }

    async function stopMemberCamera() {
        if (!memberCameraStream) {
            return;
        }

        memberCameraStream.getTracks().forEach((track) => track.stop());
        memberCameraStream = null;
    }

    function setCameraError(message) {
        if (!cameraError) {
            return;
        }

        if (!message) {
            cameraError.classList.add('d-none');
            cameraError.textContent = '';
            return;
        }

        cameraError.textContent = message;
        cameraError.classList.remove('d-none');
    }

    function resetCapturedCameraState() {
        capturedFromCamera = false;
        if (webcamPhotoInput) {
            webcamPhotoInput.value = '';
        }
        if (cameraCanvas) {
            cameraCanvas.classList.add('d-none');
        }
        if (cameraVideo) {
            cameraVideo.classList.remove('d-none');
        }
        if (takePhotoBtn) {
            takePhotoBtn.classList.remove('d-none');
        }
        if (retakePhotoBtn) {
            retakePhotoBtn.classList.add('d-none');
        }
    }

    async function startMemberCamera(autoStart = false) {
        if (!cameraVideo || !navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            if (!autoStart) {
                setCameraError('Votre navigateur ne permet pas l\'ouverture directe de la caméra. Utilisez le téléversement ou le bouton caméra du téléphone.');
            }
            return;
        }

        try {
            await stopMemberCamera();
            setCameraError('');

            memberCameraStream = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: 'user',
                    width: { ideal: 1280 },
                    height: { ideal: 720 }
                },
                audio: false
            });

            cameraVideo.srcObject = memberCameraStream;
            cameraOverlay.classList.add('d-none');
            resetCapturedCameraState();
        } catch (error) {
            if (!autoStart) {
                setCameraError('Impossible d\'ouvrir la caméra. Vérifiez les permissions du navigateur puis réessayez.');
            }
        }
    }

    function captureMemberPhoto() {
        if (!cameraVideo || !cameraCanvas || !memberCameraStream) {
            setCameraError('La caméra n\'est pas encore active.');
            return;
        }

        const width = cameraVideo.videoWidth || 1280;
        const height = cameraVideo.videoHeight || 720;
        cameraCanvas.width = width;
        cameraCanvas.height = height;

        const context = cameraCanvas.getContext('2d');
        context.drawImage(cameraVideo, 0, 0, width, height);

        webcamPhotoInput.value = cameraCanvas.toDataURL('image/jpeg', 0.92);
        cameraCanvas.classList.remove('d-none');
        cameraVideo.classList.add('d-none');
        takePhotoBtn.classList.add('d-none');
        retakePhotoBtn.classList.remove('d-none');
        capturedFromCamera = true;

        if (mobileCameraInput) {
            mobileCameraInput.value = '';
        }
        if (uploadedPhotoInput) {
            uploadedPhotoInput.value = '';
        }
    }

    if (openCameraBtn) {
        openCameraBtn.addEventListener('click', function () {
            startMemberCamera(false);
        });
    }

    if (takePhotoBtn) {
        takePhotoBtn.addEventListener('click', captureMemberPhoto);
    }

    if (retakePhotoBtn) {
        retakePhotoBtn.addEventListener('click', function () {
            resetCapturedCameraState();
        });
    }

    if (mobileCameraInput) {
        mobileCameraInput.addEventListener('change', function () {
            if (this.files && this.files.length > 0 && webcamPhotoInput) {
                webcamPhotoInput.value = '';
                capturedFromCamera = false;
            }
        });
    }

    if (uploadedPhotoInput) {
        uploadedPhotoInput.addEventListener('change', function () {
            if (this.files && this.files.length > 0 && webcamPhotoInput) {
                webcamPhotoInput.value = '';
                capturedFromCamera = false;
            }
        });
    }

    if (memberCardPhotoForm) {
        memberCardPhotoForm.addEventListener('submit', function () {
            stopMemberCamera();
        });

        startMemberCamera(true);
    }

    document.addEventListener('visibilitychange', function () {
        if (document.hidden) {
            stopMemberCamera();
        }
    });

    window.addEventListener('beforeunload', function () {
        stopMemberCamera();
    });

    chatForm.on('submit', function(e) {
        e.preventDefault();
        const questionValue = $('#questionInput').val().trim();
        if (!questionValue) {
            showChatFeedback('Veuillez saisir une question.', 'danger');
            return;
        }

        submitQuestionBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>Envoi...');

        fetch(chatRoute, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({ question: questionValue }),
        })
        .then(async (response) => {
            const payload = await response.json();
            if (!response.ok) {
                throw new Error(payload.message || 'Une erreur est survenue');
            }
            return payload;
        })
        .then((payload) => {
            $('#questionInput').val('');
            appendChatEntry(payload.chat);
            showChatFeedback(payload.message, 'success');
        })
        .catch((error) => {
            showChatFeedback(error.message || 'Échec de l\'envoi.', 'danger');
        })
        .finally(() => {
            submitQuestionBtn.prop('disabled', false).html('<i class="fas fa-paper-plane me-1"></i>Envoyer la question');
        });
    });

    scrollChatToBottom();
});
</script>
@endsection