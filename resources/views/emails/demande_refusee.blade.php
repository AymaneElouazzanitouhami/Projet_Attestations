<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Demande refusée</title>
</head>
<body>
    <p>Bonjour {{ $demande->etudiant->prenom }} {{ $demande->etudiant->nom }},</p>

    <p>Votre demande d'attestation (n° {{ $demande->id_demande }}) a été <strong>refusée</strong>.</p>

    <p>Motif de refus :</p>
    <blockquote>{{ $motif }}</blockquote>

    <p>Pour toute question complémentaire, veuillez contacter le service de scolarité.</p>

    <p>Cordialement,<br>
    Service de scolarité – ENSA Tétouan</p>
</body>
</html>
