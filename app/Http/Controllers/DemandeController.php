<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demande;
use App\Models\Etudiant;
use App\Models\ConventionStage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class DemandeController extends Controller
{
    public function suiviForm()
    {
        return view('suivi_demande');
    }

    public function suiviCheck(Request $request)
    {
        $validated = $request->validate([
            'cin' => 'required|string|max:20',
            'numero_apogee' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'id_demande' => 'required|integer|min:1',
        ]);

        $etudiant = Etudiant::where('cin', trim($validated['cin']))
            ->where('numero_apogee', trim($validated['numero_apogee']))
            ->where('email', trim($validated['email']))
            ->first();

        if (!$etudiant) {
            return back()->withErrors([
                'identification' => 'Aucun étudiant ne correspond aux informations saisies.',
            ])->withInput();
        }

        $demande = Demande::with('etudiant')
            ->where('id_demande', $validated['id_demande'])
            ->where('id_etudiant', $etudiant->id_etudiant)
            ->first();

        if (!$demande) {
            return back()->withErrors([
                'id_demande' => 'Aucune demande trouvée avec ce numéro pour cet étudiant.',
            ])->withInput();
        }

        $statusLabels = [
            'en_attente' => 'En attente',
            'validee' => 'Validée',
            'refusee' => 'Refusée',
        ];

        $statusLabel = $statusLabels[$demande->statut] ?? $demande->statut;

        return view('suivi_demande', [
            'demande' => $demande,
            'statusLabel' => $statusLabel,
        ]);
    }

    /**
     * Valide et enregistre une nouvelle demande d'attestation.
     */
    public function store(Request $request)
    {
        // 1. Validation des données envoyées (identité + demande)
        $validator = Validator::make($request->all(), [
            'cin' => 'required|string|max:20',
            'numero_apogee' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'niveau_actuel' => 'required|string|in:2ap1,2ap2,ci1,ci2,ci3',
            'filiere' => 'required_if:niveau_actuel,ci1,ci2,ci3|string|nullable',
            'type_document' => 'required|string|in:scolarite,releve_notes,reussite,convention_stage',
            'annee_universitaire' => 'required_if:type_document,releve_notes,reussite|string|nullable',
            'nom_entreprise' => 'required_if:type_document,convention_stage|string|max:255',
            'adresse_entreprise' => 'required_if:type_document,convention_stage|string',
            'email_entreprise' => 'required_if:type_document,convention_stage|email|max:255',
            'nom_encadrant_entreprise' => 'required_if:type_document,convention_stage|string|max:100',
            'nom_encadrant_ecole' => 'required_if:type_document,convention_stage|string|max:100',
            'sujet_stage' => 'required_if:type_document,convention_stage|string',
            'duree_stage' => 'required_if:type_document,convention_stage|string|max:100',
            'date_debut' => 'required_if:type_document,convention_stage|date',
            'date_fin' => 'required_if:type_document,convention_stage|date|after:date_debut',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // 2. Récupérer l'étudiant via les trois champs obligatoires
        $etudiantFromDB = Etudiant::where('cin', trim($request->input('cin')))
            ->where('numero_apogee', trim($request->input('numero_apogee')))
            ->where('email', trim($request->input('email')))
            ->first();

        if (!$etudiantFromDB) {
            return back()->withErrors(['identification' => 'Aucun étudiant ne correspond aux informations saisies.'])->withInput();
        }

        // 3. Traduire le niveau du formulaire en format numérique pour la BDD
        $niveauActuelForm = $request->input('niveau_actuel');
        $niveauActuelInt = 0; // Valeur par défaut
        switch ($niveauActuelForm) {
            case '2ap1': $niveauActuelInt = 1; break;
            case '2ap2': $niveauActuelInt = 2; break;
            case 'ci1':  $niveauActuelInt = 3; break;
            case 'ci2':  $niveauActuelInt = 4; break;
            case 'ci3':  $niveauActuelInt = 5; break;
        }

       // 4. VÉRIFICATION DE COHÉRENCE
        $filiereForm = $request->input('filiere') ?: null; 

        if ($niveauActuelInt != $etudiantFromDB->niveau_actuel || $filiereForm != $etudiantFromDB->filiere_actuelle) {
            // Debug (optionnel, à retirer en prod) : 
            // dd($niveauActuelInt, $etudiantFromDB->niveau_actuel, $filiereForm, $etudiantFromDB->filiere_actuelle);
            
            return back()->withErrors(['coherence' => 'Les informations de niveau ou de filière que vous avez sélectionnées ne correspondent pas à votre dossier. Veuillez vérifier.'])->withInput();
        }

        // 5. VÉRIFICATION DES CONTRAINTES MÉTIER
        $typeDocument = $request->input('type_document');
        $anneeUniversitaire = $request->input('annee_universitaire');
        $currentDate = Carbon::now();
        $currentAcademicYear = $currentDate->month >= 9 ? $currentDate->year . '-' . ($currentDate->year + 1) : ($currentDate->year - 1) . '-' . $currentDate->year;

        // Années autorisées : inférieur ou égal à l'année actuelle de l'étudiant
        if (in_array($typeDocument, ['releve_notes', 'reussite']) && $anneeUniversitaire) {
            $academicYearStart = $currentDate->month >= 9 ? $currentDate->year : $currentDate->year - 1;
            $allowedYears = [];
            for ($level = $etudiantFromDB->niveau_actuel; $level >= 1; $level--) {
                $start = $academicYearStart - ($etudiantFromDB->niveau_actuel - $level);
                $allowedYears[] = $start . '-' . ($start + 1);
            }
            if (!in_array($anneeUniversitaire, $allowedYears, true)) {
                return back()->withErrors(['annee_universitaire' => 'L\'année choisie n\'est pas compatible avec votre niveau.'])->withInput();
            }
        }

        // Contrainte pour l'attestation de scolarité (une par année académique)
        if ($typeDocument == 'scolarite') {
            $startAcademicYearDate = Carbon::create($currentDate->month >= 9 ? $currentDate->year : $currentDate->year - 1, 9, 1);
            $demandeExistante = Demande::where('id_etudiant', $etudiantFromDB->id_etudiant)
                ->where('type_document', 'scolarite')
                ->where('date_demande', '>=', $startAcademicYearDate)
                ->exists();
            if ($demandeExistante) {
                return back()->withErrors(['limite' => 'Vous avez déjà demandé une attestation de scolarité pour cette année universitaire.'])->withInput();
            }
        }

        // Contrainte pour les autres attestations (après le 1er Juillet pour l'année en cours)
        if (in_array($typeDocument, ['releve_notes', 'reussite']) && $anneeUniversitaire == $currentAcademicYear) {
            if ($currentDate->month < 7) { // Avant Juillet
                return back()->withErrors(['date' => 'Ce type d\'attestation pour l\'année en cours n\'est disponible qu\'à partir du mois de Juillet.'])->withInput();
            }
        }
        
        // 6. ENREGISTREMENT DE LA DEMANDE
        $demande = new Demande();
        $demande->id_etudiant = $etudiantFromDB->id_etudiant;
        $demande->type_document = $typeDocument;
        $demande->annee_universitaire = $anneeUniversitaire;
        $demande->date_demande = now();
        $demande->save();

        // Si c'est une convention de stage, enregistrer les détails
        if ($typeDocument === 'convention_stage') {
            ConventionStage::create([
                'id_demande' => $demande->id_demande,
                'id_etudiant' => $etudiantFromDB->id_etudiant,
                'nom_entreprise' => $request->input('nom_entreprise'),
                'adresse_entreprise' => $request->input('adresse_entreprise'),
                'email_entreprise' => $request->input('email_entreprise'),
                'nom_encadrant_entreprise' => $request->input('nom_encadrant_entreprise'),
                'nom_encadrant_ecole' => $request->input('nom_encadrant_ecole'),
                'sujet_stage' => $request->input('sujet_stage'),
                'duree_stage' => $request->input('duree_stage'),
                'date_debut' => $request->input('date_debut'),
                'date_fin' => $request->input('date_fin'),
            ]);
        }

        try {
            $recipient = $etudiantFromDB->email;
            if ($recipient) {
                $idDemande = $demande->id_demande;
                Mail::raw(
                    "Votre demande a été enregistrée avec succès.\nNuméro de demande : {$idDemande}\n",
                    function ($message) use ($recipient, $idDemande) {
                        $message->to($recipient)->subject("Confirmation de demande #{$idDemande}");
                    }
                );
            }
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'envoi de l'email de confirmation de demande: " . $e->getMessage());
        }

        // 7. REDIRECTION VERS LA PAGE DE SUCCÈS
        return redirect()->route('demande.succes');
    }
}

