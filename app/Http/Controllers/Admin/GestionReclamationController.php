<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reclamation;
use App\Models\HistoriqueAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class GestionReclamationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reclamation::with(['etudiant', 'demande'])->latest('date_reclamation');

        $statut = $request->input('statut', 'non_traitee');

        // Filtre par statut
        if ($statut !== 'all') {
            // Mapping des noms de filtres vers les valeurs BDD
            $statutDb = ($statut == 'non_traitee') ? 'soumise' : 'cloturee';
            $query->where('statut', $statutDb);
        }

        $reclamations = $query->paginate(10)->appends(['statut' => $statut]);

        return view('admin.reclamations', compact('reclamations', 'statut'));
    }

    // Action : RÉPONDRE et CLÔTURER
    public function traiter(Request $request, $id)
    {
        $reclamation = Reclamation::findOrFail($id);
        $reclamation->load('etudiant');
        
        $reponse = $request->input('reponse_admin', 'Votre réclamation a été traitée.');

        $reclamation->update([
            'statut' => 'cloturee',
            'reponse_admin' => $reponse
        ]);

        try {
            $recipient = $reclamation->etudiant->email ?? null;
            if ($recipient) {
                $idReclamation = $reclamation->id_reclamation;
                Mail::raw(
                    "Votre réclamation a été traitée.\n\nRéponse de l'administration :\n{$reponse}\n",
                    function ($message) use ($recipient, $idReclamation) {
                        $message->to($recipient)->subject("Réponse à votre réclamation");
                    }
                );
            }
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'envoi de l'email de réponse à la réclamation: " . $e->getMessage());
        }

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