@extends('admin.layouts.admin_layout')

@section('title', 'Gestion des Réclamations')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item" aria-current="page">Réclamations</li>
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
      <div class="card-header">
        <h5>Liste des Réclamations Étudiantes</h5>
      </div>
      <div class="card-body">
        
        <!-- SECTION FILTRES -->
        <div class="row mb-4 align-items-center">
            <div class="col-md-6 mb-2">
                <div class="btn-group" role="group">
                    <a href="{{ route('admin.reclamations', ['statut' => 'non_traitee']) }}" class="btn {{ $statut == 'non_traitee' ? 'btn-primary' : 'btn-outline-primary' }}">Non traitées</a>
                    <a href="{{ route('admin.reclamations', ['statut' => 'cloturee']) }}" class="btn {{ $statut == 'cloturee' ? 'btn-primary' : 'btn-outline-primary' }}">Clôturées</a>
                    <a href="{{ route('admin.reclamations', ['statut' => 'all']) }}" class="btn {{ $statut == 'all' ? 'btn-primary' : 'btn-outline-primary' }}">Toutes</a>
                </div>
            </div>
        </div>

        <!-- TABLEAU DES DONNÉES -->
        <div class="table-responsive">
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
                            @if($reclamation->statut == 'soumise')
                                <span class="badge bg-light-warning text-warning">Non traitée</span>
                            @else
                                <span class="badge bg-light-success text-success">Clôturée</span>
                            @endif
                        </td>
                        <td class="text-end">
                            @if($reclamation->statut == 'soumise')
                                <button type="button" class="btn btn-sm btn-light-primary" data-bs-toggle="modal" data-bs-target="#repondreModal{{ $reclamation->id_reclamation }}">
                                    <i class="ti ti-message-circle-2"></i> Répondre
                                </button>
                            @else
                                <button class="btn btn-sm btn-light-secondary" disabled><i class="ti ti-check"></i> Fini</button>
                            @endif
                        </td>
                      </tr>

                      <!-- Modal de Réponse -->
                      <div class="modal fade" id="repondreModal{{ $reclamation->id_reclamation }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('admin.reclamations.traiter', $reclamation->id_reclamation) }}" method="POST">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Répondre à la réclamation #R-{{ $reclamation->id_reclamation }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="alert alert-light"><strong>Description :</strong> {{ $reclamation->description }}</p>
                                        <div class="mb-3">
                                            <label for="reponse" class="form-label">Votre réponse (sera envoyée par email)</label>
                                            <textarea class="form-control" name="reponse_admin" rows="4" required placeholder="Bonjour, nous avons bien reçu..."></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        <button type="submit" class="btn btn-primary">Envoyer et Clôturer</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                      </div>

                  @empty
                      <tr><td colspan="6" class="text-center py-4">Aucune réclamation trouvée.</td></tr>
                  @endforelse
              @else
                  <tr><td colspan="6" class="text-center py-4">Aucune réclamation disponible.</td></tr>
              @endif
            </tbody>
          </table>
        </div>
        
        <!-- PAGINATION -->
        <div class="mt-3 d-flex justify-content-end">
            @if(isset($reclamations))
                {{ $reclamations->links('pagination::bootstrap-5') }}
            @endif
        </div>

      </div>
    </div>
  </div>
</div>
@endsection