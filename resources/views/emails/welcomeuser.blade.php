<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bienvenue</title>
</head>
<body>
    <h2>Bonjour {{ $name }},</h2>

    <p>Un compte vient d'être créé pour vous sur l'application <strong>SGAE</strong>.</p>

    <p>Vous pouvez y accéder à l'adresse suivante : <a href="{{ $url }}">{{ $url }}</a></p>

    <p>Voici votre mot de passe temporaire : <strong>{{ $password }}</strong></p>

    <p>Nous vous recommandons de le modifier après la première connexion.</p>

    <p>Cordialement,<br>L'équipe SGAE</p>
</body>
</html>
