<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Demande;
use App\Models\HistoriqueAction;
use Illuminate\Support\Facades\Auth;
//use Barryvdh\DomPDF\Facade\Pdf; // Décommentez après avoir installé dompdf
use Carbon\Carbon;

class GestionDemandeController extends Controller
{
    // Afficher la liste des demandes avec filtres
    public function index(Request $request)
    {
        $query = Demande::with('etudiant')->latest('date_demande');

        // Filtre par statut
        if ($request->has('statut') && $request->statut !== 'all') {
            $query->where('statut', $request->statut);
        }

        // Recherche par Code Apogée
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->whereHas('etudiant', function($q) use ($search) {
                $q->where('numero_apogee', 'like', "%{$search}%");
            });
        }

        $demandes = $query->paginate(10);

        return view('admin.demandes', compact('demandes'));
    }

    // Action : VALIDER une demande
    public function valider($id)
    {
        $demande = Demande::with('etudiant')->findOrFail($id);
        $etudiant = $demande->etudiant;

        // --- LOGIQUE DE VÉRIFICATION DES CONTRAINTES STATIQUES ---
        $erreur = null;

        switch ($demande->type_document) {
            case 'scolarite':
                if ($etudiant->statut_inscription !== 'inscrit') {
                    $erreur = "L'étudiant n'est pas inscrit administrativement.";
                }
                break;

            case 'non_redoublement':
                if (!$etudiant->parcours_sans_redoublement) {
                    $erreur = "Le parcours contient un redoublement.";
                }
                break;
            
            // Ajoutez ici les autres cas (releve_notes, reussite) avec vos dates fixes si besoin
        }

        if ($erreur) {
            return back()->with('error', "Validation impossible : $erreur");
        }

        // --- TRAITEMENT ---
        
        // 1. Mise à jour BDD
        $demande->update([
            'statut' => 'validee',
            'id_admin_traitant' => Auth::guard('admin')->id(), // Assurez-vous d'utiliser le bon guard
            'date_traitement' => now()
        ]);

        // 2. Génération PDF (À activer quand la vue PDF sera prête)
        // $pdf = Pdf::loadView('pdf.attestation_template', compact('demande', 'etudiant'));

        // 3. Envoi Email (À activer quand le Mail sera prêt)
        // Mail::to($etudiant->email)->send(new DemandeValideeMail($etudiant, $pdf));

        // 4. Historique
        HistoriqueAction::create([
            'id_demande' => $demande->id_demande,
            'id_admin' => Auth::guard('admin')->id(),
            'action_effectuee' => 'Validation',
            'details' => "Type: {$demande->type_document}",
            'date_action' => now()
        ]);

        return back()->with('success', 'Demande validée avec succès.');
    }

    // Action : REFUSER une demande
    public function refuser(Request $request, $id)
    {
        $demande = Demande::findOrFail($id);
        
        // Récupération du motif (valeur par défaut si non fourni)
        $motif = $request->input('motif_refus', 'Critères non remplis.');

        $demande->update([
            'statut' => 'refusee',
            'id_admin_traitant' => Auth::guard('admin')->id(),
            'date_traitement' => now(),
            'motif_refus' => $motif
        ]);

        // Envoi Email Refus (À activer)
        // Mail::to($demande->etudiant->email)->send(new DemandeRefuseeMail($demande));

        HistoriqueAction::create([
            'id_demande' => $demande->id_demande,
            'id_admin' => Auth::guard('admin')->id(),
            'action_effectuee' => 'Refus',
            'details' => "Motif: $motif",
            'date_action' => now()
        ]);

        return back()->with('success', 'Demande refusée.');
    }
}