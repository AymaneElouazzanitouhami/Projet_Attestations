@extends('layouts.app')

@section('title', 'Nouvelle Demande - ATTESTA')

@section('content')

<!-- Section du Formulaire -->
<section id="contact" class="contact section" style="padding-top: 120px;">
    <div class="container">
        <div class="row gy-4 align-items-center">

            <!-- Colonne du Formulaire (Animation depuis la gauche) -->
            <div class="col-lg-6" data-aos="fade-right">
                <div class="container section-title">
                    <h2>Formulaire de Demande</h2>
                    <p>Veuillez compléter les informations ci-dessous.</p>
                </div>

                {{-- BLOC POUR AFFICHER LES ERREURS DE VALIDATION DU FORMULAIRE --}}
                @if ($errors->any())
                    <div class="alert alert-danger my-3" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Formulaire Dynamique avec Alpine.js -->
                <div x-data="{ niveau: '{{ old('niveau_actuel') }}', documentType: '{{ old('type_document') }}' }">
                    
                    {{-- ASTUCE : On place la classe "php-email-form" sur un div parent --}}
                    {{-- pour récupérer les styles du template SANS activer le script JS qui bloquait la soumission. --}}
                    <div class="php-email-form">
                        <form action="{{ route('demande.store') }}" method="post">
                            @csrf
                            <div class="row gy-4">
                                
                                <!-- Champs Etudiant (Lecture seule) -->
                                <div class="col-12"><h5 class="form-subtitle">Informations de l'étudiant</h5></div>
                                <div class="col-md-6">
                                    <label for="nom">Nom</label>
                                    <input type="text" class="form-control" name="nom" value="{{ $etudiant->nom }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="prenom">Prénom</label>
                                    <input type="text" class="form-control" name="prenom" value="{{ $etudiant->prenom }}" readonly>
                                </div>
                                <div class="col-12">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ $etudiant->email }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="numero_apogee">N° Apogée</label>
                                    <input type="text" class="form-control" name="numero_apogee" value="{{ $etudiant->numero_apogee }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="cin">CIN</label>
                                    <input type="text" class="form-control" name="cin" value="{{ $etudiant->cin }}" readonly>
                                </div>
                                
                                <hr class="my-4">

                                <!-- Champs de la Demande -->
                                <div class="col-12"><h5 class="form-subtitle">Détails de la demande</h5></div>
                                
                                <div class="row gx-3">
                                    <div class="col-md-6">
                                        <label for="niveau_actuel">Niveau Actuel</label>
                                        <select class="form-select" name="niveau_actuel" x-model="niveau" required>
                                            <option value="" disabled selected>-- Choisissez un niveau --</option>
                                            <option value="2ap1">2AP1</option>
                                            <option value="2ap2">2AP2</option>
                                            <option value="ci1">CI1</option>
                                            <option value="ci2">CI2</option>
                                            <option value="ci3">CI3</option>
                                        </select>
                                    </div>
        
                                    <template x-if="['ci1', 'ci2', 'ci3'].includes(niveau)">
    <div class="col-md-6">
        <label for="filiere">Filière</label>
        <select class="form-select" name="filiere" required>
            <option value="" disabled selected>-- Choisissez une filière --</option>
            
            <option value="Génie Informatique">Génie Informatique</option>
            <option value="Génie Civil">Génie Civil</option>
            <option value="Génie Mécatronique">Génie Mécatronique</option>
            
            <option value="Supply Chain Management">Supply Chain Management</option>
            <option value="GSTR">GSTR</option>
            <option value="Data & AI">Data & AI</option>
            <option value="Cybersécurité">Cybersécurité</option>
        </select>
    </div>
</template>
                                </div>

                                 <div class="row gx-3 mt-4">
                                    <div class="col-md-6">
                                        <label for="type_document">Type d'attestation</label>
                                        <select class="form-select" name="type_document" x-model="documentType" required>
                                            <option value="" disabled selected>-- Choisissez un document --</option>
                                            <option value="scolarite">Attestation de Scolarité</option>
                                            <option value="releve_notes">Relevé de Notes</option>
                                            <option value="reussite">Attestation de Réussite</option>
                                            <option value="non_redoublement">Attestation de Non-Redoublement</option>
                                        </select>
                                    </div>
        
                                    <template x-if="['releve_notes', 'reussite', 'non_redoublement'].includes(documentType)">
                                        <div class="col-md-6">
                                            <label for="annee_universitaire">Année concernée</label>
                                            <input type="text" name="annee_universitaire" class="form-control" placeholder="Ex: 2023-2024" value="{{ old('annee_universitaire') }}" required>
                                        </div>
                                    </template>
                                </div>

                                <div class="col-12 text-center mt-5">
                                    <button type="submit">Envoyer la Demande</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Colonne de l'Image -->
            <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="fade-left" data-aos-delay="200">
                <img src="{{ asset('assets/img/hero-img.png') }}" class="img-fluid animated" alt="Illustration d'étudiants">
            </div>

        </div>
    </div>
</section><!-- /Form Section -->

@endsection

