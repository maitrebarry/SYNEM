<div class="alert alert-warning">
    <h5 class="alert-heading">Supprimer le compte</h5>
    <p class="mb-3">Une fois votre compte supprimé, toutes ses ressources et données seront supprimées définitivement. Avant de supprimer votre compte, veuillez télécharger toutes les données ou informations que vous souhaitez conserver.</p>

    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
        Supprimer le compte
    </button>
</div>

<!-- Modal de confirmation -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAccountModalLabel">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer votre compte ?</p>
                    <p class="text-muted">Une fois votre compte supprimé, toutes ses ressources et données seront supprimées définitivement. Veuillez entrer votre mot de passe pour confirmer la suppression définitive de votre compte.</p>

                    <div class="mb-3">
                        <label for="delete_password" class="form-label">Mot de passe</label>
                        <input id="delete_password" name="password" type="password" class="form-control" placeholder="Entrez votre mot de passe" required />
                        @error('password')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Supprimer définitivement</button>
                </div>
            </form>
        </div>
    </div>
</div>
