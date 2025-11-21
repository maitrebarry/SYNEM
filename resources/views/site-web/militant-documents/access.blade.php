@extends('layouts.site')

@section('title', 'Accès Documents Militants')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">
                        <i class="fas fa-lock me-2"></i>
                        Accès aux Documents Réservés
                    </h4>
                </div>
                <div class="card-body">
                    <p class="text-muted text-center mb-4">
                        Pour accéder aux documents réservés aux militants approuvés, veuillez saisir vos informations de vérification.
                    </p>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('militant.documents.verify') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse Email *</label>
                            <input type="email" class="form-control" id="email" name="email" required
                                   placeholder="votre.email@example.com" value="{{ old('email') }}">
                        </div>

                        <div class="mb-3">
                            <label for="card_number" class="form-label">Numéro de Carte *</label>
                            <input type="text" class="form-control" id="card_number" name="card_number" required
                                   placeholder="Votre numéro de carte de membre" value="{{ old('card_number') }}">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Accéder aux Documents
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Seuls les militants approuvés peuvent accéder à ces documents.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection