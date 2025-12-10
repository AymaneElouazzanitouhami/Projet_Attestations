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
            'type_document_concerne' => 'required|string',
            'sujet' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $typeDocumentConcerne = $request->input('type_document_concerne');

        // 3. VÉRIFICATION CRUCIALE : L'étudiant a-t-il déjà fait une demande de ce type ?
        $demandePrecedente = Demande::where('id_etudiant', $etudiant->id_etudiant)
                                    ->where('type_document', $typeDocumentConcerne)
                                    ->latest('date_demande') // On prend la plus récente pour la lier
                                    ->first();

        if (!$demandePrecedente) {
            // Si aucune demande de ce type n'a été trouvée, on renvoie une erreur.
            return back()->withErrors(['inexistante' => 'Vous ne pouvez pas déposer de réclamation pour ce type de document car vous n\'en avez jamais fait la demande.'])->withInput();
        }
        
        // 4. ENREGISTREMENT DE LA RÉCLAMATION
        $reclamation = new Reclamation();
        $reclamation->id_demande_concernee = $demandePrecedente->id_demande; // On lie à la demande la plus récente
        $reclamation->id_etudiant = $etudiant->id_etudiant;
        $reclamation->sujet = $request->input('sujet');
        $reclamation->description = $request->input('description');
        $reclamation->date_reclamation = now();
        $reclamation->save();

        // 5. REDIRECTION VERS LA PAGE DE SUCCÈS
        return redirect()->route('reclamation.succes');
    }
}
