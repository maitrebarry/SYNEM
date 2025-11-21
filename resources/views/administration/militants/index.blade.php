@extends('layouts.administration')

@section('title', 'Gestion des Militants')

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Statistiques des Militants</h3>
                </div>
                <div class="card-body pl-4">
                    <div class="row">
                        <div class="col-lg-3 col-6 mb-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h3 class="card-title mb-2">{{ $stats['total'] }}</h3>
                                    <p class="card-text mb-0">Total Militants</p>
                                    <i class="fas fa-users fa-2x mt-2"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6 mb-3">
                            <div class="card bg-warning text-dark">
                                <div class="card-body text-center">
                                    <h3 class="card-title mb-2">{{ $stats['pending'] }}</h3>
                                    <p class="card-text mb-0">En Attente</p>
                                    <i class="fas fa-clock fa-2x mt-2"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6 mb-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h3 class="card-title mb-2">{{ $stats['approved'] }}</h3>
                                    <p class="card-text mb-0">Approuvés</p>
                                    <i class="fas fa-check fa-2x mt-2"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6 mb-3">
                            <div class="card bg-danger text-white">
                                <div class="card-body text-center">
                                    <h3 class="card-title mb-2">{{ $stats['rejected'] }}</h3>
                                    <p class="card-text mb-0">Rejetés</p>
                                    <i class="fas fa-times fa-2x mt-2"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Gestion des Militants</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>

                <!-- Filters Section -->
                <div class="card-header border-0">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="search">Rechercher</label>
                                <input type="text" class="form-control" id="search" name="search"
                                       value="{{ request('search') }}" placeholder="Nom, prénom, email, téléphone, carte...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="status-filter">Statut</label>
                                <select class="form-control" id="status-filter" name="status">
                                    <option value="all" {{ request('status') === 'all' || !request('status') ? 'selected' : '' }}>Tous les statuts</option>
                                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>En attente</option>
                                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approuvé</option>
                                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejeté</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="coordination-filter">Coordination Locale</label>
                                <select class="form-control" id="coordination-filter" name="coordination">
                                    <option value="all" {{ request('coordination') === 'all' || !request('coordination') ? 'selected' : '' }}>Toutes les coordinations</option>
                                    @foreach($coordinations as $coordination)
                                    <option value="{{ $coordination }}" {{ request('coordination') === $coordination ? 'selected' : '' }}>
                                        {{ $coordination }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <div>
                                    <button type="button" class="btn btn-secondary" id="reset-filters">
                                        <i class="fas fa-undo"></i> Réinitialiser
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="militants-table">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                    <th>N° Carte Syndicale</th>
                                    <th>Coordination</th>
                                    <th>Statut</th>
                                    <th>Date de soumission</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="militants-tbody">
                                @forelse($militants as $index => $militant)
                                <tr class="militant-row">
                                    <td>{{ $militants->firstItem() + $index }}</td>
                                    <td>{{ $militant->nom }}</td>
                                    <td>{{ $militant->prenom }}</td>
                                    <td>{{ $militant->email }}</td>
                                    <td>{{ $militant->tel ?: '-' }}</td>
                                    <td>{{ $militant->n_cartes_syndicale ?: '-' }}</td>
                                    <td>{{ $militant->coordinations ?: '-' }}</td>
                                    <td>
                                        @if($militant->status === 'pending')
                                            <span class="badge bg-warning text-dark">En attente</span>
                                        @elseif($militant->status === 'approved')
                                            <span class="badge bg-success">Approuvé</span>
                                        @else
                                            <span class="badge bg-danger">Rejeté</span>
                                        @endif
                                    </td>
                                    <td>{{ $militant->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('administration.pages.militants.show', $militant) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> Voir
                                        </a>
                                        @if($militant->status === 'pending')
                                        <div class="btn-group ml-1">
                                            <form action="{{ route('administration.pages.militants.update-status', $militant) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="fas fa-check"></i> Approuver
                                                </button>
                                            </form>
                                            <form action="{{ route('administration.pages.militants.update-status', $militant) }}" method="POST" class="d-inline ml-1">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-times"></i> Rejeter
                                                </button>
                                            </form>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr id="no-results-row">
                                    <td colspan="10" class="text-center">
                                        Aucun militant trouvé.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">Mettre à jour le statut</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="statusForm">
                <div class="modal-body">
                    <input type="hidden" id="militantId" name="militant_id">
                    <div class="mb-3">
                        <label for="status" class="form-label">Nouveau statut</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="pending">En attente</option>
                            <option value="approved">Approuvé</option>
                            <option value="rejected">Rejeté</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {

    let filterTimeout;

    function loadFilteredData() {
        const searchTerm = $('#search').val().trim();
        const statusValue = $('#status-filter').val();
        const coordinationValue = $('#coordination-filter').val();

        // console logs removed to keep console clean

        $('#militants-tbody').html('<tr><td colspan="10" class="text-center"><i class="fas fa-spinner fa-spin"></i> Chargement...</td></tr>');

        $.ajax({
            url: '{{ route("administration.pages.militants.index") }}',
            type: 'GET',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            data: {
                search: searchTerm,
                status: statusValue,
                coordination: coordinationValue,
                ajax: 1
            },
            success: function(response) {

                if (response.data && response.data.length > 0) {
                    let html = '';
                    response.data.forEach(function(militant) {
                        let statusBadge = '';
                        switch(militant.status) {
                            case 'pending':
                                statusBadge = '<span class="badge bg-warning text-dark">En attente</span>';
                                break;
                            case 'approved':
                                statusBadge = '<span class="badge bg-success">Approuvé</span>';
                                break;
                            case 'rejected':
                                statusBadge = '<span class="badge bg-danger">Rejeté</span>';
                                break;
                            default:
                                statusBadge = '<span class="badge bg-secondary">Inconnu</span>';
                        }

                        html += `
                            <tr class="militant-row">
                                <td>${militant.numero}</td>
                                <td>${militant.nom}</td>
                                <td>${militant.prenom}</td>
                                <td>${militant.email}</td>
                                <td>${militant.tel}</td>
                                <td>${militant.n_cartes_syndicale}</td>
                                <td>${militant.coordinations}</td>
                                <td>${statusBadge}</td>
                                <td>${militant.created_at}</td>
                                <td>${militant.actions}</td>
                            </tr>
                        `;
                    });

                    $('#militants-tbody').html(html);
                    $('#no-results-row').hide();
                } else {
                    $('#militants-tbody').html('');
                    $('#no-results-row').show();
                }

                updateStats();
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error, xhr.responseText);
                $('#militants-tbody').html('<tr><td colspan="10" class="text-center text-danger">Erreur lors du chargement des données</td></tr>');
            }
        });
    }

    function updateStats() {
        // Stats left static for now
    }

    $('#search').on('input', function() {
        clearTimeout(filterTimeout);
        filterTimeout = setTimeout(loadFilteredData, 300);
    });

    $('#status-filter, #coordination-filter').on('change', loadFilteredData);

    $('#reset-filters').on('click', function(e) {
        e.preventDefault();
        $('#search').val('');
        $('#status-filter').val('all');
        $('#coordination-filter').val('all');
        loadFilteredData();
    });

    $('#militants-table').on('click', '.status-btn', function(e) {
        e.preventDefault();
        const militantId = $(this).data('id');
        const currentStatus = $(this).data('status');

        $('#militantId').val(militantId);
        $('#status').val(currentStatus);
        $('#statusModal').modal('show');
    });

    $('#statusForm').on('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const militantId = formData.get('militant_id');
        const status = formData.get('status');

        $.ajax({
            url: `/administration/pages/militants/${militantId}/status-ajax`,
            type: 'PATCH',
            data: {
                status: status,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $('#statusModal').modal('hide');
                const alertHtml = `
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        ${response.message || 'Statut mis à jour avec succès'}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                $('.container-fluid').prepend(alertHtml);
                setTimeout(() => $('.alert').fadeOut(), 3000);
                setTimeout(loadFilteredData, 1000);
            },
            error: function(xhr) {
                let message = 'Erreur lors de la mise à jour';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                const alertHtml = `
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                $('.container-fluid').prepend(alertHtml);
                setTimeout(() => $('.alert').fadeOut(), 5000);
            }
        });
    });

    $('#militants-table').on('submit', 'form', function() {
        const button = $(this).find('button[type="submit"]:visible').first();
        if (!button.length) {
            return;
        }

        button.prop('disabled', true);
        const originalHtml = button.data('original-html') || button.html();
        button.data('original-html', originalHtml);
        button.html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>' + originalHtml);
    });

});
</script>
@endpush