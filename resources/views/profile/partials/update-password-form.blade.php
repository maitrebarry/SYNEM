<form method="post" action="{{ route('password.update') }}">
    @csrf
    @method('put')

    <div class="mb-3">
        <label for="update_password_current_password" class="form-label">Mot de passe actuel</label>
        <input id="update_password_current_password" name="current_password" type="password" class="form-control" autocomplete="current-password" />
        @error('current_password')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="update_password_password" class="form-label">Nouveau mot de passe</label>
        <input id="update_password_password" name="password" type="password" class="form-control" autocomplete="new-password" />
        @error('password')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="update_password_password_confirmation" class="form-label">Confirmer le mot de passe</label>
        <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" />
        @error('password_confirmation')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex align-items-center gap-3">
        <button type="submit" class="btn btn-primary">Changer le mot de passe</button>

        @if (session('status') === 'password-updated')
            <div class="alert alert-success py-1 px-3 mb-0">
                <small>Mot de passe mis à jour avec succès.</small>
            </div>
        @endif
    </div>
</form>
