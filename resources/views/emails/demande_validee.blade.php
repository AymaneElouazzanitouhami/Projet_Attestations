<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Attestation validée</title>
</head>
<body>
    <p>Bonjour {{ $etudiant->prenom }} {{ $etudiant->nom }},</p>

    <p>Votre demande d'<strong>
        @if($demande->type_document == 'scolarite')
            attestation de scolarité
        @elseif($demande->type_document == 'non_redoublement')
            attestation de non-redoublement
        @elseif($demande->type_document == 'reussite')
            attestation de réussite
        @elseif($demande->type_document == 'releve_notes')
            relevé de notes
        @else
            attestation
        @endif
    </strong> a été <strong>validée</strong> par le service de scolarité de l'ENSA Tétouan.</p>

    <p>Vous trouverez votre attestation en pièce jointe à ce message, au format PDF.</p>

    <p>Cet email est généré automatiquement, merci de ne pas y répondre.</p>

    <p>Cordialement,<br>
    Service de scolarité – ENSA Tétouan</p>
</body>
</html>