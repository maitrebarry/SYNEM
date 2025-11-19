@extends('layouts.administration')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4">Soumissions - Devenir militant</h4>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped" id="submissionsTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Organisation</th>
                        <th>Statut</th>
                        <th>Soumis le</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($submissions as $s)
                        <tr data-id="{{ $s->id }}">
                            <td>{{ $s->id }}</td>
                            <td>{{ $s->name }}</td>
                            <td>{{ $s->email }}</td>
                            <td>{{ $s->organisation }}</td>
                            <td><span class="badge bg-{{ $s->status == 'pending' ? 'warning' : ($s->status == 'approved' ? 'success' : 'danger') }}">{{ ucfirst($s->status) }}</span></td>
                            <td>{{ $s->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary btn-view" data-id="{{ $s->id }}">Voir</button>
                                @if($s->status == 'pending')
                                    <button class="btn btn-sm btn-success btn-approve" data-id="{{ $s->id }}">Approuver</button>
                                    <button class="btn btn-sm btn-danger btn-reject" data-id="{{ $s->id }}">Rejeter</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="submissionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Détails de la soumission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="submissionContent">Chargement...</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-success" id="modalApprove">Approuver</button>
                    <button type="button" class="btn btn-danger" id="modalReject">Rejeter</button>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const submissionModal = new bootstrap.Modal(document.getElementById('submissionModal'));
    let currentId = null;

    document.querySelectorAll('.btn-view').forEach(btn => {
        btn.addEventListener('click', async function() {
            const id = this.dataset.id;
            currentId = id;
            document.getElementById('submissionContent').innerHTML = 'Chargement...';
            submissionModal.show();

            const res = await fetch(`{{ url('administration/contact/submissions') }}/${id}`);
            if (!res.ok) {
                document.getElementById('submissionContent').innerText = 'Erreur au chargement';
                return;
            }
            const data = await res.json();
            let html = `<p><strong>Nom:</strong> ${data.name}</p>`;
            html += `<p><strong>Email:</strong> ${data.email}</p>`;
            html += `<p><strong>Téléphone:</strong> ${data.phone || '-'} </p>`;
            html += `<p><strong>Organisation:</strong> ${data.organisation || '-'} </p>`;
            html += `<p><strong>Message:</strong><br/> ${data.message || '-'}</p>`;
            if (data.attachment) {
                html += `<p><strong>Pièce jointe:</strong> <a href="{{ url('administration/contact/submissions') }}/${id}/attachment" target="_blank">Télécharger / Voir</a></p>`;
            }
            document.getElementById('submissionContent').innerHTML = html;
        });
    });

    async function postAction(action, comment = '') {
        if (!currentId) return;
        const res = await fetch(`{{ url('administration/contact/submissions') }}/${currentId}/${action}`, {
            method: 'POST',
            headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 'Content-Type': 'application/json'},
            body: JSON.stringify({comment})
        });
        if (res.ok) {
            location.reload();
        } else {
            alert('Erreur');
        }
    }

    document.getElementById('modalApprove').addEventListener('click', function() {
        if (!confirm('Confirmer approbation ?')) return;
        postAction('approve');
    });

    document.getElementById('modalReject').addEventListener('click', function() {
        const reason = prompt('Motif du rejet (optionnel) :');
        if (reason === null) return;
        postAction('reject', reason);
    });

    document.querySelectorAll('.btn-approve').forEach(b => b.addEventListener('click', async function() {
        if (!confirm('Approuver cette soumission ?')) return;
        const id = this.dataset.id;
        await fetch(`{{ url('administration/contact/submissions') }}/${id}/approve`, {method: 'POST', headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')}});
        location.reload();
    }));

    document.querySelectorAll('.btn-reject').forEach(b => b.addEventListener('click', async function() {
        const reason = prompt('Motif du rejet (optionnel) :');
        if (reason === null) return;
        const id = this.dataset.id;
        await fetch(`{{ url('administration/contact/submissions') }}/${id}/reject`, {method: 'POST', headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')}, body: JSON.stringify({comment: reason})});
        location.reload();
    }));
});
</script>
@endsection

@endsection
