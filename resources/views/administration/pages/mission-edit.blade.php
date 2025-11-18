@extends('layouts.administration')

@section('content')
<div class="container-fluid py-4">
    <h2 class="mb-4">Notre Mission</h2>

    {{-- Mission principale --}}
    <div class="card mb-4">
        <div class="card-header">Mission principale</div>
        <div class="card-body">
            <form method="POST" action="{{ route('administration.pages.mission.update.main') }}" class="section-form">
                @csrf
                <textarea name="mission_main" class="form-control mb-2" rows="5">Promouvoir le dialogue social, valoriser le métier d’enseignant, défendre les droits et améliorer les conditions de travail des enseignants du Mali.</textarea>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>

    {{-- Image de la mission --}}
    <div class="card mb-4">
        <div class="card-header">Image de la mission</div>
        <div class="card-body">
            <form method="POST" action="{{ route('administration.pages.mission.update.image') }}" enctype="multipart/form-data" class="section-form">
                @csrf
                <div class="mb-2">
                    <img src="{{ asset('images/static/mission-demo.jpg') }}" alt="Image Mission" class="img-fluid mb-2" style="max-width:300px;">
                    <button type="button" class="btn btn-danger btn-sm">Supprimer</button>
                </div>
                <input type="file" name="image" class="form-control mb-2">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>

    {{-- Documents de mission --}}
    <div class="card mb-4">
        <div class="card-header">Documents de mission</div>
        <div class="card-body">
            <form method="POST" action="{{ route('administration.pages.mission.update.documents') }}" enctype="multipart/form-data" class="section-form">
                @csrf
                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fa fa-file-pdf-o text-danger"></i> Mission SYNEM.pdf</span>
                        <button type="button" class="btn btn-danger btn-sm">Supprimer</button>
                    </li>
                </ul>
                <input type="file" name="documents[]" class="form-control mb-2" multiple>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>
</div>

@php
$section = session('success_section');
@endphp

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Confirmation suppression image
    document.querySelectorAll('.card-body .btn-danger.btn-sm').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            if (confirm('Voulez-vous vraiment supprimer ce fichier ?')) {
                // Soumettre le formulaire de suppression si présent
            }
        });
    });

    // Aperçu image upload
    document.querySelectorAll('input[type="file"][name="image"]').forEach(function(input) {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(ev) {
                    const img = input.closest('.card-body').querySelector('img');
                    if (img) img.src = ev.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    });

    // Reset section après succès
    var section = "{{ $section }}";
    if (section) {
        if (section === 'main') {
            document.querySelector('textarea[name="mission_main"]').value = '';
        } else if (section === 'image') {
            document.querySelector('input[name="image"]').value = '';
        } else if (section === 'documents') {
            document.querySelector('input[name="documents[]"]').value = '';
        }
    }
});
</script>
@endpush

@endsection
