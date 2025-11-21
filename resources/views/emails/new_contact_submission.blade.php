<!DOCTYPE html>
<html>
<head>
    <title>Nouvelle soumission de militant</title>
</head>
<body>
    <h1>Nouvelle soumission de militant</h1>
    <p>Un nouveau militant a soumis ses justificatifs :</p>
    <ul>
        <li><strong>Nom :</strong> {{ $submission->name }}</li>
        <li><strong>Email :</strong> {{ $submission->email }}</li>
        <li><strong>Téléphone :</strong> {{ $submission->phone }}</li>
        <li><strong>Coordonnées :</strong> {{ $submission->coordinates }}</li>
        <li><strong>Message :</strong> {{ $submission->message }}</li>
        <li><strong>Statut :</strong> {{ $submission->status }}</li>
        @if($submission->attachment)
            <li><strong>Justificatif :</strong> <a href="{{ route('administration.contact.submissions.attachment', $submission->id) }}">Télécharger</a></li>
        @endif
    </ul>
    <p>Veuillez examiner et approuver ou rejeter la soumission.</p>
</body>
</html>