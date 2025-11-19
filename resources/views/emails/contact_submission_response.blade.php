<!DOCTYPE html>
<html>
<head>
    <title>Réponse à votre soumission</title>
</head>
<body>
    @if($approved)
        <h1>Félicitations !</h1>
        <p>Votre soumission de militant a été approuvée. Vous pouvez maintenant accéder à l'espace membre.</p>
        <p>Si un compte utilisateur a été créé, vous recevrez les détails de connexion séparément.</p>
    @else
        <h1>Soumission rejetée</h1>
        <p>Malheureusement, votre soumission a été rejetée pour la raison suivante :</p>
        <p>{{ $submission->admin_comment }}</p>
        <p>Vous pouvez soumettre à nouveau avec des justificatifs corrects.</p>
    @endif
    <p>Cordialement,<br>L'équipe SYNEM</p>
</body>
</html>