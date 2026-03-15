@extends('layouts.administration')

@section('title', 'Messages militants')

@section('breadcrumb')
<div class="page-breadcrumb d-flex align-items-center">
    <div class="breadcrumb-title pe-3">Militants</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('administration.tableau-de-bord') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item active" aria-current="page">Messages militants</li>
            </ol>
        </nav>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card border-primary shadow-sm mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">Campagne photo pour cartes membres</h5>
                    <small class="text-muted">Depuis cet espace, vous pouvez lancer la demande collective de photo vers tous les militants approuvés.</small>
                </div>
                <a href="{{ route('administration.pages.cartes-membres.index') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-id-card me-1"></i>
                    Ouvrir le module cartes
                </a>
            </div>
            <div class="card-body">
                @if($activeMemberCardCampaign)
                    <div class="alert alert-info d-flex justify-content-between align-items-start flex-wrap gap-3">
                        <div>
                            <strong>Campagne active :</strong> {{ $activeMemberCardCampaign->title }}<br>
                            <small class="text-muted">Envoyée le {{ optional($activeMemberCardCampaign->sent_at)->format('d/m/Y H:i') }}</small>
                            <p class="mb-0 mt-2">{{ $activeMemberCardCampaign->message }}</p>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <span class="badge bg-secondary">{{ $activeMemberCardCampaign->submissions_count }} reçues</span>
                            <span class="badge bg-warning text-dark">{{ $activeMemberCardCampaign->pending_submissions_count }} en attente</span>
                            <span class="badge bg-success">{{ $activeMemberCardCampaign->approved_submissions_count }} validées</span>
                            <span class="badge bg-danger">{{ $activeMemberCardCampaign->revision_submissions_count }} à reprendre</span>
                        </div>
                    </div>
                @endif

                <form action="{{ route('administration.pages.cartes-membres.campaigns.store') }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-md-4">
                        <label class="form-label" for="campaign-title">Titre de la demande</label>
                        <input type="text" class="form-control" id="campaign-title" name="title" value="Demande de photo pour carte SYNEM" maxlength="150" required>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label" for="campaign-message">Message collectif</label>
                        <textarea class="form-control" id="campaign-message" name="message" rows="3" required>Bonjour, merci d'envoyer votre photo d'identité pour la confection de votre carte de membre SYNEM. Vous pouvez prendre la photo depuis votre caméra ou la téléverser depuis votre appareil.</textarea>
                    </div>
                    <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <small class="text-muted">Le formulaire apparaîtra automatiquement dans l'espace personnel des militants approuvés.</small>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-1"></i>
                            Envoyer la demande collective
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if($latestMemberCardSubmissions->isNotEmpty())
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Dernières photos reçues</h5>
                    <a href="{{ route('administration.pages.cartes-membres.index') }}#submissions" class="btn btn-sm btn-outline-secondary">Voir tout</a>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach($latestMemberCardSubmissions as $submission)
                            <div class="col-md-4 col-xl-2">
                                <div class="border rounded p-2 h-100 text-center">
                                    <img src="{{ $submission->photo_url }}" alt="Photo militant" class="img-fluid rounded mb-2" style="height: 150px; width: 100%; object-fit: cover;">
                                    <div class="fw-semibold small">{{ $submission->militant?->full_name ?? 'Militant' }}</div>
                                    <div class="text-muted small">{{ $submission->militant?->email }}</div>
                                    <span class="badge mt-2 {{ $submission->status === 'approved' ? 'bg-success' : ($submission->status === 'revision_requested' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                        {{ $submission->status_label }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Historique des questions</h5>
                <span class="badge bg-secondary">{{ $messages->total() }} messages</span>
            </div>
            <div class="card-body">
                @php
                    $statusLabels = [
                        'pending' => 'En attente',
                        'answered' => 'Répondu',
                    ];
                @endphp
                @forelse($messages as $message)
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <div>
                                    <strong>{{ $message->militant?->name ?? 'Militant' }}</strong>
                                    <small class="text-muted ms-2">{{ $message->militant?->email ?? '' }}</small>
                                </div>
                                @php
                                    $statusLabel = $statusLabels[$message->status] ?? ucfirst($message->status);
                                @endphp
                                <span class="badge bg-{{ $message->status === 'pending' ? 'warning text-dark' : 'success' }}">
                                    {{ $statusLabel }}
                                </span>
                            </div>
                            <p class="text-dark mb-2">{{ $message->question }}</p>
                            <small class="text-muted">Envoyé le {{ $message->created_at->format('d/m/Y H:i') }}</small>
                            @if($message->answer)
                                <div class="alert alert-success mt-3 mb-3">
                                    <strong>Réponse précédente :</strong>
                                    <p class="mb-0">{{ $message->answer }}</p>
                                    <small class="text-muted">Répondu le {{ $message->updated_at->format('d/m/Y H:i') }}</small>
                                </div>
                            @endif
                            <form action="{{ route('administration.pages.militant-messages.reply', $message) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label" for="answer-{{ $message->id }}">Réponse</label>
                                    <textarea class="form-control" id="answer-{{ $message->id }}" name="answer" rows="3" required placeholder="Tapez votre réponse ici..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-reply me-1"></i>
                                    Envoyer la réponse
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="fas fa-comments fa-2x text-muted"></i>
                        <p class="mb-0 mt-2 text-muted">Aucune question n'a encore été posée par un militant.</p>
                    </div>
                @endforelse

                <div class="mt-3">
                    {{ $messages->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
