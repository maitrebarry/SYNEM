<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Militant approuvé</title>
</head>
<body style="font-family: 'Helvetica Neue', Arial, sans-serif; line-height: 1.6; color: #333;">
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" role="presentation" style="border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden;">
                    <tr style="background: #007bff; color: #fff;">
                        <td style="padding: 30px; text-align: center;">
                            <h1 style="margin: 0; font-size: 24px;">Votre demande de militant a été approuvée</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 30px; background: #fff;">
                            <p>Bonjour {{ $militant->prenom }} {{ $militant->nom }},</p>
                            <p>Votre dossier de militant du SYNEM a été examiné et <strong>approuvé</strong>. Félicitations&nbsp;!</p>
                            <p>Vous pouvez désormais accéder à l&rsquo;espace exclusif des <strong>documents réservés aux militants approuvés</strong> en suivant ce lien :</p>
                            <p><a href="{{ route('militant.documents.index') }}" style="color: #007bff;">Accéder aux documents militants</a></p>
                            <p>Si vous ne parvenez pas à ouvrir la page, connectez-vous d&rsquo;abord avec l&rsquo;email que vous avez utilisé pour soumettre votre demande.</p>
                            <p>Pour toute question complémentaire, répondez simplement à cet email ou contactez <strong>contact@synem-mali.org</strong>.</p>
                            <p style="margin-bottom: 0;">Fraternellement,<br>L&rsquo;équipe SYNEM</p>
                        </td>
                    </tr>
                    <tr style="background: #f8f9fa;">
                        <td style="padding: 15px; text-align: center; font-size: 12px; color: #888;">
                            <small>© {{ date('Y') }} SYNEM - Syndicat National des Enseignants du Mali</small>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
