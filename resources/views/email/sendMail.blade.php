<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mail</title>
</head>
<body>

    <p>Bonjour {{ $user->prenom }} {{ $user->nom }},</p>
    <p>Votre demande d'accès à notre API a été approuvée. Voici votre jeton API :</p>
    <p><strong>{{ $user->remember_token }}</strong></p>
    <p>Utilisez ce jeton pour accéder à l'API. Merci de votre confiance.</p>
    <p>Cordialement, <br> L'équipe</p>

</body>
</html>
