<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Export Militants</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
        h1 { font-size: 20px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Liste des militants exportée le {{ $generatedAt->format('d/m/Y H:i') }}</h1>
    <table>
        <thead>
            <tr>
                <th>N°</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>N° Carte Syndicale</th>
                <th>Coordination</th>
                <th>Statut</th>
                <th>Date de soumission</th>
            </tr>
        </thead>
        <tbody>
            @forelse($militants as $index => $militant)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $militant->nom }}</td>
                <td>{{ $militant->prenom }}</td>
                <td>{{ $militant->email }}</td>
                <td>{{ $militant->tel ?: '-' }}</td>
                <td>{{ $militant->n_cartes_syndicale ?: '-' }}</td>
                <td>{{ $militant->coordinations ?: '-' }}</td>
                <td>
                    @switch($militant->status)
                        @case('approved') Approuvé @break
                        @case('rejected') Rejeté @break
                        @default En attente
                    @endswitch
                </td>
                <td>{{ $militant->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9">Aucun militant à afficher.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
