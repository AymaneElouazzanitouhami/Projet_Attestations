<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demande;
use App\Models\Etudiant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class DemandeController extends Controller
{
    /**
     * Valide et enregistre une nouvelle demande d'attestation.
     */
    public function store(Request $request)
    {
        // 1. Récupérer l'étudiant authentifié depuis la session
        $etudiantSession = session('etudiant');
        if (!$etudiantSession) {
            return redirect()->route('home')->withErrors('Votre session a expiré. Veuillez vous reconnecter.');
        }

        // Check if this is actually a reclamation (should be handled by ReclamationController)
        if ($request->input('type_demande') === 'reclamation') {
            return redirect()->route('reclamation.formulaire');
        }

        // 2. Valider les données de base du formulaire
        $validator = Validator::make($request->all(), [
            'niveau_actuel' => 'required|string',
            'filiere' => 'required_if:niveau_actuel,ci1,ci2,ci3|string|nullable',
            'type_document' => 'required|string|in:scolarite,releve_notes,reussite,convention_stage',
            'annee_universitaire' => 'required_if:type_document,releve_notes,reussite|string|nullable',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // 3. CORRECTION : Traduire le niveau du formulaire en format numérique pour la BDD
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
        $etudiantFromDB = Etudiant::find($etudiantSession->id_etudiant);
        
        // On s'assure que si le formulaire n'envoie rien, on compare avec null
        $filiereForm = $request->input('filiere') ?: null; 

        if ($niveauActuelInt != $etudiantFromDB->niveau_actuel || $filiereForm != $etudiantFromDB->filiere_actuelle) {
            // Debug (optionnel, à retirer en prod) : 
            // dd($niveauActuelInt, $etudiantFromDB->niveau_actuel, $filiereForm, $etudiantFromDB->filiere_actuelle);
            
            return back()->withErrors(['coherence' => 'Les informations de niveau ou de filière que vous avez sélectionnées ne correspondent pas à votre dossier. Veuillez vérifier.'])->withInput();
        }

        // 5. VÉRIFICATION DES CONTRAINTES MÉTIER (le reste de la logique est inchangé)
        $typeDocument = $request->input('type_document');
        $anneeUniversitaire = $request->input('annee_universitaire');
        $currentDate = Carbon::now();
        $currentAcademicYear = $currentDate->month >= 9 ? $currentDate->year . '-' . ($currentDate->year + 1) : ($currentDate->year - 1) . '-' . $currentDate->year;

        // Contrainte pour l'attestation de scolarité (une par année académique)
        if ($typeDocument == 'scolarite') {
            $startAcademicYearDate = Carbon::create($currentDate->month >= 9 ? $currentDate->year : $currentDate->year - 1, 9, 1);
            $demandeExistante = Demande::where('id_etudiant', $etudiantSession->id_etudiant)
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
        $demande->id_etudiant = $etudiantSession->id_etudiant;
        $demande->type_document = $typeDocument;
        $demande->annee_universitaire = $anneeUniversitaire;
        $demande->date_demande = now();
        $demande->save();

        try {
            $recipient = $etudiantFromDB->email ?? ($etudiantSession->email ?? null);
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

