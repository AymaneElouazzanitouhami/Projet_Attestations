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
                    <h2 x-text="isReclamation ? 'Formulaire de Réclamation' : 'Formulaire de Demande'">Formulaire de Demande</h2>
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
                <div x-data="{
                    niveau: '{{ old('niveau_actuel') }}',
                    documentType: '{{ old('type_document') }}',
                    requestType: '{{ old('type_demande', isset($preSelectReclamation) && $preSelectReclamation ? 'reclamation' : 'demande') }}',
                    isReclamation: {{ isset($preSelectReclamation) && $preSelectReclamation ? 'true' : 'false' }},
                    formAction: '{{ route('demande.store') }}',
                    selectedYear: '{{ old('annee_universitaire') }}',
                    etudiantNiveau: {{ $etudiant->niveau_actuel ?? 1 }},
                    availableYears: [],
                    init() {
                        this.isReclamation = (this.requestType === 'reclamation');
                        this.formAction = this.isReclamation ? '{{ route('reclamation.store') }}' : '{{ route('demande.store') }}';
                        this.updateAvailableYears();
                    },
                    updateAvailableYears() {
                        if (this.isReclamation) return;
                        const currentYear = new Date().getFullYear();
                        const currentMonth = new Date().getMonth();
                        const academicYearStart = currentMonth >= 8 ? currentYear : currentYear - 1;
                        
                        // Map niveau_actuel to year number: 1=2ap1 (Year 1), 2=2ap2 (Year 2), 3=ci1 (Year 3), 4=ci2 (Year 4), 5=ci3 (Year 5)
                        const studentYear = this.etudiantNiveau;
                        
                        // Generate years: only years less than student's current year
                        this.availableYears = [];
                        for (let i = studentYear - 1; i >= 1; i--) {
                            const yearStart = academicYearStart - (studentYear - i);
                            const yearEnd = yearStart + 1;
                            this.availableYears.push(yearStart + '-' + yearEnd);
                        }
                    },
                    isFormValid() {
                        if (!this.requestType) return false;
                        
                        if (this.isReclamation) {
                            // For reclamation: all fields are validated by HTML5 required attributes
                            // This function just ensures requestType is set
                            return true;
                        } else {
                            // For demande: type_document and niveau_actuel are required
                            if (!this.documentType || !this.niveau) return false;
                            
                            // If document type requires year, year must be selected
                            const needsYear = ['releve_notes', 'reussite'].includes(this.documentType);
                            if (needsYear) {
                                if (!this.selectedYear || this.selectedYear.trim() === '') return false;
                            }
                            
                            // If niveau requires filiere (ci1, ci2, ci3), it's handled by HTML5 required
                            return true;
                        }
                    }
                }" x-effect="isReclamation = (requestType === 'reclamation'); formAction = isReclamation ? '{{ route('reclamation.store') }}' : '{{ route('demande.store') }}'; this.updateAvailableYears();">
                    
                    {{-- ASTUCE : On place la classe "php-email-form" sur un div parent --}}
                    {{-- pour récupérer les styles du template SANS activer le script JS qui bloquait la soumission. --}}
                    <div class="php-email-form">
                        <form action="{{ route('demande.store') }}" :action="formAction" method="post">
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
                                <div class="col-12"><h5 class="form-subtitle" x-text="isReclamation ? 'Détails de la réclamation' : 'Détails de la demande'">Détails de la demande</h5></div>
                                
                                <!-- Type de demande (Demande ou Réclamation) -->
                                <div class="col-12 mb-3">
                                    <label for="type_demande">Type de demande</label>
                                    <select class="form-select" name="type_demande" x-model="requestType" @change="documentType = ''; isReclamation = (requestType === 'reclamation'); formAction = isReclamation ? '{{ route('reclamation.store') }}' : '{{ route('demande.store') }}';" required>
                                        <option value="" disabled selected>-- Choisissez un type --</option>
                                        <option value="demande">Demande</option>
                                        <option value="reclamation">Réclamation</option>
                                    </select>
                                </div>

                                <!-- Type de document (seulement pour les demandes) -->
                                <div class="col-12 mb-3" x-show="!isReclamation" style="display: none;">
                                    <label for="type_document">Type d'attestation</label>
                                    <select class="form-select" name="type_document" x-model="documentType" :required="!isReclamation">
                                        <option value="" disabled selected>-- Choisissez un document --</option>
                                        <option value="scolarite">Attestation de Scolarité</option>
                                        <option value="releve_notes">Relevé de Notes</option>
                                        <option value="reussite">Attestation de Réussite</option>
                                        <option value="convention_stage">Convention de Stage</option>
                                    </select>
                                </div>
                                
                                <!-- Niveau et Filière (seulement pour les demandes) -->
                                <div class="row gx-3" x-show="!isReclamation" style="display: none;">
                                    <div class="col-md-6">
                                        <label for="niveau_actuel">Niveau Actuel</label>
                                        <select class="form-select" name="niveau_actuel" x-model="niveau" :required="!isReclamation">
                                            <option value="" disabled selected>-- Choisissez un niveau --</option>
                                            <option value="2ap1">2AP1</option>
                                            <option value="2ap2">2AP2</option>
                                            <option value="ci1">CI1</option>
                                            <option value="ci2">CI2</option>
                                            <option value="ci3">CI3</option>
                                        </select>
                                    </div>
        
                                    <template x-if="!isReclamation && ['ci1', 'ci2', 'ci3'].includes(niveau)">
                                        <div class="col-md-6">
                                            <label for="filiere">Filière</label>
                                            <select class="form-select" name="filiere" :required="!isReclamation && ['ci1', 'ci2', 'ci3'].includes(niveau)">
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

                                <!-- Année universitaire (seulement pour certains types de documents) -->
                                <template x-if="!isReclamation && ['releve_notes', 'reussite'].includes(documentType)">
                                    <div class="col-md-6">
                                        <label for="annee_universitaire">Année concernée</label>
                                        <select class="form-select" name="annee_universitaire" x-model="selectedYear" :required="!isReclamation && ['releve_notes', 'reussite'].includes(documentType)">
                                            <option value="" disabled selected>-- Choisissez une année --</option>
                                            <template x-for="year in availableYears" :key="year">
                                                <option :value="year" x-text="year"></option>
                                            </template>
                                        </select>
                                    </div>
                                </template>

                                <!-- Champs spécifiques à la Convention de Stage -->
                                <template x-if="!isReclamation && documentType === 'convention_stage'">
                                    <hr class="my-4">
                                    <div class="col-12"><h5 class="form-subtitle">Informations sur le Stage</h5></div>
                                    <div class="col-md-6">
                                        <label for="nom_entreprise">Nom de l'Entreprise</label>
                                        <input type="text" class="form-control" name="nom_entreprise" value="{{ old('nom_entreprise') }}" :required="!isReclamation && documentType === 'convention_stage'">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email_entreprise">Email de l'Entreprise</label>
                                        <input type="email" class="form-control" name="email_entreprise" value="{{ old('email_entreprise') }}" :required="!isReclamation && documentType === 'convention_stage'">
                                    </div>
                                    <div class="col-12">
                                        <label for="adresse_entreprise">Adresse de l'Entreprise</label>
                                        <textarea class="form-control" name="adresse_entreprise" rows="3" :required="!isReclamation && documentType === 'convention_stage'">{{ old('adresse_entreprise') }}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nom_encadrant_entreprise">Nom de l'Encadrant en Entreprise</label>
                                        <input type="text" class="form-control" name="nom_encadrant_entreprise" value="{{ old('nom_encadrant_entreprise') }}" :required="!isReclamation && documentType === 'convention_stage'">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nom_encadrant_ecole">Nom de l'Encadrant à l'École</label>
                                        <input type="text" class="form-control" name="nom_encadrant_ecole" value="{{ old('nom_encadrant_ecole') }}" :required="!isReclamation && documentType === 'convention_stage'">
                                    </div>
                                    <div class="col-12">
                                        <label for="sujet_stage">Sujet du Stage</label>
                                        <textarea class="form-control" name="sujet_stage" rows="3" :required="!isReclamation && documentType === 'convention_stage'">{{ old('sujet_stage') }}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="duree_stage">Durée du Stage</label>
                                        <input type="text" class="form-control" name="duree_stage" value="{{ old('duree_stage') }}" placeholder="Ex: 3 mois" :required="!isReclamation && documentType === 'convention_stage'">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="date_debut">Date de Début</label>
                                        <input type="date" class="form-control" name="date_debut" value="{{ old('date_debut') }}" :required="!isReclamation && documentType === 'convention_stage'">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="date_fin">Date de Fin</label>
                                        <input type="date" class="form-control" name="date_fin" value="{{ old('date_fin') }}" :required="!isReclamation && documentType === 'convention_stage'">
                                    </div>
                                </template>

                                <div x-show="isReclamation" style="display: none;">
                                    <hr class="my-4">

                                    <div class="col-12">
                                        <label for="type_document_concerne">Type d'attestation concernée</label>
                                        <select class="form-select" name="type_document_concerne" :required="isReclamation">
                                            <option value="" disabled selected>-- Choisissez le type de document --</option>
                                            <option value="scolarite">Attestation de Scolarité</option>
                                            <option value="releve_notes">Relevé de Notes</option>
                                            <option value="reussite">Attestation de Réussite</option>
                                            <option value="convention_stage">Convention de Stage</option>
                                        </select>
                                    </div>

                                    <div class="col-12">
                                        <label for="numero_demande_concerne">Numéro de demande concernée</label>
                                        <input type="text" class="form-control" name="numero_demande_concerne" placeholder="Ex: 123" value="{{ old('numero_demande_concerne') }}" :required="isReclamation">
                                    </div>

                                    <div class="col-12">
                                        <label for="sujet">Sujet</label>
                                        <input type="text" class="form-control" name="sujet" placeholder="Sujet de votre réclamation" value="{{ old('sujet') }}" :required="isReclamation">
                                    </div>

                                    <div class="col-12">
                                        <label for="description">Description détaillée</label>
                                        <textarea class="form-control" name="description" rows="5" placeholder="Décrivez précisément votre problème" :required="isReclamation">{{ old('description') }}</textarea>
                                    </div>
                                </div>

                                <div class="col-12 text-center mt-5">
                                    <button type="submit" 
                                            x-text="isReclamation ? 'Envoyer la Réclamation' : 'Envoyer la Demande'"
                                            :disabled="!isFormValid()"
                                            :style="!isFormValid() ? 'opacity: 0.6; cursor: not-allowed;' : ''"
                                            >Envoyer la Demande</button>
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
