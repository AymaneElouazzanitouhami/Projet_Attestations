@extends('layouts.app')

@section('title', 'Suivi de Demande - ATTESTA')

@section('content')

<section id="suivi-demande" class="contact section" style="padding-top: 120px; min-height: 80vh;">
    <div class="container">
        <div class="container section-title" data-aos="fade-up">
            <h2>Suivre l'état de votre demande</h2>
            <p>Entrez votre numéro de demande pour consulter son état (en attente, validée, refusée).</p>
        </div>

        <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="100">
            <div class="col-lg-8">

                @if ($errors->any())
                    <div class="alert alert-danger my-3" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('demande.suivi.check') }}" method="post" class="php-email-form" style="height: auto;" novalidate>
                    @csrf
                    <div class="row gy-3">
                        <div class="col-md-4">
                            <label for="cin" class="form-label">CIN</label>
                            <input type="text" class="form-control" name="cin" id="cin" value="{{ old('cin') }}" placeholder="Ex: AA123456" required>
                        </div>
                        <div class="col-md-4">
                            <label for="numero_apogee" class="form-label">N° Apogée</label>
                            <input type="text" class="form-control" name="numero_apogee" id="numero_apogee" value="{{ old('numero_apogee') }}" placeholder="Ex: 19005678" required>
                        </div>
                        <div class="col-md-4">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" placeholder="prenom.nom@etu.uae.ac.ma" required>
                        </div>

                        <div class="col-md-8">
                            <label for="id_demande" class="form-label">Numéro de demande</label>
                            <input type="number" class="form-control" name="id_demande" id="id_demande" value="{{ old('id_demande') }}" placeholder="Ex: 15" min="1" required>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="w-100">Rechercher</button>
                        </div>
                    </div>
                </form>

                @isset($demande)
                    <div class="card mt-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Résultat</h5>

                            <div class="row gy-2">
                                <div class="col-md-6">
                                    <strong>Numéro de demande :</strong> {{ $demande->id_demande }}
                                </div>
                                <div class="col-md-6">
                                    <strong>État (statut) :</strong>
                                    <span class="badge 
                                        @if($demande->statut === 'validee') bg-success
                                        @elseif($demande->statut === 'refusee') bg-danger
                                        @else bg-warning text-dark
                                        @endif
                                    ">
                                        {{ $statusLabel ?? $demande->statut }}
                                    </span>
                                </div>

                                @if(optional($demande->etudiant)->numero_apogee)
                                    <div class="col-md-6">
                                        <strong>N° Apogée :</strong> {{ $demande->etudiant->numero_apogee }}
                                    </div>
                                @endif

                                @if(optional($demande->etudiant)->email)
                                    <div class="col-md-6">
                                        <strong>Email :</strong> {{ $demande->etudiant->email }}
                                    </div>
                                @endif

                                <div class="col-md-6">
                                    <strong>Type de document :</strong> {{ $demande->type_document }}
                                </div>

                                @if($demande->date_demande)
                                    <div class="col-md-6">
                                        <strong>Date de demande :</strong> {{ $demande->date_demande }}
                                    </div>
                                @endif

                                @if($demande->statut === 'refusee' && $demande->motif_refus)
                                    <div class="col-12">
                                        <strong>Motif de refus :</strong> {{ $demande->motif_refus }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endisset

            </div>
        </div>
    </div>
</section>

@endsection
