<div class="setting-card">
    <div class="setting-card-header">
        <h5 class="mb-0"><i class="bi bi-card-text me-2"></i>Configuration de la Topbar</h5>
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
        <form method="POST" enctype="multipart/form-data" action="{{ route('administration.parametres.topbar.update') }}">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="phone" class="form-label">Téléphone</label>
                        <input type="text" class="form-control" id="phone" name="phone" 
                               value="{{ old('phone', $topbar->phone ?? '+223 92190993') }}" 
                               placeholder="+223 92190993">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="{{ old('email', $topbar->email ?? 'contact@synem.ml') }}" 
                               placeholder="contact@synem.ml">
                    </div>
                </div>
            </div>

            <h6 class="mb-3">Liens des Réseaux Sociaux</h6>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="facebook_url" class="form-label">Facebook</label>
                        <input type="url" class="form-control" id="facebook_url" name="facebook_url" 
                               value="{{ old('facebook_url', $topbar->facebook_url) }}" 
                               placeholder="https://facebook.com/synem">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="twitter_url" class="form-label">Twitter</label>
                        <input type="url" class="form-control" id="twitter_url" name="twitter_url" 
                               value="{{ old('twitter_url', $topbar->twitter_url) }}" 
                               placeholder="https://twitter.com/synem">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="linkedin_url" class="form-label">LinkedIn</label>
                        <input type="url" class="form-control" id="linkedin_url" name="linkedin_url" 
                               value="{{ old('linkedin_url', $topbar->linkedin_url) }}" 
                               placeholder="https://linkedin.com/company/synem">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="instagram_url" class="form-label">Instagram</label>
                        <input type="url" class="form-control" id="instagram_url" name="instagram_url" 
                               value="{{ old('instagram_url', $topbar->instagram_url) }}" 
                               placeholder="https://instagram.com/synem">
                    </div>
                </div>
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
