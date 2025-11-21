@extends('layouts.administration')

@section('title', 'Détails du Militant')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                    <div class="card-header">
                    <h3 class="card-title">Demande de Militant #{{ $militant->id }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('administration.pages.militants.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Retour à la liste
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 200px;">Nom complet</th>
                                        <td>{{ $militant->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $militant->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Téléphone</th>
                                        <td>{{ $militant->tel ?: '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Numéro de carte</th>
                                        <td>{{ $militant->n_cartes_syndicale ?: '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Coordination Locale</th>
                                        <td>{{ $militant->coordinations ?: '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Message</th>
                                        <td>{{ $militant->message ?: 'Aucun message' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Statut</th>
                                        <td>
                                            @if($militant->status === 'pending')
                                                <span class="badge bg-warning text-dark">En attente</span>
                                            @elseif($militant->status === 'approved')
                                                <span class="badge bg-success">Approuvé</span>
                                            @else
                                                <span class="badge bg-danger">Rejeté</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Date de soumission</th>
                                        <td>{{ $militant->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    @if($militant->updated_at != $militant->created_at)
                                    <tr>
                                        <th>Dernière modification</th>
                                        <td>{{ $militant->updated_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    @endif
                                </table>
                            </div>

                            @if($militant->status === 'pending')
                            <div class="mt-4">
                                <h5>Actions</h5>
                                <div class="btn-group">
                                    <form action="{{ route('administration.pages.militants.update-status', $militant) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-check"></i> Approuver la demande
                                        </button>
                                    </form>
                                    <form action="{{ route('administration.pages.militants.update-status', $militant) }}" method="POST" class="d-inline ml-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-times"></i> Rejeter la demande
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Photo de la carte de membre</h5>
                                </div>
                                <div class="card-body text-center">
                                    @if($militant->member_card_photo)
                                        <img src="{{ $militant->member_card_photo_url }}" alt="Carte de membre" class="img-fluid rounded shadow" style="max-width: 100%; height: auto;">
                                        <div class="mt-3">
                                            <a href="{{ $militant->member_card_photo_url }}" target="_blank" class="btn btn-sm btn-primary">
                                                <i class="fas fa-external-link-alt"></i> Voir en plein écran
                                            </a>
                                        </div>
                                    @else
                                        <div class="text-muted">
                                            <i class="fas fa-image fa-3x mb-3"></i>
                                            <p>Aucune photo disponible</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Confirmation for status changes
    $('form button[type="submit"]').on('click', function(e) {
        e.preventDefault();
        const form = $(this).closest('form');
        const action = $(this).hasClass('btn-success') ? 'approuver' : 'rejeter';

        if (confirm(`Êtes-vous sûr de vouloir ${action} cette demande de militant ?`)) {
            form.submit();
        }
    });
});
</script>
@endsection