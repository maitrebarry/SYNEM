@extends('layouts.site')

@section('title', 'Documents - SYNEM')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="display-4">Documents Administratifs</h1>
            <p class="text-muted">Consultez et téléchargez les documents officiels publiés par le SYNEM.</p>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12">
            <form method="GET" action="{{ route('site.documents.index') }}" class="row g-2 align-items-center">
                <div class="col-auto">
                    <label for="filterType" class="visually-hidden">Type</label>
                    <select id="filterType" name="type" class="form-select">
                        <option value="">Tous les types</option>
                        <option value="pdf" {{ request('type') === 'pdf' ? 'selected' : '' }}>PDF</option>
                        <option value="word" {{ request('type') === 'word' ? 'selected' : '' }}>Word</option>
                        <option value="excel" {{ request('type') === 'excel' ? 'selected' : '' }}>Excel</option>
                    </select>
                </div>
                <div class="col-auto flex-grow-1">
                    <label for="filterQ" class="visually-hidden">Recherche</label>
                    <input id="filterQ" name="q" type="search" class="form-control" placeholder="Rechercher par titre..." value="{{ request('q') }}">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Filtrer</button>
                    <a href="{{ route('site.documents.index') }}" class="btn btn-outline-secondary ms-1">Réinitialiser</a>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        @forelse($docs as $doc)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex align-items-center mb-3">
                            @if($doc->type === 'pdf')
                                <i class="fas fa-file-pdf text-danger fa-2x mr-3"></i>
                            @elseif($doc->type === 'word')
                                <i class="fas fa-file-word text-primary fa-2x mr-3"></i>
                            @elseif($doc->type === 'excel')
                                <i class="fas fa-file-excel text-success fa-2x mr-3"></i>
                            @else
                                <i class="fas fa-file-alt fa-2x mr-3"></i>
                            @endif
                            <div>
                                <h5 class="card-title mb-1">{{ $doc->title }}</h5>
                                <small class="text-muted">{{ $doc->created_at ? $doc->created_at->format('d M Y') : '' }}</small>
                            </div>
                        </div>

                        <p class="card-text text-muted mb-4">Fichier : {{ $doc->file }}</p>

                        <div class="mt-auto">
                            <a href="{{ asset('storage/documents/' . $doc->file) }}" class="btn btn-primary btn-sm" download>
                                <i class="fas fa-download mr-1"></i> Télécharger
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Aucun document disponible pour le moment.</div>
            </div>
        @endforelse
    </div>

    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            {{ $docs->links() }}
        </div>
    </div>
</div>
@endsection
