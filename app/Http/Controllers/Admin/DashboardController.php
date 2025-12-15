<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Demande;
use App\Models\Etudiant;
use App\Models\Reclamation;
use App\Models\HistoriqueAction;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Récupération des statistiques pour les cartes
        $stats = [
            'demandes_validees' => Demande::where('statut', 'validee')->count(),
            'demandes_en_attente' => Demande::where('statut', 'en_attente')->count(),
            'demandes_refusees' => Demande::where('statut', 'refusee')->count(),
        ];

        // 2. Récupération des dernières demandes pour le tableau
        $dernieresDemandes = Demande::with('etudiant')
                                    ->latest('date_demande')
                                    ->take(5)
                                    ->get();

        // 3. Récupération de l'historique récent pour la liste d'activités
        $historiqueRecent = HistoriqueAction::latest('date_action')
                                            ->take(5)
                                            ->get();

        // 4. Données pour le graphique (Nombre de demandes par mois cette année)
        $demandesParMois = Demande::select(DB::raw('count(*) as count'), DB::raw('MONTH(date_demande) as month'))
                                  ->whereYear('date_demande', date('Y'))
                                  ->groupBy('month')
                                  ->pluck('count', 'month')
                                  ->toArray();
        
        // Formatage pour le graphique JS (tableau de 12 mois)
        $dataGraphique = [];
        for ($i = 1; $i <= 12; $i++) {
            $dataGraphique[] = $demandesParMois[$i] ?? 0;
        }

        // 5. Répartition des réclamations (pour le graphique camembert)
        $reclamationsParStatut = Reclamation::select('statut', DB::raw('count(*) as total'))
                                            ->groupBy('statut')
                                            ->pluck('total', 'statut')
                                            ->toArray();

        $reclamationsChart = [
            'labels' => ['Soumises', 'Clôturées'],
            'series' => [
                $reclamationsParStatut['soumise'] ?? 0,
                $reclamationsParStatut['cloturee'] ?? 0,
            ],
        ];

        // Envoi de toutes les données à la vue
        return view('admin.dashboard', compact(
            'stats',
            'dernieresDemandes',
            'historiqueRecent',
            'dataGraphique',
            'reclamationsChart'
        ));
    }
}
