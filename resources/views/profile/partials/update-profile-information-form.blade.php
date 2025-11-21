<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
    @csrf
    @method('patch')

    <div class="mb-3">
        <label for="photo" class="form-label">Photo de profil</label>
        <div class="d-flex align-items-center gap-3">
            <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('template-admin/assets/images/default-user.jpg') }}"
                 alt="Photo de profil" class="rounded-circle" style="width: 64px; height: 64px; object-fit: cover;">
            <input id="photo" name="photo" type="file" class="form-control" accept="image/*" />
        </div>
        @error('photo')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="name" class="form-label">Nom</label>
        <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
        @error('name')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username" />
        @error('email')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="mt-2">
                <p class="text-muted small">
                    Votre adresse email n'est pas vérifiée.

                    <button form="send-verification" class="btn btn-link p-0 text-decoration-none">
                        Cliquez ici pour renvoyer l'email de vérification.
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p class="text-success mt-2 small">
                        Un nouveau lien de vérification a été envoyé à votre adresse email.
                    </p>
                @endif
            </div>
        @endif
    </div>

    <div class="d-flex align-items-center gap-3">
        <button type="submit" class="btn btn-primary">Enregistrer</button>

        @if (session('status') === 'profile-updated')
            <div class="alert alert-success py-1 px-3 mb-0">
                <small>Profil mis à jour avec succès.</small>
            </div>
        @endif
    </div>
</form>
