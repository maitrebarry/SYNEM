@extends('layouts.site')

@section('title', 'Documents Réservés - ' . $militant->name)

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