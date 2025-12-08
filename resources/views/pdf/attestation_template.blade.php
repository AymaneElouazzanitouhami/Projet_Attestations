<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Attestation</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 14px;
            color: #333;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 16px;
            font-weight: normal;
        }
        .content {
            margin: 20px 40px;
        }
        .title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 30px;
            text-decoration: underline;
        }
        .student-info {
            margin-bottom: 20px;
        }
        .student-info p {
            margin: 5px 0;
        }
        .body-text {
            text-align: justify;
            margin-bottom: 50px;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .signature {
            text-align: right;
            margin-top: 50px;
            margin-right: 20px;
        }
        .strong {
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>ENSA Tétouan</h1>
        <h2>École Nationale des Sciences Appliquées</h2>
        <p>Université Abdelmalek Essaâdi</p>
    </div>

    <div class="content">

        <!-- Titre Dynamique selon le type -->
        <div class="title">
            @if($demande->type_document == 'scolarite')
                ATTESTATION DE SCOLARITÉ
            @elseif($demande->type_document == 'reussite')
                ATTESTATION DE RÉUSSITE
            @elseif($demande->type_document == 'non_redoublement')
                ATTESTATION DE NON-REDOUBLEMENT
            @elseif($demande->type_document == 'releve_notes')
                RELEVÉ DE NOTES PROVISOIRE
            @endif
        </div>

        <div class="body-text">
            <p>Le Directeur de l'École Nationale des Sciences Appliquées de Tétouan atteste que l'étudiant(e) :</p>

            <div class="student-info" style="margin-left: 20px; border-left: 4px solid #ddd; padding-left: 10px;">
                <p>Nom et Prénom : <span class="strong">{{ strtoupper($etudiant->nom ?? '') }} {{ ucfirst($etudiant->prenom ?? '') }}</span></p>
                <p>Code Apogée : <span class="strong">{{ $etudiant->numero_apogee ?? 'N/A' }}</span></p>
                <p>CIN : <span class="strong">{{ $etudiant->cin ?? 'N/A' }}</span></p>
                @if($etudiant->filiere_actuelle)
                    <p>Filière : <span class="strong">{{ $etudiant->filiere_actuelle }}</span></p>
                @endif
                @if($etudiant->niveau_actuel)
                    <p>Niveau : <span class="strong">{{ $etudiant->niveau_actuel }}ère année</span></p>
                @endif
            </div>

            <!-- Contenu Dynamique selon le type -->
            @if($demande->type_document == 'scolarite')
                <p>Est régulièrement inscrit(e) au titre de l'année universitaire <strong>{{ date('Y') }}/{{ date('Y')+1 }}</strong>.</p>
                <p>Cette attestation est délivrée à l'intéressé(e) pour servir et valoir ce que de droit.</p>
            
            @elseif($demande->type_document == 'reussite')
                <p>A validé avec succès les examens de la session ordinaire de l'année universitaire <strong>{{ $demande->annee_universitaire ?? date('Y').'/'.(date('Y')+1) }}</strong>.</p>
                <p>Le jury a délibéré et déclaré l'étudiant(e) ADMIS(E).</p>

            @elseif($demande->type_document == 'non_redoublement')
                <p>A poursuivi ses études au sein de notre établissement sans aucun redoublement depuis son inscription initiale.</p>
                @if($demande->annee_universitaire)
                    <p>Année universitaire : <strong>{{ $demande->annee_universitaire }}</strong></p>
                @endif
            
            @elseif($demande->type_document == 'releve_notes')
                <p>A obtenu les résultats suivants :</p>
                @php
                    // Normaliser le semestre demandé (ex: 1 ou S1 -> 1)
                    $demandeSem = isset($demande->semestre) ? preg_replace('/[^0-9]/', '', (string)$demande->semestre) : '1';
                    $demandeAnnee = $demande->annee_universitaire ?? '';

                    // Filtrer les notes de l'étudiant pour l'année et le semestre demandés
                    $filteredNotes = $etudiant->notes->filter(function($n) use ($demandeAnnee, $demandeSem) {
                        $noteSem = preg_replace('/[^0-9]/', '', (string)$n->semestre);
                        return trim($n->annee_universitaire) == trim($demandeAnnee) && $noteSem == $demandeSem;
                    });
                @endphp

                <table width="100%" border="1" cellspacing="0" cellpadding="5" style="border-collapse: collapse; margin-top: 15px;">
                    <tr style="background-color: #f0f0f0;">
                        <th>Module</th>
                        <th>Note / 20</th>
                        <th>Résultat</th>
                    </tr>

                    @if($filteredNotes->isEmpty())
                        <tr>
                            <td colspan="3" style="text-align: center; color: #999;">Aucune note disponible</td>
                        </tr>
                    @else
                        @foreach($filteredNotes as $note)
                            <tr>
                                <td>{{ $note->module_name }}</td>
                                <td>{{ number_format($note->note, 2) }}</td>
                                <td>{{ $note->resultat }}</td>
                            </tr>
                        @endforeach
                    @endif

                    <tr style="font-weight: bold;">
                        <td colspan="2" style="text-align: right;">Moyenne Générale :</td>
                        <td>
                            @php
                                $moyenne = $filteredNotes->isNotEmpty() ? number_format($filteredNotes->avg('note'), 2) : '0.00';
                            @endphp
                            {{ $moyenne }}
                        </td>
                    </tr>
                </table>
            @endif

        </div>

        <div class="signature">
            <p>Fait à Tétouan, le {{ now()->format('d/m/Y') }}</p>
            <br><br>
            <p style="font-style: italic;">Le Directeur</p>
            <p style="color: #999;">(Signature Électronique)</p>
        </div>

    </div>

    <div class="footer">
        ENSA Tétouan - Avenue de la Palestine Mhanech I, Tétouan - Maroc <br>
        Tél: 0539968802 - Email: scolarite@ensa-tetouan.ac.ma
    </div>

</body>
</html>