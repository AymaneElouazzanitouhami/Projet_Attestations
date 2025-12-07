<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reclamation;
use App\Models\HistoriqueAction;
use Illuminate\Support\Facades\Auth;

class GestionReclamationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reclamation::with('etudiant')->latest('date_reclamation');

        // Filtre par statut
        if ($request->has('statut') && $request->statut !== 'all') {
            // Mapping des noms de filtres vers les valeurs BDD
            $statutDb = ($request->statut == 'non_traitee') ? 'soumise' : 'cloturee';
            $query->where('statut', $statutDb);
        }

        $reclamations = $query->paginate(10);

        return view('admin.reclamations', compact('reclamations'));
    }

    // Action : RÉPONDRE et CLÔTURER
    public function traiter(Request $request, $id)
    {
        $reclamation = Reclamation::findOrFail($id);
        
        $reponse = $request->input('reponse_admin', 'Votre réclamation a été traitée.');

        $reclamation->update([
            'statut' => 'cloturee',
            'reponse_admin' => $reponse
        ]);

        // Envoi Email Réponse (À activer)
        // Mail::to($reclamation->etudiant->email)->send(new ReponseReclamationMail($reclamation));

        HistoriqueAction::create([
            'id_reclamation' => $reclamation->id_reclamation,
            'id_admin' => Auth::guard('admin')->id(),
            'action_effectuee' => 'Clôture Réclamation',
            'details' => 'Réponse envoyée.',
            'date_action' => now()
        ]);

        return back()->with('success', 'Réclamation traitée et clôturée.');
    }
}