<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Militants - Filtrage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container-fluid mt-4">
        <h1 class="mb-4">Test - Gestion des Militants (Filtrage Automatique)</h1>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Statistiques des Militants</h3>
                    </div>
                    <div class="card-body">
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
                    </div>

                    <!-- Filters Section -->
                    <div class="card-header border-0">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="search">Rechercher</label>
                                    <input type="text" class="form-control" id="search" name="search"
                                           value="{{ request('search') }}" placeholder="Nom, email, téléphone, carte...">
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
                            <div class="col-md-3">
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
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Email</th>
                                        <th>Téléphone</th>
                                        <th>Numéro de carte</th>
                                        <th>Coordination Locale</th>
                                        <th>Statut</th>
                                        <th>Date de soumission</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($militants as $militant)
                                    <tr>
                                        <td>{{ $militant->name }}</td>
                                        <td>{{ $militant->email }}</td>
                                        <td>{{ $militant->tel }}</td>
                                        <td>{{ $militant->n_cartes_syndicale ?: '-' }}</td>
                                        <td>{{ $militant->coordinations }}</td>
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
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            @if(request()->hasAny(['search', 'status', 'coordination']))
                                                Aucun militant trouvé avec les filtres appliqués.
                                            @else
                                                Aucune demande de militant trouvée.
                                            @endif
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if($militants->hasPages())
                    <div class="card-footer">
                        {{ $militants->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    $(document).ready(function() {
        console.log('🚀 jQuery ready - Filters initializing...');

        // Check elements exist
        const $searchInput = $('#search');
        const $statusFilter = $('#status-filter');
        const $coordinationFilter = $('#coordination-filter');
        const $resetButton = $('#reset-filters');

        console.log('🔍 Elements check:', {
            search: $searchInput.length,
            status: $statusFilter.length,
            coordination: $coordinationFilter.length,
            reset: $resetButton.length
        });

        if ($searchInput.length === 0 || $statusFilter.length === 0 || $coordinationFilter.length === 0 || $resetButton.length === 0) {
            console.error('❌ Some elements are missing!');
            return;
        }

        // Function to apply filters
        function applyFilters() {
            const search = $searchInput.val().trim();
            const status = $statusFilter.val();
            const coordination = $coordinationFilter.val();

            console.log('🎯 Applying filters:', { search, status, coordination });

            // Build URL
            const params = new URLSearchParams(window.location.search);

            if (search) {
                params.set('search', search);
            } else {
                params.delete('search');
            }

            if (status !== 'all') {
                params.set('status', status);
            } else {
                params.delete('status');
            }

            if (coordination !== 'all') {
                params.set('coordination', coordination);
            } else {
                params.delete('coordination');
            }

            params.delete('page');

            const newUrl = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
            console.log('🔄 Redirecting to:', newUrl);

            window.location.href = newUrl;
        }

        // Attach events
        let filterTimeout;

        // Search input with debounce
        $searchInput.on('input', function(e) {
            console.log('⌨️ Search input:', $(this).val());
            clearTimeout(filterTimeout);
            filterTimeout = setTimeout(() => {
                console.log('⏰ Applying search filter');
                applyFilters();
            }, 1000); // 1 second debounce
        });

        // Status filter
        $statusFilter.on('change', function(e) {
            console.log('📊 Status changed:', $(this).val());
            applyFilters();
        });

        // Coordination filter
        $coordinationFilter.on('change', function(e) {
            console.log('🏢 Coordination changed:', $(this).val());
            applyFilters();
        });

        // Reset button
        $resetButton.on('click', function(e) {
            e.preventDefault();
            console.log('🔄 Reset clicked');

            // Reset form values
            $searchInput.val('');
            $statusFilter.val('all');
            $coordinationFilter.val('all');

            // Remove active state from button
            $(this).blur();

            // Redirect to clean URL
            window.location.href = window.location.pathname;
        });

        // Enter key on search
        $searchInput.on('keypress', function(e) {
            if (e.which === 13) { // Enter key
                console.log('↵ Enter pressed');
                clearTimeout(filterTimeout);
                applyFilters();
            }
        });

        console.log('✅ All event listeners attached successfully!');
        console.log('🎉 Filter system fully initialized!');
    });
    </script>
</body>
</html>