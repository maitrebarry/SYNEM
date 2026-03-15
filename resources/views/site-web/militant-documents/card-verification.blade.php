@extends('layouts.site')

@section('title', 'Verification carte membre')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-success">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="fas fa-shield-check me-2"></i>Carte SYNEM verifiee</h4>
                </div>
                <div class="card-body">
                    <div class="row align-items-center g-4">
                        <div class="col-md-4 text-center">
                            <img src="{{ $submission->photo_url }}" alt="Photo militant" class="img-fluid rounded border" style="max-height: 260px; object-fit: cover;">
                        </div>
                        <div class="col-md-8">
                            <h5 class="mb-3">{{ $militant->full_name }}</h5>
                            <p class="mb-1"><strong>Numero membre :</strong> {{ $militant->n_cartes_syndicale ?: 'Non renseigne' }}</p>
                            <p class="mb-1"><strong>Division :</strong> {{ $militant->division_label }}</p>
                            <p class="mb-1"><strong>Coordination / Region :</strong> {{ $militant->region_label }}</p>
                            <p class="mb-1"><strong>Telephone :</strong> {{ $militant->tel }}</p>
                            <p class="mb-1"><strong>Statut :</strong> Militant approuve</p>
                            <p class="mb-0 text-muted">Cette fiche confirme l'authenticite de la carte membre SYNEM.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection