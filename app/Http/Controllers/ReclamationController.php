<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demande;
use App\Models\Reclamation;
use Illuminate\Support\Facades\Validator;

class ReclamationController extends Controller
{
    /**
     * Valide et enregistre une nouvelle réclamation.
     */
    public function store(Request $request)
    {
        // 1. Valider les données envoyées
        $validator = Validator::make($request->all(), [
            'cin' => 'required|string|max:20',
            'numero_apogee' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'type_document_concerne' => 'required|string|in:scolarite,releve_notes,reussite,convention_stage',
            'numero_demande_concerne' => 'required|integer',
            'sujet' => 'required|string|max:255',
            'description' => 'required|string|min:10',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // 2. Récupérer l'étudiant via les trois champs obligatoires
        $etudiant = \App\Models\Etudiant::where('cin', trim($request->input('cin')))
            ->where('numero_apogee', trim($request->input('numero_apogee')))
            ->where('email', trim($request->input('email')))
            ->first();

        if (!$etudiant) {
            return back()->withErrors(['identification' => 'Aucun étudiant ne correspond aux informations saisies.'])->withInput();
        }
        
        $typeDocumentConcerne = $request->input('type_document_concerne');
        $numeroDemandeConcerne = (int) $request->input('numero_demande_concerne');
        
        // 3. VÉRIFICATION : le numéro de demande doit exister et appartenir à l'étudiant
        $demandeConcernee = Demande::where('id_demande', $numeroDemandeConcerne)
            ->where('id_etudiant', $etudiant->id_etudiant)
            ->where('type_document', $typeDocumentConcerne)
            ->first();

        if (!$demandeConcernee) {
            return back()->withErrors([
                'numero_demande_concerne' => 'Numéro de demande invalide (ou ne correspond pas au type choisi / ne vous appartient pas).'
            ])->withInput();
        }
        
        // 4. ENREGISTREMENT DE LA RÉCLAMATION (avec gestion d'erreurs)
        try {
            $reclamation = Reclamation::create([
                'id_demande_concernee' => $demandeConcernee->id_demande,
                'id_etudiant' => $etudiant->id_etudiant,
                'sujet' => $request->input('sujet'),
                'description' => $request->input('description'),
                'date_reclamation' => now(),
                'statut' => 'soumise',
            ]);
        } catch (\Exception $e) {
            logger()->error('Erreur lors de la création d\'une réclamation: ' . $e->getMessage());
            return back()->withErrors([
                'save_error' => 'Une erreur est survenue lors de l\'enregistrement de votre réclamation. Veuillez réessayer plus tard.'
            ])->withInput();
        }
        
        // 5. REDIRECTION VERS LA PAGE DE SUCCÈS
        return redirect()->route('reclamation.succes');
    }
}