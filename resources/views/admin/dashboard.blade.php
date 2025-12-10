@extends('admin.layouts.admin_layout')

@section('title', 'Tableau de Bord')

@section('breadcrumb')
  <li class="breadcrumb-item" aria-current="page">Statistiques</li>
@endsection

@section('content')
  <!-- [ Main Content ] start -->
  <div class="row">
    
    <!-- Carte 1 : Total Demandes -->
    <div class="col-md-6 col-xl-3">
      <div class="card">
        <div class="card-body">
          <h6 class="mb-2 f-w-400 text-muted">Total Demandes</h6>
          <h4 class="mb-3">{{ $stats['total_demandes'] ?? 0 }} <span class="badge bg-light-primary border border-primary"><i class="ti ti-file-text"></i> Global</span></h4>
          <p class="mb-0 text-muted text-sm">Toutes attestations confondues</p>
        </div>
      </div>
    </div>

    <!-- Carte 2 : Étudiants -->
    <div class="col-md-6 col-xl-3">
      <div class="card">
        <div class="card-body">
          <h6 class="mb-2 f-w-400 text-muted">Étudiants Inscrits</h6>
          <h4 class="mb-3">{{ $stats['total_etudiants'] ?? 0 }} <span class="badge bg-light-success border border-success"><i class="ti ti-users"></i> Actifs</span></h4>
          <p class="mb-0 text-muted text-sm">Base de données étudiants</p>
        </div>
      </div>
    </div>

    <!-- Carte 3 : En Attente -->
    <div class="col-md-6 col-xl-3">
      <div class="card">
        <div class="card-body">
          <h6 class="mb-2 f-w-400 text-muted">À Traiter</h6>
          <h4 class="mb-3">{{ $stats['en_attente'] ?? 0 }} <span class="badge bg-light-warning border border-warning"><i class="ti ti-clock"></i> Urgent</span></h4>
          <p class="mb-0 text-muted text-sm">Demandes en attente</p>
        </div>
      </div>
    </div>

    <!-- Carte 4 : Réclamations -->
    <div class="col-md-6 col-xl-3">
      <div class="card">
        <div class="card-body">
          <h6 class="mb-2 f-w-400 text-muted">Réclamations</h6>
          <h4 class="mb-3">{{ $stats['reclamations'] ?? 0 }} <span class="badge bg-light-danger border border-danger"><i class="ti ti-alert-circle"></i> En cours</span></h4>
          <p class="mb-0 text-muted text-sm">Tickets ouverts</p>
        </div>
      </div>
    </div>

    <!-- [ Graphique Principal ] -->
    <div class="col-md-12 col-xl-8">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="mb-0">Flux des Demandes (Année en cours)</h5>
          </div>
          <!-- Le graphique sera généré par le script en bas de page -->
          <div id="visitor-chart"></div>
        </div>
      </div>
    </div>
    
    <!-- [ Historique Récent ] -->
    <div class="col-md-12 col-xl-4">
      <div class="card">
        <div class="card-header">
            <h5>Activité Récente</h5>
        </div>
        <div class="list-group list-group-flush">
            @if(isset($historiqueRecent))
                @forelse($historiqueRecent as $action)
                  <div class="list-group-item">
                    <div class="d-flex align-items-center">
                      <div class="flex-shrink-0">
                        <div class="avtar avtar-s {{ $action->action_effectuee == 'Validation' ? 'bg-light-success' : ($action->action_effectuee == 'Refus' ? 'bg-light-danger' : 'bg-light-primary') }}">
                            <i class="ti {{ $action->action_effectuee == 'Validation' ? 'ti-check' : ($action->action_effectuee == 'Refus' ? 'ti-x' : 'ti-info-circle') }} f-18"></i>
                        </div>
                      </div>
                      <div class="flex-grow-1 mx-3">
                        <h6 class="mb-1">{{ $action->action_effectuee }}</h6>
                        <p class="mb-0 text-muted text-sm">{{ $action->date_action->diffForHumans() }}</p>
                      </div>
                    </div>
                  </div>
                @empty
                    <div class="list-group-item text-center text-muted">Aucune activité récente.</div>
                @endforelse
            @else
                <div class="list-group-item text-center text-muted">Aucune activité récente.</div>
            @endif
        </div>
      </div>
    </div>

    <!-- [ Tableau Dernières Demandes ] -->
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h5>Dernières Demandes Reçues</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Étudiant</th>
                  <th>Type</th>
                  <th>Date</th>
                  <th>Statut</th>
                  <th class="text-end">Action</th>
                </tr>
              </thead>
              <tbody>
                @if(isset($dernieresDemandes))
                    @forelse($dernieresDemandes as $demande)
                        <tr>
                          <td>
                            <div class="d-inline-block align-middle">
                              <div class="d-inline-block">
                                <h6 class="m-b-0">{{ $demande->etudiant->nom }} {{ $demande->etudiant->prenom }}</h6>
                                <p class="m-b-0 text-sm text-muted">Apogée: {{ $demande->etudiant->numero_apogee }}</p>
                              </div>
                            </div>
                          </td>
                          <td>
                              @switch($demande->type_document)
                                  @case('scolarite') Attestation Scolarité @break
                                  @case('releve_notes') Relevé de Notes @break
                                  @case('reussite') Attestation Réussite @break
                                  @case('non_redoublement') Non-Redoublement @break
                              @endswitch
                          </td>
                          <td>{{ $demande->date_demande->format('d M Y') }}</td>
                          <td>
                              @if($demande->statut == 'en_attente')
                                <span class="badge bg-light-warning text-warning">En Attente</span>
                              @elseif($demande->statut == 'validee')
                                <span class="badge bg-light-success text-success">Validée</span>
                              @else
                                <span class="badge bg-light-danger text-danger">Refusée</span>
                              @endif
                          </td>
                          <td class="text-end">
                              <a href="{{ route('admin.demandes') }}" class="btn btn-sm btn-primary">Gérer</a>
                          </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">Aucune demande récente.</td></tr>
                    @endforelse
                @else
                    <tr><td colspan="5" class="text-center">Aucune demande récente.</td></tr>
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>
  <!-- [ Main Content ] end -->
@endsection

@section('scripts')
  <!-- Script Mantis de base pour les graphiques -->
  <script src="{{ asset('assets/admin/assets/js/pages/dashboard-default.js') }}"></script>
  
  <!-- Script optionnel pour injecter vos données PHP dans le graphique (si besoin) -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      setTimeout(function () {
        // Exemple : Injection des données PHP pour le graphique (si supporté par dashboard-default.js)
        // var dataPHP = @json($dataGraphique ?? []); 
      }, 500);
    });
  </script>
@endsection