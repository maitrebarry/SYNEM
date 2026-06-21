@extends('layouts.administration')
@section('title', 'Lettre ' . $lettre->numero)

@section('content')
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">SYNEM</div>
    <div class="ps-3"><nav aria-label="breadcrumb"><ol class="breadcrumb mb-0 p-0">
        <li class="breadcrumb-item"><a href="{{ route('administration.tableau-de-bord') }}"><i class="bx bx-home-alt"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ route('administration.lettres.index') }}">Lettres</a></li>
        <li class="breadcrumb-item active">{{ $lettre->numero }}</li>
    </ol></nav></div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show"><i class='bx bx-check-circle me-2'></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

<div class="d-flex flex-wrap align-items-center gap-2 mb-4">
    <a href="{{ route('administration.lettres.index') }}" class="btn btn-outline-secondary btn-sm"><i class='bx bx-arrow-back'></i></a>
    <h4 class="mb-0 fw-bold me-auto" style="color:#1547c0"><i class='bx bx-envelope-open me-2'></i>{{ $lettre->numero }}</h4>
    <a href="{{ route('administration.lettres.edit', $lettre) }}" class="btn btn-warning btn-sm"><i class='bx bx-edit me-1'></i>Modifier</a>
    <a href="{{ route('administration.lettres.pdf', $lettre) }}" target="_blank" class="btn btn-danger btn-sm"><i class='bx bx-file me-1'></i>Voir PDF</a>
    <a href="{{ route('administration.lettres.telecharger', $lettre) }}" class="btn btn-outline-primary btn-sm"><i class='bx bx-download me-1'></i>Télécharger</a>
    {{-- WhatsApp --}}
    @php
        $texteWA = urlencode("*Lettre SYNEM N°{$lettre->numero}*\nObjet : {$lettre->objet}\nTélécharger : " . route('lettres.public.telecharger', $lettre));
    @endphp
    <a href="https://wa.me/?text={{ $texteWA }}" target="_blank" class="btn btn-success btn-sm"><i class='bx bxl-whatsapp me-1'></i>Partager</a>
    <form method="POST" action="{{ route('administration.lettres.publier', $lettre) }}" class="d-inline">
        @csrf
        <button class="btn btn-sm {{ $lettre->est_publiee ? 'btn-secondary' : 'btn-primary' }}">
            <i class='bx {{ $lettre->est_publiee ? "bx-hide" : "bx-show" }} me-1'></i>
            {{ $lettre->est_publiee ? 'Masquer' : 'Publier' }}
        </button>
    </form>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        {{-- Aperçu lettre --}}
        <div class="card border-0 shadow-sm p-4" style="font-family:'Times New Roman',serif;font-size:13px;line-height:1.15;color:#000">
            {{-- En-tête --}}
            <div class="row mb-1">
                <div class="col-7 text-center" style="font-size:12px;line-height:1.15">
                    <strong>Confédération Syndicale des Travailleurs du Mali</strong><br>
                    <strong>CSTM</strong><br><br>
                    <strong>Fédération de L'Education Nationale</strong><br>
                    <strong>FEN</strong><br><br>
                    <strong>Syndicat National des Enseignants du Mali</strong><br>
                    <strong>(SYNEM)</strong><br>
                    <strong>Bureau Exécutif National</strong><br>
                    <strong>BEN/SYNEM</strong><br>
                    Siège Ex Imm. SONAVIE<br>
                    au quartier du fleuve Rue : 303 / Porte : 264<br>
                    Tél : 20 23 82 59 / Fax : 20 22 02 75<br>
                    Cell : 75 41 29 84 / 65 61 81 71<br>
                    <img src="{{ asset('template-admin/assets/images/syneklogo.jpeg') }}" alt="Logo SYNEM" style="width:74px;height:74px;object-fit:contain;margin-top:4px">
                </div>
                <div class="col-5 text-center pt-5" style="font-size:12px;font-weight:bold;font-style:italic">
                    <p><em>« Unité-Action-Justice »</em></p>
                    <p style="margin-top:55px">Bamako, le {{ $lettre->date_lettre->translatedFormat('d F Y') }}</p>
                </div>
            </div>

            {{-- Destinataire --}}
            <div class="text-center mb-3 ms-auto" style="font-weight:bold;width:57%;font-size:14px">
                {!! nl2br(e($lettre->destinataire)) !!}
            </div>

            {{-- Numéro et objet --}}
            <p><strong><u><em>Lettre N°{{ $lettre->numero }}</em></u></strong></p>
            <p><strong>Objet :</strong> {!! nl2br(e($lettre->objet)) !!}</p>

            {{-- Corps --}}
            <div style="text-align:justify;white-space:pre-line">{{ $lettre->corps }}</div>

            {{-- Ampliations + Signature --}}
            <div class="row mt-3">
                <div class="col-6">
                    @if($lettre->ampliations && count($lettre->ampliations))
                        <p><strong><u>Ampliations :</u></strong></p>
                        <ul class="list-unstyled">
                            @foreach($lettre->ampliations as $a)
                                <li>- {{ $a }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="col-6 text-center">
                    <p><strong>{{ $lettre->fonction_signataire }}</strong></p>
                    <div class="d-flex justify-content-center align-items-end">
                        @if($lettre->signature_path)
                            <img src="{{ Storage::url($lettre->signature_path) }}" alt="Signature" style="max-height:85px;max-width:125px;object-fit:contain">
                        @endif
                        @if($lettre->cachet_path)
                            <img src="{{ Storage::url($lettre->cachet_path) }}" alt="Cachet" style="max-height:85px;max-width:125px;object-fit:contain">
                        @endif
                    </div>
                    <p class="mt-2"><strong>{{ $lettre->signataire }}</strong></p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header fw-semibold" style="background:#f0f4ff;color:#1547c0"><i class='bx bx-info-circle me-1'></i>Détails</div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-5 text-muted">Créé par</dt><dd class="col-7">{{ $lettre->auteur->name ?? '—' }}</dd>
                    <dt class="col-5 text-muted">Date création</dt><dd class="col-7">{{ $lettre->created_at->format('d/m/Y H:i') }}</dd>
                    <dt class="col-5 text-muted">Publication</dt>
                    <dd class="col-7"><span class="badge {{ $lettre->est_publiee ? 'bg-success' : 'bg-secondary' }}">{{ $lettre->est_publiee ? 'Publiée' : 'Masquée' }}</span></dd>
                    <dt class="col-5 text-muted">Télécharg.</dt>
                    <dd class="col-7"><span class="badge {{ $lettre->est_telechargeable ? 'bg-info' : 'bg-secondary' }}">{{ $lettre->est_telechargeable ? 'Oui' : 'Non' }}</span></dd>
                </dl>
            </div>
        </div>

        @if($lettre->pieces_jointes && count($lettre->pieces_jointes))
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header fw-semibold" style="background:#f0f4ff;color:#1547c0"><i class='bx bx-paperclip me-1'></i>Pièces jointes</div>
            <ul class="list-group list-group-flush">
                @foreach($lettre->pieces_jointes as $pj)
                <li class="list-group-item d-flex align-items-center gap-2">
                    <i class='bx bx-file text-primary'></i>
                    <a href="{{ Storage::url($pj['path']) }}" target="_blank">{{ $pj['nom'] }}</a>
                </li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form id="delete-letter-form" method="POST" action="{{ route('administration.lettres.destroy', $lettre) }}">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger w-100"><i class='bx bx-trash me-1'></i>Supprimer la lettre</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('delete-letter-form')?.addEventListener('submit', function (event) {
    event.preventDefault();
    const form = this;

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
</script>
@endpush
