<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Convention de Stage</title>
    <style>
        @page {
            margin: 2cm;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            color: #000;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }
        .confidential {
            text-align: right;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .header-table td {
            vertical-align: top;
        }
        .logo-section {
            width: 20%;
            text-align: left;
            padding: 0;
        }
        .title-section {
            width: 82%;
            text-align: left;
            padding-left: 10px;
        }
        .pdf-logo {
            width: 110px;
            height: auto;
            display: block;
        }
        .title-section h1 {
            margin: 0;
            font-size: 13pt;
            font-weight: bold;
        }
        .title-section p {
            margin: 3px 0;
            font-size: 10pt;
        }
        .main-title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 30px 0 20px 0;
            text-decoration: underline;
        }
        .subtitle {
            text-align: center;
            font-size: 10pt;
            font-style: italic;
            margin-bottom: 30px;
        }
        .section-title {
            font-weight: bold;
            text-transform: uppercase;
            margin: 20px 0 10px 0;
            font-size: 11pt;
        }
        .party-info {
            margin: 15px 0;
            line-height: 1.6;
        }
        .article {
            margin: 20px 0;
            text-align: justify;
        }
        .article-title {
            font-weight: bold;
            margin-bottom: 8px;
        }
        .article-content {
            margin-left: 0;
            text-align: justify;
        }
        .signature-section {
            margin-top: 50px;
            page-break-inside: avoid;
        }
        .signature-table {
            width: 100%;
            margin-top: 30px;
        }
        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 10px;
        }
        .signature-line {
            margin-top: 60px;
            border-top: 1px solid #000;
            width: 200px;
            margin-left: auto;
            margin-right: auto;
        }
        .info-line {
            border-bottom: 1px dotted #000;
            display: inline-block;
            min-width: 200px;
            padding: 0 5px;
        }
        .footer-page {
            text-align: center;
            font-size: 9pt;
            margin-top: 40px;
            padding-top: 10px;
            border-top: 1px solid #ccc;
        }
    </style>
</head>
<body>

    <div class="confidential">CONFIDENTIEL</div>

    <table class="header-table">
        <tr>
            <td class="logo-section">
                <!-- Logo placeholder -->
                <div style="font-size: 8pt;">
                    
         @php
        $canRenderLogo = extension_loaded('gd');
        $logoPath = resource_path('views/images/ensa.png');
        if (!file_exists($logoPath)) {
            $logoPath = resource_path('images/ensa.png');
        }

        $logoBase64 = null;
        if ($canRenderLogo && file_exists($logoPath)) {
            $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/' . $logoType . ';base64,' . base64_encode($logoData);
        }
    @endphp

    @if($logoBase64)
        <img src="{{ $logoBase64 }}" class="pdf-logo" alt="Logo ENSA">
    @endif
    
                </div>
            </td>
            <td class="title-section">
                <h1>Université Abdelmalek Essaâdi</h1>
                <h1>Ecole Nationale des Sciences Appliquées</h1>
                <h1>Tétouan</h1>
                <p style="margin-top: 10px; font-size: 9pt;">
                    B.P. 2222, Mhannech II, Tétouan, Maroc<br>
                    Tél. +212 5 39 68 80 27 ; Fax. +212 39 99 46 24<br>
                    Web: https://ensa-tetouan.ac.ma
                </p>
            </td>
        </tr>
    </table>

    <div class="main-title">CONVENTION DE STAGE</div>
    <div class="subtitle">(2 exemplaires imprimés en recto-verso)</div>

    <div class="section-title">ENTRE</div>
    <div class="party-info">
        <p><strong>L'Ecole Nationale des Sciences Appliquées, Université Abdelmalek Essaâdi - Tétouan</strong></p>
        <p>B.P. 2222, Mhannech II, Tétouan, Maroc</p>
        <p>Tél. +212 5 39 68 80 27 ; Fax. +212 39 99 46 24. Web: https://ensa-tetouan.ac.ma</p>
        <p>Représenté par le Professeur <strong>Kamal REKLAOUI</strong> en qualité de Directeur.</p>
        <p style="margin-top: 10px;"><em>Ci-après, dénommé l'Etablissement</em></p>
    </div>

    <div class="section-title">ET</div>
    <div class="party-info">
        <p>La Société : <span class="info-line">{{ $convention->nom_entreprise }}</span></p>
        <p>Adresse : <span class="info-line">{{ $convention->adresse_entreprise }}</span></p>
        <p> 
           Email: <span class="info-line">{{ $convention->email_entreprise }}</span></p>
        <p>Représentée par Monsieur/Madame <span class="info-line">{{ $convention->nom_encadrant_entreprise }}</span> 
           en qualité de <span class="info-line">{{ $convention->fonction_encadrant ?? 'Responsable' }}</span></p>
        <p style="margin-top: 10px;"><em>Ci-après dénommée L'ENTREPRISE</em></p>
    </div>

    <div class="article">
        <div class="article-title">Article 1 : Engagement</div>
        <div class="article-content">
            <p>L'ENTREPRISE accepte de recevoir à titre de stagiaire <strong>{{ strtoupper($etudiant->nom ?? '') }} {{ ucfirst($etudiant->prenom ?? '') }}</strong> étudiant de la filière du Cycle Ingénieur « <strong>{{ $etudiant->filiere_actuelle ?? 'N/A' }}</strong> » de l'ENSA de Tétouan, Université Abdelmalek Essaâdi (Tétouan), pour une période allant du <strong>{{ $convention->date_debut ? $convention->date_debut->format('d/m/Y') : '____/____/________' }}</strong> au <strong>{{ $convention->date_fin ? $convention->date_fin->format('d/m/Y') : '____/____/________' }}</strong>.</p>
            <p>En aucun cas, cette convention ne pourra autoriser les étudiants à s'absenter durant la période des contrôles ou des enseignements.</p>
        </div>
    </div>

    <div class="article">
        <div class="article-title">Article 2 : Objet</div>
        <div class="article-content">
            <p>Le stage aura pour objet essentiel d'assurer l'application pratique de l'enseignement donné par l'Etablissement, et ce, en organisant des visites sur les installations et en réalisant des études proposées par L'ENTREPRISE.</p>
        </div>
    </div>

    <div class="article">
        <div class="article-title">Article 3 : Encadrement et suivi</div>
        <div class="article-content">
            <p>Pour accompagner le Stagiaire durant son stage, et ainsi instaurer une véritable collaboration L'ENTREPRISE/Stagiaire/Etablissement, L'ENTREPRISE désigne <strong>{{ $convention->nom_encadrant_entreprise }}</strong> encadrant(e) et parrain(e), pour superviser et assurer la qualité du travail fourni par le Stagiaire.</p>
            <p>L'Etablissement désigne <strong>{{ $convention->nom_encadrant_ecole }}</strong> en tant que tuteur qui procurera une assistance pédagogique.</p>
        </div>
    </div>

    <div class="article">
        <div class="article-title">Article 4 : Programme</div>
        <div class="article-content">
            <p>Le thème du stage est : « <strong>{{ $convention->sujet_stage }}</strong> »</p>
            <p>Ce programme a été défini conjointement par l'Etablissement, L'ENTREPRISE et le Stagiaire.</p>
            <p>Le contenu de ce programme doit permettre au Stagiaire une réflexion en relation avec les enseignements ou le projet de fin d'études qui s'inscrit dans le programme de formation de l'Etablissement.</p>
        </div>
    </div>

    <div class="article">
        <div class="article-title">Article 5 : Indemnité de stage</div>
        <div class="article-content">
            <p>Au cours du stage, l'étudiant ne pourra prétendre à aucun salaire de la part de L'ENTREPRISE. Cependant, si l'ENTREPRISE et l'étudiant le conviennent, ce dernier pourra recevoir une indemnité forfaitaire de la part de l'ENTREPRISE des frais occasionnés par la mission confiée à l'étudiant.</p>
        </div>
    </div>

    <div class="article">
        <div class="article-title">Article 6 : Règlement</div>
        <div class="article-content">
            <p>Pendant la durée du stage, le Stagiaire reste placé sous la responsabilité de l'Etablissement. Cependant, l'étudiant est tenu d'informer l'école dans un délai de 24h sur toute modification portant sur la convention déjà signée, sinon il en assumera toute sa responsabilité sur son non-respect de la convention signée par l'école.</p>
            <p>Toutefois, le Stagiaire est soumis à la discipline et au règlement intérieur de L'ENTREPRISE.</p>
            <p>En cas de manquement, L'ENTREPRISE se réserve le droit de mettre fin au stage après en avoir convenu avec le Directeur de l'Etablissement.</p>
        </div>
    </div>

    <div class="article">
        <div class="article-title">Article 7 : Confidentialité</div>
        <div class="article-content">
            <p>Le Stagiaire et l'ensemble des acteurs liés à son travail (l'administration de l'Etablissement, le parrain pédagogique ...) sont tenus au secret professionnel. Ils s'engagent à ne pas diffuser les informations recueillies à des fins de publications, conférences, communications, sans accord préalable de L'ENTREPRISE. Cette obligation demeure valable après l'expiration du stage.</p>
        </div>
    </div>

    <div class="article">
        <div class="article-title">Article 8 : Assurance accident de travail</div>
        <div class="article-content">
            <p>Le stagiaire devra obligatoirement souscrire une assurance couvrant la Responsabilité Civile et Accident de Travail, durant les stages et trajets effectués.</p>
            <p>En cas d'accident de travail survenant durant la période du stage, L'ENTREPRISE s'engage à faire parvenir immédiatement à l'Etablissement toutes les informations indispensables à la déclaration dudit accident.</p>
        </div>
    </div>

    <div class="article">
        <div class="article-title">Article 9 : Evaluation de L'ENTREPRISE</div>
        <div class="article-content">
            <p>Le stage accompli, le parrain établira un rapport d'appréciations générales sur le travail effectué et le comportement du Stagiaire durant son séjour chez L'ENTREPRISE.</p>
            <p>L'ENTREPRISE remettra au Stagiaire une attestation indiquant la nature et la durée des travaux effectués.</p>
        </div>
    </div>

    <div class="article">
        <div class="article-title">Article 10 : Rapport de stage</div>
        <div class="article-content">
            <p>A l'issue de chaque stage, le Stagiaire rédigera un rapport de stage faisant état de ses travaux et de son vécu au sein de L'ENTREPRISE. Ce rapport sera communiqué à L'ENTREPRISE et restera strictement confidentiel.</p>
        </div>
    </div>

    <div class="signature-section">
        <p style="margin-bottom: 30px;">Fait à Tétouan en deux exemplaires, le <strong>{{ now()->format('d-M-Y H:i:s') }}</strong></p>
        
        <table class="signature-table">
            <tr>
                <td>
                    <p><strong>Nom et signature du Stagiaire</strong></p>
                    <p>{{ strtoupper($etudiant->nom ?? '') }} {{ ucfirst($etudiant->prenom ?? '') }}</p>
                    <div class="signature-line"></div>
                </td>
                <td>
                    <p><strong>Le Coordonnateur de la filière</strong></p>
                    <p>&nbsp;</p>
                    <div class="signature-line"></div>
                </td>
            </tr>
            <tr>
                <td style="padding-top: 40px;">
                    <p><strong>Signature et cachet de L'Etablissement</strong></p>
                    <p>&nbsp;</p>
                    <div class="signature-line"></div>
                </td>
                <td style="padding-top: 40px;">
                    <p><strong>Signature et cachet de L'ENTREPRISE</strong></p>
                    <p>&nbsp;</p>
                    <div class="signature-line"></div>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer-page">
        <p>Page 1/2 - Document généré le {{ now()->format('d/m/Y à H:i') }}</p>
        @if(isset($demande))
        <p>Numéro de demande : {{ $demande->id_demande }}</p>
        @endif
    </div>

</body>
</html>