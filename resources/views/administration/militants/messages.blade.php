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
