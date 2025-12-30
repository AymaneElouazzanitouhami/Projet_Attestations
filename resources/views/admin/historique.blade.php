@extends('admin.layouts.admin_layout')

@section('title', "Historique des Demandes d'Attestation")

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item" aria-current="page">Historique</li>
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
    
    {{-- Messages de succès/erreur --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
      <div class="card-header">
        @php
            $categorie = $categorie ?? request('categorie', 'demandes');
            $pageTitle = $categorie === 'reclamations' ? 'Historique des Réclamations' : "Historique des Demandes d'Attestation";
        @endphp
        <h5>{{ $pageTitle }}</h5>
      </div>
      <div class="card-body">
        
        <!-- SECTION FILTRES -->
        <div class="row mb-4 align-items-center">
            @php
                $keepParams = [];
                if (request('search')) {
                    $keepParams = ['search' => request('search')];
                }
            @endphp

            <div class="col-12 mb-2">
                <form action="{{ route('admin.historique') }}" method="GET">
                    @if($categorie !== 'reclamations')
                        <input type="hidden" name="statut" value="{{ request('statut', 'validee') }}">
                    @endif
                    <div class="row g-2 align-items-center">
                        <div class="col-md-4">
                            <select name="categorie" class="form-select" onchange="this.form.submit()">
                                <option value="demandes" {{ $categorie === 'demandes' ? 'selected' : '' }}>Demandes</option>
                                <option value="reclamations" {{ $categorie === 'reclamations' ? 'selected' : '' }}>Réclamations</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Rechercher par Numéro de demande..." value="{{ request('search') }}">
                                <button class="btn btn-primary" type="submit"><i class="ti ti-search"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-12">
                <div class="btn-group" role="group">
                    @if($categorie === 'reclamations')
                        <a href="{{ route('admin.historique', array_merge(['categorie' => 'reclamations'], $keepParams)) }}" class="btn btn-primary">Clôturées</a>
                    @else
                        <a href="{{ route('admin.historique', array_merge(['categorie' => 'demandes', 'statut' => 'validee'], $keepParams)) }}" class="btn {{ request('statut') == 'validee' || !request('statut') ? 'btn-primary' : 'btn-outline-primary' }}">Validées</a>
                        <a href="{{ route('admin.historique', array_merge(['categorie' => 'demandes', 'statut' => 'refusee'], $keepParams)) }}" class="btn {{ request('statut') == 'refusee' ? 'btn-primary' : 'btn-outline-primary' }}">Refusées</a>
                    @endif
                </div>
            </div>
        </div>

        <!-- TABLEAU DES DONNÉES -->
        <div class="table-responsive">
          @if($categorie === 'reclamations')
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Étudiant</th>
                    <th>Sujet</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th class="text-end">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @if(isset($reclamations))
                      @forelse($reclamations as $reclamation)
                          <tr>
                            <td>R-{{ $reclamation->id_reclamation }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-s bg-light-warning">
                                            <span class="text-warning">{{ substr($reclamation->etudiant->nom, 0, 1) }}</span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0">{{ $reclamation->etudiant->nom }} {{ $reclamation->etudiant->prenom }}</h6>
                                        <p class="mb-0 text-muted text-sm">
                                            Demande n°:
                                            {{ $reclamation->demande->id_demande ?? $reclamation->id_demande_concernee }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <strong>{{ $reclamation->sujet }}</strong>
                                <p class="text-muted text-sm mb-0 text-truncate" style="max-width: 200px;">{{ $reclamation->description }}</p>
                            </td>
                            <td>{{ $reclamation->date_reclamation->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge bg-light-success text-success">Clôturée</span>
                            </td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-light-secondary" disabled><i class="ti ti-check"></i> Fini</button>
                            </td>
                          </tr>
                      @empty
                          <tr><td colspan="6" class="text-center py-4">Aucune réclamation trouvée.</td></tr>
                      @endforelse
                  @else
                      <tr><td colspan="6" class="text-center py-4">Aucune réclamation disponible.</td></tr>
                  @endif
                </tbody>
              </table>
          @else
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Étudiant</th>
                    <th>Type de Document</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th class="text-end">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @if(isset($demandes))
                      @forelse($demandes as $demande)
                          <tr>
                            <td>#{{ $demande->id_demande }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-s bg-light-secondary">
                                            <span class="text-secondary">{{ strtoupper(substr($demande->etudiant->prenom, 0, 1) . substr($demande->etudiant->nom, 0, 1)) }}</span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0">{{ $demande->etudiant->nom }} {{ $demande->etudiant->prenom }}</h6>
                                        <p class="mb-0 text-muted text-sm">{{ $demande->etudiant->numero_apogee }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="d-block fw-bold">
                                    @switch($demande->type_document)
                                        @case('scolarite')
                                            <a href="{{ route('admin.demandes.document', $demande->id_demande) }}" target="_blank" class="text-decoration-underline">
                                                Attestation de Scolarité
                                            </a>
                                            @break
                                        @case('releve_notes')
                                            <a href="{{ route('admin.demandes.document', $demande->id_demande) }}" target="_blank" class="text-decoration-underline">
                                                Relevé de Notes
                                            </a>
                                            @break
                                        @case('reussite')
                                            <a href="{{ route('admin.demandes.document', $demande->id_demande) }}" target="_blank" class="text-decoration-underline">
                                                Attestation de Réussite
                                            </a>
                                            @break
                                        @case('convention_stage')
                                            <a href="{{ route('admin.demandes.document', $demande->id_demande) }}" target="_blank" class="text-decoration-underline">
                                                Convention de Stage
                                            </a>
                                            @break
                                        @case('non_redoublement')
                                            <a href="{{ route('admin.demandes.document', $demande->id_demande) }}" target="_blank" class="text-decoration-underline">
                                                Non-Redoublement
                                            </a>
                                            @break
                                    @endswitch
                                </span>
                                @if($demande->type_document == 'releve_notes')
                                    <small class="text-muted">{{ $demande->annee_universitaire }}{{ $demande->semestre }}</small>
                                @endif
                            </td>
                            <td>{{ $demande->date_demande->format('d/m/Y') }}</td>
                            <td>
                                @if($demande->statut == 'en_attente')
                                    <span class="badge bg-light-warning text-warning">En attente</span>
                                @elseif($demande->statut == 'validee')
                                    <span class="badge bg-light-success text-success">Validée</span>
                                @else
                                    <span class="badge bg-light-danger text-danger">Refusée</span>
                                @endif
                            </td>
                            <td class="text-end">
                                @if($demande->statut == 'en_attente')
                                    <div class="btn-group btn-group-sm">
                                        {{-- Bouton Valider --}}
                                        <form action="{{ route('admin.demandes.valider', $demande->id_demande) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la validation de cette demande ?');">
                                            @csrf
                                            <button type="submit" class="btn btn-light-success" title="Valider">
                                                <i class="ti ti-check"></i>
                                            </button>
                                        </form>

                                        {{-- Bouton Refuser (Ouvre Modal) --}}
                                        <button type="button" class="btn btn-light-danger" title="Refuser" data-bs-toggle="modal" data-bs-target="#refuserModal{{ $demande->id_demande }}">
                                            <i class="ti ti-x"></i>
                                        </button>
                                    </div>
                                @elseif($demande->statut == 'validee')
                                    <form action="{{ route('admin.demandes.renvoyer', $demande->id_demande) }}" method="POST" class="d-inline" onsubmit="return confirm('Renvoyer ce document par email à l\'étudiant ?');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-light-primary" title="Renvoyer">
                                            <i class="ti ti-send"></i> Renvoyer
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-sm btn-light-secondary" disabled><i class="ti ti-lock"></i> Traitée</button>
                                @endif
                            </td>
                          </tr>

                          <!-- Modal de Refus pour chaque demande -->
                          <div class="modal fade" id="refuserModal{{ $demande->id_demande }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('admin.demandes.refuser', $demande->id_demande) }}" method="POST">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Refuser la demande #{{ $demande->id_demande }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="motif" class="form-label">Motif du refus (Obligatoire)</label>
                                                <textarea class="form-control" name="motif_refus" rows="3" required placeholder="Ex: L'étudiant n'est pas inscrit cette année..."></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-danger">Confirmer le Refus</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                          </div>

                      @empty
                          <tr><td colspan="6" class="text-center py-4">Aucune demande trouvée.</td></tr>
                      @endforelse
                  @else
                      <tr><td colspan="6" class="text-center py-4">Aucune demande disponible.</td></tr>
                  @endif
                </tbody>
              </table>
          @endif
        </div>
        
        <!-- PAGINATION -->
        <div class="mt-3 d-flex justify-content-end">
            @if(isset($demandes))
                {{ $demandes->links('pagination::bootstrap-5') }}
            @elseif(isset($reclamations))
                {{ $reclamations->links('pagination::bootstrap-5') }}
            @endif
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
