<div class="parametres-section active">
    <h4 class="mb-4">Gestion des Utilisateurs Admin</h4>

    <div class="setting-card">
        <div class="setting-card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Liste des Administrateurs</h5>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="bx bx-plus me-1"></i> Ajouter un admin
            </button>
        </div>
        <div class="setting-card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Nom complet</th>
                            <th>Email</th>
                            <th>Fonction</th>
                            <th>WhatsApp</th>
                            <th>Rôle</th>
                            <th>Statut</th>
                            <th>Dernière connexion</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="fw-semibold">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->fonction ?? '—' }}</td>
                            <td>
                                @if($user->whatsapp)
                                    <a href="https://wa.me/223{{ ltrim($user->whatsapp,'0') }}" target="_blank"
                                       class="badge bg-success text-decoration-none" style="font-size:12px">
                                        <i class="bx bxl-whatsapp me-1"></i>{{ $user->whatsapp }}
                                    </a>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td>
                                @if($user->isSuperAdmin())
                                    <span class="badge bg-success">Super Admin</span>
                                @else
                                    <span class="badge bg-info">Admin</span>
                                @endif
                            </td>
                            <td>
                                @if($user->is_active)
                                    <span class="badge bg-success">Actif</span>
                                @else
                                    <span class="badge bg-danger">Inactif</span>
                                @endif
                            </td>
                            <td>{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Jamais' }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary edit-user-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editUserModal"
                                        data-user-id="{{ $user->id }}"
                                        data-user-name="{{ $user->name }}"
                                        data-user-email="{{ $user->email }}"
                                        data-user-role="{{ $user->role }}"
                                        data-user-active="{{ $user->is_active ? '1' : '0' }}"
                                        data-user-whatsapp="{{ $user->whatsapp ?? '' }}"
                                        data-user-fonction="{{ $user->fonction ?? '' }}"
                                        title="Éditer">
                                    <i class="bx bx-edit"></i>
                                </button>

                                @if(!$user->isSuperAdmin())
                                    <form action="{{ route('administration.parametres.utilisateurs.toggle-status', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-warning ms-1"
                                            title="{{ $user->is_active ? 'Désactiver' : 'Activer' }}">
                                            <i class="bx {{ $user->is_active ? 'bx-power-off' : 'bx-check-circle' }}"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('administration.parametres.utilisateurs.destroy', $user->id) }}" method="POST" class="d-inline delete-user-form">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger ms-1 delete-user-btn" title="Supprimer">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ajout Utilisateur -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bx bx-user-plus me-2"></i>Ajouter un administrateur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('administration.parametres.utilisateurs.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nom complet <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" required placeholder="Prénom NOM">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="admin@synem.ml">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Fonction</label>
                        <input type="text" class="form-control" name="fonction" placeholder="Ex : Secrétaire Général, Trésorier...">
                        <small class="text-muted">Affiché dans le bouton WhatsApp du site public.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="bx bxl-whatsapp text-success me-1"></i>Numéro WhatsApp
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">+223</span>
                            <input type="text" class="form-control" name="whatsapp" placeholder="75 XX XX XX" maxlength="20">
                        </div>
                        <small class="text-muted">Numéro malien sans indicatif. Sera visible sur le site public.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mot de passe <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Confirmer le mot de passe <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="password_confirmation" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Rôle <span class="text-danger">*</span></label>
                        <select class="form-select" name="role" required>
                            <option value="admin">Admin</option>
                            @if(Auth::user()->isSuperAdmin())
                                <option value="superadmin">Super Admin</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary"><i class="bx bx-save me-1"></i>Créer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Édition Utilisateur -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bx bx-edit me-2"></i>Modifier l'administrateur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editUserForm" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nom complet <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Fonction</label>
                        <input type="text" class="form-control" id="edit_fonction" name="fonction" placeholder="Ex : Secrétaire Général">
                        <small class="text-muted">Affiché dans le bouton WhatsApp du site public.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="bx bxl-whatsapp text-success me-1"></i>Numéro WhatsApp
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">+223</span>
                            <input type="text" class="form-control" id="edit_whatsapp" name="whatsapp" maxlength="20">
                        </div>
                        <small class="text-muted">Numéro malien sans indicatif.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nouveau mot de passe <small class="text-muted">(laisser vide pour ne pas changer)</small></label>
                        <input type="password" class="form-control" id="edit_password" name="password">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Confirmer le mot de passe</label>
                        <input type="password" class="form-control" name="password_confirmation">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Rôle <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_role" name="role" required>
                            <option value="admin">Admin</option>
                            @if(Auth::user()->isSuperAdmin())
                                <option value="superadmin">Super Admin</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="edit_is_active" name="is_active" value="1">
                        <label class="form-check-label" for="edit_is_active">Utilisateur actif</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary"><i class="bx bx-save me-1"></i>Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Pré-remplir le modal d'édition
    document.querySelectorAll('.edit-user-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.getElementById('edit_name').value     = this.dataset.userName;
            document.getElementById('edit_email').value    = this.dataset.userEmail;
            document.getElementById('edit_role').value     = this.dataset.userRole;
            document.getElementById('edit_is_active').checked = this.dataset.userActive === '1';
            document.getElementById('edit_whatsapp').value = this.dataset.userWhatsapp;
            document.getElementById('edit_fonction').value = this.dataset.userFonction;
            document.getElementById('edit_password').value = '';
            document.getElementById('editUserForm').action =
                `/administration/parametres/utilisateurs/${this.dataset.userId}`;
        });
    });

    // Reset modals à la fermeture
    document.getElementById('addUserModal').addEventListener('hidden.bs.modal', function () {
        this.querySelector('form').reset();
    });
    document.getElementById('editUserModal').addEventListener('hidden.bs.modal', function () {
        this.querySelector('form').reset();
    });

    // SweetAlert suppression
    document.querySelectorAll('.delete-user-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const form = btn.closest('form');
            Swal.fire({
                title: 'Supprimer cet utilisateur ?',
                text: 'Cette action est irréversible !',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler'
            }).then(function (result) {
                if (result.isConfirmed) form.submit();
            });
        });
    });
});
</script>
