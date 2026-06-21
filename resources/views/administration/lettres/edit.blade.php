@extends('layouts.administration')
@section('title', 'Modifier Lettre ' . $lettre->numero)

@section('content')
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">SYNEM</div>
    <div class="ps-3"><nav aria-label="breadcrumb"><ol class="breadcrumb mb-0 p-0">
        <li class="breadcrumb-item"><a href="{{ route('administration.tableau-de-bord') }}"><i class="bx bx-home-alt"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ route('administration.lettres.index') }}">Lettres</a></li>
        <li class="breadcrumb-item active">Modifier</li>
    </ol></nav></div>
</div>

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('administration.lettres.show', $lettre) }}" class="btn btn-outline-secondary btn-sm"><i class='bx bx-arrow-back'></i></a>
    <h4 class="mb-0 fw-bold" style="color:#1547c0"><i class='bx bx-edit me-2'></i>Modifier : {{ $lettre->numero }}</h4>
</div>

@if($errors->any())
<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
@endif

<form method="POST" action="{{ route('administration.lettres.update', $lettre) }}" enctype="multipart/form-data">
@csrf @method('PUT')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header fw-semibold" style="background:#f0f4ff;color:#1547c0"><i class='bx bx-info-circle me-2'></i>Informations générales</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">N° de la lettre <span class="text-danger">*</span></label>
                        <input type="text" name="numero" class="form-control" value="{{ old('numero', $lettre->numero) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Date <span class="text-danger">*</span></label>
                        <input type="date" name="date_lettre" class="form-control" value="{{ old('date_lettre', $lettre->date_lettre->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Destinataire <span class="text-danger">*</span></label>
                        <textarea name="destinataire" class="form-control" rows="3" required>{{ old('destinataire', $lettre->destinataire) }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Objet <span class="text-danger">*</span></label>
                        <input type="text" name="objet" class="form-control" value="{{ old('objet', $lettre->objet) }}" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header fw-semibold" style="background:#f0f4ff;color:#1547c0">
                <div class="d-flex align-items-center justify-content-between">
                    <span><i class='bx bx-text me-2'></i>Corps de la lettre <span class="text-danger">*</span></span>
                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalIA">
                        <i class='bx bx-brain me-1'></i> Assistance IA
                    </button>
                </div>
            </div>
            <div class="card-body">
                <textarea name="corps" id="corps" class="form-control" rows="14" required>{{ old('corps', $lettre->corps) }}</textarea>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header fw-semibold" style="background:#f0f4ff;color:#1547c0"><i class='bx bx-list-ul me-2'></i>Ampliations</div>
            <div class="card-body">
                <textarea name="ampliations" class="form-control" rows="4">{{ old('ampliations', $lettre->ampliations ? implode("\n", $lettre->ampliations) : '') }}</textarea>
                <small class="text-muted">Une ampliation par ligne.</small>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header fw-semibold" style="background:#f0f4ff;color:#1547c0"><i class='bx bx-pen me-2'></i>Signature</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Signataire <span class="text-danger">*</span></label>
                    <input type="text" name="signataire" class="form-control" value="{{ old('signataire', $lettre->signataire) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Fonction <span class="text-danger">*</span></label>
                    <input type="text" name="fonction_signataire" class="form-control" value="{{ old('fonction_signataire', $lettre->fonction_signataire) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nouveau cachet (optionnel)</label>
                    @if($lettre->cachet_path)
                        <div class="mb-2"><img src="{{ Storage::url($lettre->cachet_path) }}" style="max-height:60px" alt="Cachet actuel"></div>
                    @endif
                    <input type="file" name="cachet" class="form-control" accept="image/*">
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header fw-semibold" style="background:#f0f4ff;color:#1547c0"><i class='bx bx-cog me-2'></i>Options</div>
            <div class="card-body">
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="est_publiee" id="est_publiee" value="1" {{ old('est_publiee', $lettre->est_publiee) ? 'checked' : '' }}>
                    <label class="form-check-label" for="est_publiee"><strong>Publier</strong> dans les Actualités</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="est_telechargeable" id="est_telechargeable" value="1" {{ old('est_telechargeable', $lettre->est_telechargeable) ? 'checked' : '' }}>
                    <label class="form-check-label" for="est_telechargeable"><strong>Téléchargeable</strong> par les militants</label>
                </div>
            </div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary btn-lg"><i class='bx bx-save me-2'></i>Enregistrer les modifications</button>
            <a href="{{ route('administration.lettres.show', $lettre) }}" class="btn btn-outline-secondary">Annuler</a>
        </div>
    </div>
</div>
</form>

{{-- Modal IA (identique à create) --}}
<div class="modal fade" id="modalIA" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background:linear-gradient(135deg,#1547c0,#0a2a7a);color:#fff">
                <h5 class="modal-title"><i class='bx bx-brain me-2'></i>Assistance IA — Rédaction Syndicale</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info py-2 mb-3"><i class='bx bx-info-circle me-1'></i>Assistant propulsé par le quota gratuit Groq.</div>
                <textarea id="iaPrompt" class="form-control mb-3" rows="5" placeholder="Décrivez votre demande ou collez le texte à améliorer..."></textarea>
                <button type="button" id="btnIA" class="btn btn-primary"><i class='bx bx-send me-1'></i><span id="btnIAText">Générer</span></button>
                <div id="iaResult" class="mt-3 d-none">
                    <textarea id="iaResultText" class="form-control" rows="10"></textarea>
                    <button type="button" id="btnInserer" class="btn btn-success mt-2 w-100"><i class='bx bx-import me-1'></i>Insérer dans le corps</button>
                </div>
                <div id="iaError" class="alert alert-danger mt-3 d-none"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('btnIA').addEventListener('click', function() {
    const prompt = document.getElementById('iaPrompt').value.trim();
    if (!prompt) return;
    this.disabled = true;
    document.getElementById('btnIAText').textContent = 'Génération...';
    document.getElementById('iaResult').classList.add('d-none');
    document.getElementById('iaError').classList.add('d-none');
    fetch('{{ route('administration.lettres.ia') }}', {
        method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
        body: JSON.stringify({prompt})
    }).then(r=>r.json()).then(data=>{
        if(data.error){document.getElementById('iaError').textContent=data.error;document.getElementById('iaError').classList.remove('d-none');}
        else{document.getElementById('iaResultText').value=data.result;document.getElementById('iaResult').classList.remove('d-none');}
    }).finally(()=>{this.disabled=false;document.getElementById('btnIAText').textContent='Générer';});
});
document.getElementById('btnInserer').addEventListener('click',function(){
    document.getElementById('corps').value=document.getElementById('iaResultText').value;
    bootstrap.Modal.getInstance(document.getElementById('modalIA')).hide();
});
</script>
@endpush
