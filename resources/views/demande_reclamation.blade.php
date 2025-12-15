@extends('layouts.app')

@section('title', 'Demande / Réclamation - ATTESTA')

@section('content')

<section id="contact" class="contact section" style="padding-top: 120px;">
    <div class="container">
        <div class="row gy-4 align-items-center">

            <div class="col-lg-7" data-aos="fade-right">
                <div class="container section-title">
                    <h2>Demande d'attestation ou Réclamation</h2>
                    <p>Renseignez vos informations puis choisissez le type d'action.</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger my-3" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div x-data="demandeReclamationForm()" x-init="init()" class="php-email-form">
                    <form :action="formAction" method="post" novalidate>
                        @csrf
                        <div class="row gy-4">

                            <div class="col-12"><h5 class="form-subtitle">Vos informations</h5></div>
                            <div class="col-md-4">
                                <label for="cin">CIN</label>
                                <input type="text" class="form-control" name="cin" x-model="cin" @input="onIdentityChange" placeholder="Ex: AA123456" required>
                            </div>
                            <div class="col-md-4">
                                <label for="numero_apogee">N° Apogée</label>
                                <input type="text" class="form-control" name="numero_apogee" x-model="numeroApogee" @input="onIdentityChange" placeholder="Ex: 1234567" required>
                            </div>
                            <div class="col-md-4">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" x-model="email" @input="onIdentityChange" placeholder="prenom.nom@etu.uae.ac.ma" required>
                            </div>

                            <template x-if="identityError">
                                <div class="col-12">
                                    <div class="alert alert-warning py-2 px-3" x-text="identityError"></div>
                                </div>
                            </template>

                            <template x-if="etudiantLoaded">
                                <div class="col-12">
                                    <div class="alert alert-success py-2 px-3">
                                        <strong x-text="etudiant.prenom + ' ' + etudiant.nom"></strong>
                                        <span class="d-block">Niveau : <span x-text="niveauLabel()"></span> | Filière : <span x-text="etudiant.filiere_actuelle ?? 'Non renseignée'"></span></span>
                                    </div>
                                </div>
                            </template>

                            <hr class="my-3">

                            <div class="col-12"><h5 class="form-subtitle">Type de demande</h5></div>
                            <div class="col-md-6">
                                <label for="type_demande">Que souhaitez-vous faire ?</label>
                                <select class="form-select" name="type_demande" x-model="requestType" @change="updateFormAction" :disabled="!canChooseType()">
                                    <option value="" disabled selected>-- Choisissez --</option>
                                    <option value="demande">Demander une attestation</option>
                                    <option value="reclamation">Déposer une réclamation</option>
                                </select>
                            </div>

                            <div x-show="requestType === 'demande'" style="display: none;">
                                <div class="col-12 mt-2"><h6>Attestation souhaitée</h6></div>
                                <div class="col-12">
                                    <label for="type_document">Type d'attestation</label>
                                    <select class="form-select" name="type_document" x-model="documentType" :required="requestType === 'demande'">
                                        <option value="" disabled selected>-- Choisissez un document --</option>
                                        <option value="scolarite">Attestation de Scolarité</option>
                                        <option value="releve_notes">Relevé de Notes</option>
                                        <option value="reussite">Attestation de Réussite</option>
                                        <option value="convention_stage">Convention de Stage</option>
                                    </select>
                                </div>

                                <div class="row gx-3">
                                    <div class="col-md-6">
                                        <label for="niveau_actuel">Niveau actuel</label>
                                        <select class="form-select" name="niveau_actuel" x-model="niveau" :required="requestType === 'demande'">
                                            <option value="" disabled selected>-- Choisissez --</option>
                                            <option value="2ap1">2AP1</option>
                                            <option value="2ap2">2AP2</option>
                                            <option value="ci1">CI1</option>
                                            <option value="ci2">CI2</option>
                                            <option value="ci3">CI3</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6" x-show="['ci1','ci2','ci3'].includes(niveau)" style="display: none;">
                                        <label for="filiere">Filière</label>
                                        <select class="form-select" name="filiere" x-model="filiere" :required="['ci1','ci2','ci3'].includes(niveau)">
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
                                </div>

                                <template x-if="['releve_notes','reussite'].includes(documentType)">
                                    <div class="col-md-6">
                                        <label for="annee_universitaire">Année concernée</label>
                                        <select class="form-select" name="annee_universitaire" x-model="selectedYear" :required="['releve_notes','reussite'].includes(documentType)">
                                            <option value="" disabled selected>-- Choisissez une année --</option>
                                            <template x-for="year in availableYears" :key="year">
                                                <option :value="year" x-text="year"></option>
                                            </template>
                                        </select>
                                    </div>
                                </template>

                                <template x-if="documentType === 'convention_stage'">
                                    <div>
                                        <hr class="my-3">
                                        <div class="col-12"><h6>Informations sur le stage</h6></div>
                                        <div class="col-md-6">
                                            <label for="nom_entreprise">Nom de l'Entreprise</label>
                                            <input type="text" class="form-control" name="nom_entreprise" x-model="stage.nomEntreprise" :required="documentType === 'convention_stage'">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email_entreprise">Email de l'Entreprise</label>
                                            <input type="email" class="form-control" name="email_entreprise" x-model="stage.emailEntreprise" :required="documentType === 'convention_stage'">
                                        </div>
                                        <div class="col-12">
                                            <label for="adresse_entreprise">Adresse de l'Entreprise</label>
                                            <textarea class="form-control" name="adresse_entreprise" rows="3" x-model="stage.adresseEntreprise" :required="documentType === 'convention_stage'"></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="nom_encadrant_entreprise">Nom de l'Encadrant (Entreprise)</label>
                                            <input type="text" class="form-control" name="nom_encadrant_entreprise" x-model="stage.encadrantEntreprise" :required="documentType === 'convention_stage'">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="nom_encadrant_ecole">Nom de l'Encadrant (École)</label>
                                            <input type="text" class="form-control" name="nom_encadrant_ecole" x-model="stage.encadrantEcole" :required="documentType === 'convention_stage'">
                                        </div>
                                        <div class="col-12">
                                            <label for="sujet_stage">Sujet du stage</label>
                                            <textarea class="form-control" name="sujet_stage" rows="3" x-model="stage.sujet" :required="documentType === 'convention_stage'"></textarea>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="duree_stage">Durée</label>
                                            <input type="text" class="form-control" name="duree_stage" x-model="stage.duree" placeholder="Ex: 3 mois" :required="documentType === 'convention_stage'">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="date_debut">Date de début</label>
                                            <input type="date" class="form-control" name="date_debut" x-model="stage.dateDebut" :required="documentType === 'convention_stage'">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="date_fin">Date de fin</label>
                                            <input type="date" class="form-control" name="date_fin" x-model="stage.dateFin" :required="documentType === 'convention_stage'">
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <div x-show="requestType === 'reclamation'" style="display: none;">
                                <div class="col-12 mt-2"><h6>Réclamation</h6></div>
                                <div class="col-12">
                                    <label for="type_document_concerne">Document concerné</label>
                                    <select class="form-select" name="type_document_concerne" x-model="typeDocumentConcerne" :required="requestType === 'reclamation'">
                                        <option value="" disabled selected>-- Choisissez le type de document --</option>
                                        <option value="scolarite">Attestation de Scolarité</option>
                                        <option value="releve_notes">Relevé de Notes</option>
                                        <option value="reussite">Attestation de Réussite</option>
                                        <option value="convention_stage">Convention de Stage</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="numero_demande_concerne">Numéro de demande concernée</label>
                                    <input type="text" class="form-control" name="numero_demande_concerne" x-model="numeroDemande" placeholder="Ex: 123" :required="requestType === 'reclamation'">
                                </div>
                                <div class="col-12">
                                    <label for="sujet">Sujet</label>
                                    <input type="text" class="form-control" name="sujet" x-model="sujetReclamation" placeholder="Sujet de votre réclamation" :required="requestType === 'reclamation'">
                                </div>
                                <div class="col-12">
                                    <label for="description">Description détaillée</label>
                                    <textarea class="form-control" name="description" rows="5" x-model="descriptionReclamation" placeholder="Décrivez précisément votre problème" :required="requestType === 'reclamation'"></textarea>
                                </div>
                            </div>

                            <div class="col-12 text-center mt-4">
                                <button type="submit"
                                        x-text="requestType === 'reclamation' ? 'Envoyer la réclamation' : 'Envoyer la demande'"
                                        :disabled="!isFormValid()"
                                        :style="!isFormValid() ? 'opacity: 0.6; cursor: not-allowed;' : ''">
                                        Envoyer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-5 order-1 order-lg-2 hero-img" data-aos="fade-left" data-aos-delay="200">
                <img src="{{ asset('assets/img/steps/steps-1.webp') }}" class="img-fluid animated" alt="Illustration d'étudiants">
            </div>

        </div>
    </div>
</section>

<script>
    function demandeReclamationForm() {
        return {
            cin: '{{ old('cin') }}',
            numeroApogee: '{{ old('numero_apogee') }}',
            email: '{{ old('email') }}',

            requestType: '{{ old('type_demande') }}' || '',
            documentType: '{{ old('type_document') }}' || '',
            selectedYear: '{{ old('annee_universitaire') }}' || '',
            niveau: '{{ old('niveau_actuel') }}' || '',
            filiere: '{{ old('filiere') }}' || '',

            typeDocumentConcerne: '{{ old('type_document_concerne') }}' || '',
            numeroDemande: '{{ old('numero_demande_concerne') }}' || '',
            sujetReclamation: '{{ old('sujet') }}' || '',
            descriptionReclamation: '{{ old('description') }}' || '',

            stage: {
                nomEntreprise: '{{ old('nom_entreprise') }}',
                emailEntreprise: '{{ old('email_entreprise') }}',
                adresseEntreprise: '{{ old('adresse_entreprise') }}',
                encadrantEntreprise: '{{ old('nom_encadrant_entreprise') }}',
                encadrantEcole: '{{ old('nom_encadrant_ecole') }}',
                sujet: '{{ old('sujet_stage') }}',
                duree: '{{ old('duree_stage') }}',
                dateDebut: '{{ old('date_debut') }}',
                dateFin: '{{ old('date_fin') }}',
            },

            etudiant: null,
            etudiantLoaded: false,
            identityError: '',
            loading: false,
            availableYears: [],
            formAction: '{{ route('demande.store') }}',

            init() {
                this.updateFormAction();
                if (this.hasIdentityFilled()) {
                    this.fetchEtudiant();
                }
            },

            hasIdentityFilled() {
                return this.cin.trim() !== '' && this.numeroApogee.trim() !== '' && this.email.trim() !== '';
            },

            onIdentityChange() {
                this.etudiantLoaded = false;
                this.identityError = '';
                this.availableYears = [];
                if (this.hasIdentityFilled()) {
                    this.fetchEtudiant();
                }
            },

            updateFormAction() {
                this.formAction = this.requestType === 'reclamation'
                    ? '{{ route('reclamation.store') }}'
                    : '{{ route('demande.store') }}';
            },

            niveauLabel() {
                switch (this.niveau) {
                    case '2ap1': return '2AP1';
                    case '2ap2': return '2AP2';
                    case 'ci1': return 'CI1';
                    case 'ci2': return 'CI2';
                    case 'ci3': return 'CI3';
                    default: return 'Non renseigné';
                }
            },

            mapNiveauIntToCode(value) {
                switch (Number(value)) {
                    case 1: return '2ap1';
                    case 2: return '2ap2';
                    case 3: return 'ci1';
                    case 4: return 'ci2';
                    case 5: return 'ci3';
                    default: return '';
                }
            },

            updateAvailableYears() {
                if (!this.etudiantLoaded) return;
                const studentYear = Number(this.etudiant.niveau_actuel || 1);
                const now = new Date();
                const academicYearStart = now.getMonth() >= 8 ? now.getFullYear() : now.getFullYear() - 1;
                this.availableYears = [];
                for (let level = studentYear; level >= 1; level--) {
                    const start = academicYearStart - (studentYear - level);
                    const end = start + 1;
                    this.availableYears.push(`${start}-${end}`);
                }
            },

            async fetchEtudiant() {
                this.loading = true;
                try {
                    const url = `/api/etudiants/lookup?cin=${encodeURIComponent(this.cin)}&numero_apogee=${encodeURIComponent(this.numeroApogee)}&email=${encodeURIComponent(this.email)}`;
                    const response = await fetch(url, { headers: { 'Accept': 'application/json' } });
                    if (!response.ok) {
                        this.etudiantLoaded = false;
                        const payload = await response.json().catch(() => ({}));
                        this.identityError = payload.message || 'Étudiant introuvable. Vérifiez vos informations.';
                        return;
                    }
                    this.etudiant = await response.json();
                    this.etudiantLoaded = true;
                    this.identityError = '';
                    const niveauCode = this.mapNiveauIntToCode(this.etudiant.niveau_actuel);
                    this.niveau = this.niveau || niveauCode;
                    this.filiere = this.filiere || (this.etudiant.filiere_actuelle || '');
                    this.updateAvailableYears();
                } catch (error) {
                    this.identityError = 'Erreur lors de la récupération des informations. Réessayez.';
                    this.etudiantLoaded = false;
                } finally {
                    this.loading = false;
                }
            },

            canChooseType() {
                return this.etudiantLoaded && this.hasIdentityFilled();
            },

            isFormValid() {
                if (!this.hasIdentityFilled() || !this.etudiantLoaded) return false;
                if (!this.requestType) return false;

                if (this.requestType === 'demande') {
                    if (!this.documentType || !this.niveau) return false;
                    if (['ci1', 'ci2', 'ci3'].includes(this.niveau) && (!this.filiere || this.filiere.trim() === '')) return false;
                    if (['releve_notes', 'reussite'].includes(this.documentType)) {
                        if (!this.selectedYear) return false;
                    }
                    if (this.documentType === 'convention_stage') {
                        const s = this.stage;
                        if (!s.nomEntreprise || !s.emailEntreprise || !s.adresseEntreprise || !s.encadrantEntreprise || !s.encadrantEcole || !s.sujet || !s.duree || !s.dateDebut || !s.dateFin) {
                            return false;
                        }
                    }
                    return true;
                }

                if (this.requestType === 'reclamation') {
                    return this.typeDocumentConcerne && this.numeroDemande && this.sujetReclamation && this.descriptionReclamation;
                }

                return false;
            }
        }
    }
</script>

@endsection

