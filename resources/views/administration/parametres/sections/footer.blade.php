<div class="setting-card">
    <div class="setting-card-header">
        <h5 class="mb-0"><i class="bi bi-card-text me-2"></i>Configuration du Footer</h5>
    </div>
    <div class="setting-card-body">
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <form method="POST" enctype="multipart/form-data" action="/administration/parametres/footer/update">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="address" class="form-label">Adresse</label>
                        <input type="text" class="form-control" id="address" name="address" 
                               value="{{ old('address', $footer->address ?? 'Bamako, Mali') }}" 
                               placeholder="Bamako, Mali">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="phone" class="form-label">Téléphone</label>
                        <input type="text" class="form-control" id="phone" name="phone" 
                               value="{{ old('phone', $footer->phone ?? '+223 92190993') }}" 
                               placeholder="+223 92190993">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="{{ old('email', $footer->email ?? 'contact@synem.ml') }}" 
                               placeholder="contact@synem.ml">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="organization_name" class="form-label">Nom de l'Organisation</label>
                        <input type="text" class="form-control" id="organization_name" name="organization_name" 
                               value="{{ old('organization_name', $footer->organization_name ?? 'Syndicat National des Enseignants du Mali') }}" 
                               placeholder="Syndicat National des Enseignants du Mali">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="copyright_text" class="form-label">Texte de Copyright</label>
                <input type="text" class="form-control" id="copyright_text" name="copyright_text" 
                       value="{{ old('copyright_text', $footer->copyright_text ?? '&copy; SYNEM. Tous droits réservés.') }}" 
                       placeholder="&copy; SYNEM. Tous droits réservés."
                       @if(!auth()->user()->isSuperAdmin()) disabled @endif>
                @if(!auth()->user()->isSuperAdmin())
                    <small class="form-text text-muted">Seul le super administrateur peut modifier ce champ.</small>
                @endif
            </div>

            <div class="mb-3">
                <label for="newsletter_description" class="form-label">Description Newsletter</label>
                <textarea class="form-control" id="newsletter_description" name="newsletter_description" rows="3" 
                          placeholder="Inscrivez-vous pour recevoir les dernières actualités du SYNEM.">{{ old('newsletter_description', $footer->newsletter_description ?? 'Inscrivez-vous pour recevoir les dernières actualités du SYNEM.') }}</textarea>
            </div>

            <h6 class="mb-3">Liens des Réseaux Sociaux</h6>
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="facebook_url" class="form-label">Facebook</label>
                        <input type="url" class="form-control" id="facebook_url" name="facebook_url" 
                               value="{{ old('facebook_url', $footer->facebook_url) }}" 
                               placeholder="https://facebook.com/synem">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="twitter_url" class="form-label">Twitter</label>
                        <input type="url" class="form-control" id="twitter_url" name="twitter_url" 
                               value="{{ old('twitter_url', $footer->twitter_url) }}" 
                               placeholder="https://twitter.com/synem">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="linkedin_url" class="form-label">LinkedIn</label>
                        <input type="url" class="form-control" id="linkedin_url" name="linkedin_url" 
                               value="{{ old('linkedin_url', $footer->linkedin_url) }}" 
                               placeholder="https://linkedin.com/company/synem">
                    </div>
                </div>
            </div>

            <h6 class="mb-3">Images de Galerie</h6>
            <div class="row">
                @for($i = 1; $i <= 3; $i++)
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="gallery_image_{{ $i }}" class="form-label">Image Galerie {{ $i }}</label>
                        @if($footer->{'gallery_image_' . $i})
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $footer->{'gallery_image_' . $i}) }}" 
                                     alt="Galerie {{ $i }}" class="img-thumbnail" style="max-width: 100px;">
                                <button type="button" class="btn btn-sm btn-danger ms-2 delete-gallery-image" 
                                        data-index="{{ $i }}">Supprimer</button>
                            </div>
                        @endif
                        <input type="file" class="form-control" id="gallery_image_{{ $i }}" name="gallery_image_{{ $i }}" 
                               accept="image/*">
                        <small class="form-text text-muted">Taille maximale : 5 Mo.</small>
                    </div>
                </div>
                @endfor
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.delete-gallery-image').on('click', function() {
        const index = $(this).data('index');
        if (confirm('Êtes-vous sûr de vouloir supprimer cette image ?')) {
            $.ajax({
                url: '{{ route("administration.parametres.footer.gallery_image.delete", ":index") }}'.replace(':index', index),
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function() {
                    location.reload();
                },
                error: function() {
                    showNotification('error', 'Erreur lors de la suppression.');
                }
            });
        }
    });
    
    function showNotification(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const alert = $('<div class="alert ' + alertClass + ' alert-dismissible fade show" role="alert">' +
            '<i class="bi bi-check-circle me-2"></i>' + message +
            '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
            '</div>');
        
        $('.parametres-content').prepend(alert);
        
        setTimeout(function() {
            alert.alert('close');
        }, 5000);
    }
});
</script>