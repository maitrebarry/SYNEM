@extends('layouts.administration')
@section('title', 'Lettres Administratives')

@section('content')
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">SYNEM</div>
    <div class="ps-3"><nav aria-label="breadcrumb"><ol class="breadcrumb mb-0 p-0">
        <li class="breadcrumb-item"><a href="{{ route('administration.tableau-de-bord') }}"><i class="bx bx-home-alt"></i></a></li>
        <li class="breadcrumb-item active">Lettres administratives</li>
    </ol></nav></div>
</div>

<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="mb-0 fw-bold" style="color:#1547c0"><i class='bx bx-envelope-open me-2'></i>Lettres Administratives</h4>
    <a href="{{ route('administration.lettres.create') }}" class="btn btn-primary px-4">
        <i class='bx bx-plus me-1'></i> Nouvelle lettre
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show"><i class='bx bx-check-circle me-2'></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background:#f0f4ff">
                    <tr>
                        <th class="ps-4">N° Lettre</th>
                        <th>Date</th>
                        <th>Objet</th>
                        <th>Signataire</th>
                        <th class="text-center">Statut</th>
                        <th class="text-center">Téléch.</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lettres as $lettre)
                    <tr>
                        <td class="ps-4">
                            <span class="fw-bold text-primary">{{ $lettre->numero }}</span>
                        </td>
                        <td>{{ $lettre->date_lettre->format('d/m/Y') }}</td>
                        <td>
                            <span class="text-truncate d-inline-block" style="max-width:260px" title="{{ $lettre->objet }}">
                                {{ $lettre->objet }}
                            </span>
                        </td>
                        <td>{{ $lettre->signataire }}</td>
                        <td class="text-center">
                            <form method="POST" action="{{ route('administration.lettres.publier', $lettre) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $lettre->est_publiee ? 'btn-success' : 'btn-outline-secondary' }}" title="{{ $lettre->est_publiee ? 'Publié — cliquer pour masquer' : 'Masqué — cliquer pour publier' }}">
                                    <i class='bx {{ $lettre->est_publiee ? "bx-show" : "bx-hide" }}'></i>
                                    {{ $lettre->est_publiee ? 'Publié' : 'Masqué' }}
                                </button>
                            </form>
                        </td>
                        <td class="text-center">
                            <span class="badge {{ $lettre->est_telechargeable ? 'bg-info' : 'bg-secondary' }}">
                                {{ $lettre->est_telechargeable ? 'Oui' : 'Non' }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex gap-1 justify-content-end">
                                <a href="{{ route('administration.lettres.show', $lettre) }}" class="btn btn-sm btn-outline-primary" title="Voir"><i class='bx bx-show'></i></a>
                                <a href="{{ route('administration.lettres.edit', $lettre) }}" class="btn btn-sm btn-outline-warning" title="Modifier"><i class='bx bx-edit'></i></a>
                                <a href="{{ route('administration.lettres.pdf', $lettre) }}" target="_blank" class="btn btn-sm btn-outline-danger" title="Voir le PDF"><i class='bx bx-file'></i></a>
                                <form method="POST" action="{{ route('administration.lettres.destroy', $lettre) }}" class="delete-letter-form">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Supprimer"><i class='bx bx-trash'></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted py-5"><i class='bx bx-envelope bx-lg d-block mb-2'></i>Aucune lettre enregistrée.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($lettres->hasPages())
            <div class="p-3">{{ $lettres->links() }}</div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.delete-letter-form').forEach(function (form) {
    form.addEventListener('submit', function (event) {
        event.preventDefault();

        Swal.fire({
            title: 'Supprimer cette lettre ?',
            text: 'Cette suppression est définitive et ne peut pas être annulée.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler',
            reverseButtons: true,
            focusCancel: true
        }).then(function (result) {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endpush
