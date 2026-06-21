<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>Carrousel d'en-tête</strong>
        <span class="badge bg-primary">{{ $carouselSlides->count() }} image(s)</span>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('administration.pages.carousels.store', $carouselPage) }}" enctype="multipart/form-data" class="border rounded p-3 mb-4">
            @csrf
            <div class="row g-3 align-items-end">
                <div class="col-lg-5">
                    <label class="form-label">Nouvelles images <span class="text-danger">*</span></label>
                    <input type="file" name="images[]" accept="image/*" multiple required class="form-control">
                    <small class="text-muted">Plusieurs images possibles, 5 Mo maximum chacune.</small>
                </div>
                <div class="col-lg-3">
                    <label class="form-label">Titre facultatif</label>
                    <input type="text" name="title" class="form-control">
                </div>
                <div class="col-lg-3">
                    <label class="form-label">Légende facultative</label>
                    <input type="text" name="caption" class="form-control">
                </div>
                <div class="col-lg-1">
                    <button class="btn btn-primary w-100" title="Ajouter"><i class="fas fa-plus"></i></button>
                </div>
            </div>
        </form>

        <div class="row g-3">
            @forelse($carouselSlides as $slide)
                <div class="col-xl-6">
                    <div class="border rounded p-3 h-100">
                        <img src="{{ $slide->image_url }}" alt="" class="w-100 rounded mb-3" style="height:150px;object-fit:cover">
                        <form method="POST" action="{{ route('administration.pages.carousels.update', $slide) }}" enctype="multipart/form-data">
                            @csrf @method('PUT')
                            <input type="hidden" name="page" value="{{ $carouselPage }}">
                            <div class="row g-2">
                                <div class="col-md-8"><input type="text" name="title" value="{{ $slide->title }}" class="form-control form-control-sm" placeholder="Titre"></div>
                                <div class="col-md-4"><input type="number" name="ordering" value="{{ $slide->ordering }}" min="0" class="form-control form-control-sm" title="Ordre"></div>
                                <div class="col-12"><textarea name="caption" class="form-control form-control-sm" rows="2" placeholder="Légende">{{ $slide->caption }}</textarea></div>
                                <div class="col-12"><input type="file" name="image" accept="image/*" class="form-control form-control-sm"></div>
                            </div>
                            <button class="btn btn-sm btn-outline-primary mt-2"><i class="fas fa-save me-1"></i>Enregistrer</button>
                        </form>
                        <form method="POST" action="{{ route('administration.pages.carousels.destroy', $slide) }}" class="page-carousel-delete d-inline">
                            @csrf @method('DELETE')
                            <input type="hidden" name="page" value="{{ $carouselPage }}">
                            <button class="btn btn-sm btn-danger mt-2"><i class="fas fa-trash me-1"></i>Supprimer</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-3">Aucune image personnalisée. L'image par défaut reste affichée sur le site.</div>
            @endforelse
        </div>
    </div>
</div>

@once
@push('scripts')
<script>
document.querySelectorAll('.page-carousel-delete').forEach(function (form) {
    form.addEventListener('submit', function (event) {
        event.preventDefault();
        Swal.fire({
            title: 'Supprimer cette image ?',
            text: 'Elle disparaîtra du carrousel public.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler'
        }).then(function (result) { if (result.isConfirmed) form.submit(); });
    });
});
</script>
@endpush
@endonce
