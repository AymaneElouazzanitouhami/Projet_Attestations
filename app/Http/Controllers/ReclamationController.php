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
        // 1. Récupérer l'étudiant authentifié depuis la session
        $etudiant = session('etudiant');
        if (!$etudiant) {
            return redirect()->route('home')->withErrors('Votre session a expiré. Veuillez vous reconnecter.');
        }
        
        // 2. Valider les données de base du formulaire
        $validator = Validator::make($request->all(), [
            'type_document_concerne' => 'required|string|in:scolarite,releve_notes,reussite,convention_stage',
            'numero_demande_concerne' => 'required|integer',
            'sujet' => 'required|string|max:255',
            'description' => 'required|string|min:10',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
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