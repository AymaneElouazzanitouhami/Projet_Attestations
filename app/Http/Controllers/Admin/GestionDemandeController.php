<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Demande;
use App\Models\HistoriqueAction;
use App\Models\ConventionStage;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;  
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Mail\DemandeValideeMail;
use App\Mail\DemandeRefuseeMail;
use Carbon\Carbon;

class GestionDemandeController extends Controller
{
    // Afficher la liste des demandes avec filtres
    public function index(Request $request)
    {
        $query = Demande::with('etudiant')->orderBy('id_demande', 'asc');

        // Afficher uniquement les demandes en attente (celles qui nécessitent une action admin)
        $query->where('statut', 'en_attente');

        // Filtre par type de document (onglets) — on affiche tous les statuts pour le type sélectionné
        $typeDocument = $request->input('type_document', 'scolarite');
        if (!in_array($typeDocument, ['scolarite', 'releve_notes', 'reussite', 'convention_stage'], true)) {
            $typeDocument = 'scolarite';
        }
        $query->where('type_document', $typeDocument);

        // Recherche par Numéro de demande (id_demande)
        if ($request->has('search') && !empty($request->search)) {
            $raw = trim((string) $request->search);
            $digits = preg_replace('/\D+/', '', $raw);
            if ($digits !== '') {
                $query->where('id_demande', (int) $digits);
            }
        }

        // Paginate and preserve query string
        $demandes = $query->paginate(10)->appends($request->except('page'));

        return view('admin.demandes', compact('demandes'));
    }

    // Afficher l'historique des demandes (uniquement validées / refusées)
    public function historique(Request $request)
    {
        $query = Demande::with('etudiant')->orderBy('id_demande', 'asc');

        // Filtre par statut — par défaut on affiche les demandes "validee" (historique)
        $statut = $request->input('statut', 'validee');
        if (!in_array($statut, ['validee', 'refusee'], true)) {
            $statut = 'validee';
        }
        $query->where('statut', $statut);

        // Filtre par type de document
        $typeDocument = $request->input('type_document');
        if (!empty($typeDocument) && $typeDocument !== 'all') {
            $query->where('type_document', $typeDocument);
        }

        // Recherche par Numéro de demande (id_demande)
        if ($request->has('search') && !empty($request->search)) {
            $raw = trim((string) $request->search);
            $digits = preg_replace('/\D+/', '', $raw);
            if ($digits !== '') {
                $query->where('id_demande', (int) $digits);
            }
        }

        // Paginate and preserve query string
        $demandes = $query->paginate(10)->appends($request->except('page'));

        return view('admin.historique', compact('demandes'));
    }

    // Afficher le document PDF
    public function showDocument($id)
    {
        $demande = Demande::with('etudiant.notes')->findOrFail($id);
        $etudiant = $demande->etudiant;

        // Vérifier que le type de document est supporté
        if (!in_array($demande->type_document, ['scolarite', 'non_redoublement', 'reussite', 'releve_notes', 'convention_stage'])) {
            abort(404, 'Ce type de document n\'est pas disponible en PDF.');
        }

        if ($demande->type_document === 'convention_stage') {
            $convention = ConventionStage::where('id_demande', $id)->firstOrFail();
            $pdf = Pdf::loadView('pdf.convention_stage_template', compact('demande', 'etudiant', 'convention'));
            $fileName = 'convention_stage_' . $demande->id_demande . '.pdf';
            return $pdf->stream($fileName);
        } else {
            // Tous les types utilisent la même vue
            $pdf = Pdf::loadView('pdf.attestation_template', compact('demande', 'etudiant'));

            // Nom du fichier selon le type
            $fileNames = [
                'scolarite' => 'attestation_scolarite_',
                'non_redoublement' => 'attestation_non_redoublement_',
                'reussite' => 'attestation_reussite_',
                'releve_notes' => 'releve_notes_'
            ];

            $fileName = $fileNames[$demande->type_document] ?? 'attestation_';
            return $pdf->stream($fileName . $demande->id_demande . '.pdf');
        }
    }

    // Action : VALIDER une demande
    public function valider($id)
    {
        $demande = Demande::with('etudiant.notes')->findOrFail($id);
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
            'id_admin_traitant' => Auth::guard('admin')->id(),
            'date_traitement' => now()
        ]);

        // 2. Génération du PDF selon le type de document
        $pdfContent = null;
        $fileName = null;

        if (in_array($demande->type_document, ['scolarite', 'non_redoublement', 'reussite', 'releve_notes', 'convention_stage'])) {
            if ($demande->type_document === 'convention_stage') {
                $convention = ConventionStage::where('id_demande', $demande->id_demande)->first();
                if ($convention) {
                    $convention->update(['statut' => 'approuvee']);
                }
                $pdf = Pdf::loadView('pdf.convention_stage_template', compact('demande', 'etudiant', 'convention'));
                $pdfContent = $pdf->output();
                $fileName = 'convention_stage_' . $demande->id_demande . '.pdf';
            } else {
                // Tous les types utilisent la même vue
                $pdf = Pdf::loadView('pdf.attestation_template', compact('demande', 'etudiant'));
                $pdfContent = $pdf->output();
                
                // Noms de fichier selon le type
                $fileNames = [
                    'scolarite' => 'attestation_scolarite.pdf',
                    'non_redoublement' => 'attestation_non_redoublement.pdf',
                    'reussite' => 'attestation_reussite.pdf',
                    'releve_notes' => 'releve_notes.pdf'
                ];
                
                $fileName = $fileNames[$demande->type_document] ?? 'attestation.pdf';
            }
            
            // Sauvegarder aussi le PDF dans le stockage pour archivage
            $filePath = 'attestations/' . $demande->id_demande . '_' . $fileName;
            Storage::disk('public')->put($filePath, $pdfContent);
        }

        // 3. Envoi de l'email avec le PDF en pièce jointe
        try {
            Mail::to($etudiant->email)->send(new DemandeValideeMail($demande, $etudiant, $pdfContent, $fileName));
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi de l\'email: ' . $e->getMessage());
        }

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
        $demande = Demande::with('etudiant.notes')->findOrFail($id);
        
        // Récupération du motif (valeur par défaut si non fourni)
        $motif = $request->input('motif_refus', 'Critères non remplis.');

        $demande->update([
            'statut' => 'refusee',
            'id_admin_traitant' => Auth::guard('admin')->id(),
            'date_traitement' => now(),
            'motif_refus' => $motif
        ]);

        if ($demande->type_document === 'convention_stage') {
            $convention = ConventionStage::where('id_demande', $demande->id_demande)->first();
            if ($convention) {
                $convention->update(['statut' => 'refusee']);
            }
        }

        Mail::to($demande->etudiant->email)->send(new DemandeRefuseeMail($demande, $motif));

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