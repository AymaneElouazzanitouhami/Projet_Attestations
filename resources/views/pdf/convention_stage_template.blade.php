<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Convention de Stage</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 14px;
            font-weight: normal;
        }
        .content {
            margin: 20px 40px;
        }
        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 20px;
            text-decoration: underline;
        }
        .section {
            margin-bottom: 20px;
        }
        .section h3 {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            text-decoration: underline;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .info-table td {
            padding: 5px;
            border: 1px solid #ddd;
        }
        .info-table .label {
            font-weight: bold;
            background-color: #f9f9f9;
            width: 30%;
        }
        .signature-section {
            margin-top: 50px;
            display: table;
            width: 100%;
        }
        .signature-box {
            display: table-cell;
            width: 30%;
            text-align: center;
            vertical-align: top;
        }
        .signature-box p {
            margin: 5px 0;
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
    </style>
</head>
<body>

    <div class="header">
        <h1>ENSA Tétouan</h1>
        <h2>École Nationale des Sciences Appliquées</h2>
        <p>Université Abdelmalek Essaâdi</p>
    </div>

    <div class="content">

        <div class="title">
            CONVENTION DE STAGE
        </div>

        <div class="section">
            <h3>1. Informations sur l'Étudiant</h3>
            <table class="info-table">
                <tr>
                    <td class="label">Nom et Prénom :</td>
                    <td>{{ strtoupper($etudiant->nom ?? '') }} {{ ucfirst($etudiant->prenom ?? '') }}</td>
                </tr>
                <tr>
                    <td class="label">Code Apogée :</td>
                    <td>{{ $etudiant->numero_apogee ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">CIN :</td>
                    <td>{{ $etudiant->cin ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">Filière :</td>
                    <td>{{ $etudiant->filiere_actuelle ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">Niveau :</td>
                    <td>{{ $etudiant->niveau_actuel ?? 'N/A' }}ère année</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <h3>2. Informations sur l'Entreprise</h3>
            <table class="info-table">
                <tr>
                    <td class="label">Nom de l'Entreprise :</td>
                    <td>{{ $convention->nom_entreprise }}</td>
                </tr>
                <tr>
                    <td class="label">Adresse :</td>
                    <td>{{ $convention->adresse_entreprise }}</td>
                </tr>
                <tr>
                    <td class="label">Email :</td>
                    <td>{{ $convention->email_entreprise }}</td>
                </tr>
                <tr>
                    <td class="label">Encadrant en Entreprise :</td>
                    <td>{{ $convention->nom_encadrant_entreprise }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <h3>3. Détails du Stage</h3>
            <table class="info-table">
                <tr>
                    <td class="label">Sujet du Stage :</td>
                    <td>{{ $convention->sujet_stage }}</td>
                </tr>
                <tr>
                    <td class="label">Durée :</td>
                    <td>{{ $convention->duree_stage }}</td>
                </tr>
                <tr>
                    <td class="label">Date de Début :</td>
                    <td>{{ $convention->date_debut ? $convention->date_debut->format('d/m/Y') : 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">Date de Fin :</td>
                    <td>{{ $convention->date_fin ? $convention->date_fin->format('d/m/Y') : 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">Encadrant à l'École :</td>
                    <td>{{ $convention->nom_encadrant_ecole }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <h3>4. Engagements</h3>
            <p>Le présent document constitue une convention de stage entre l'École Nationale des Sciences Appliquées de Tétouan, l'étudiant(e) et l'entreprise d'accueil.</p>
            <p>L'étudiant(e) s'engage à respecter les règles et horaires de l'entreprise. L'entreprise s'engage à fournir un encadrement approprié et à respecter la législation du travail.</p>
            <p>L'école s'engage à valider le stage selon les critères pédagogiques établis.</p>
        </div>

        <div class="section">
            <p>Fait à Tétouan, le {{ now()->format('d/m/Y') }}</p>
        </div>

        <div class="signature-section">
            <div class="signature-box">
                <p><strong>L'Étudiant(e)</strong></p>
                <p>{{ strtoupper($etudiant->nom ?? '') }} {{ ucfirst($etudiant->prenom ?? '') }}</p>
                <br><br><br>
                <p>Signature</p>
            </div>
            <div class="signature-box">
                <p><strong>L'Entreprise</strong></p>
                <p>{{ $convention->nom_encadrant_entreprise }}</p>
                <br><br><br>
                <p>Signature</p>
            </div>
            <div class="signature-box">
                <p><strong>L'École</strong></p>
                <p>{{ $convention->nom_encadrant_ecole }}</p>
                <br><br><br>
                <p>Signature</p>
            </div>
        </div>

    </div>

    <div class="footer">
        Document généré le {{ now()->format('d/m/Y à H:i') }} - Numéro de demande : {{ $demande->id_demande }}
    </div>

</body>
</html>