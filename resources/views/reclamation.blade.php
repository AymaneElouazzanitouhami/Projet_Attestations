@extends('layouts.app')

@section('title', 'Déposer une Réclamation - ATTESTA')

@section('content')

<!-- Section du Formulaire de Réclamation -->
{{-- On utilise l'ID "contact" pour que le formulaire hérite des bons styles de bouton --}}
<section id="contact" class="contact section" style="padding-top: 120px;">
    <div class="container">
        <div class="row gy-4 align-items-center">

            <!-- Colonne du Formulaire (Animation depuis la gauche) -->
            <div class="col-lg-6" data-aos="fade-right">
                <div class="container section-title">
                    <h2>Formulaire de Réclamation</h2>
                    <p>Veuillez décrire votre problème ci-dessous.</p>
                </div>

                {{-- On enveloppe le formulaire pour récupérer les styles sans bloquer le bouton --}}
                <div class="php-email-form">
                    <form action="{{ route('reclamation.store') }}" method="post">
                        @csrf
                        <div class="row gy-4">
                            <!-- Champs Etudiant (Lecture seule) -->
                            <div class="col-12"><h5 class="form-subtitle">Vos Informations</h5></div>
                            <div class="col-md-6">
                                <label for="nom">Nom</label>
                                <input type="text" class="form-control" name="nom" value="{{ $etudiant->nom }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="prenom">Prénom</label>
                                <input type="text" class="form-control" name="prenom" value="{{ $etudiant->prenom }}" readonly>
                            </div>
                            
                            <hr class="my-4">

                            <!-- Champs de la Réclamation -->
                             <div class="col-12"><h5 class="form-subtitle">Détails de la réclamation</h5></div>
                            
                            {{-- CHAMP AJOUTÉ : Pour sélectionner la demande concernée --}}
                            <div class="col-12">
                                <label for="type_document_concerne">Type d'attestation concernée</label>
                                <select class="form-select" name="type_document_concerne" required>
                                    <option value="" disabled selected>-- Choisissez le type de document --</option>
                                    <option value="scolarite">Attestation de Scolarité</option>
                                    <option value="releve_notes">Relevé de Notes</option>
                                    <option value="reussite">Attestation de Réussite</option>
                                    <option value="non_redoublement">Attestation de Non-Redoublement</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="sujet">Sujet</label>
                                <input type="text" class="form-control" name="sujet" placeholder="Sujet de votre réclamation" required>
                            </div>

                            <div class="col-12">
                                <label for="description">Description détaillée</label>
                                <textarea class="form-control" name="description" rows="5" placeholder="Décrivez précisément votre problème" required></textarea>
                            </div>

                            <div class="col-12 text-center mt-4">
                                <button type="submit">Envoyer la Réclamation</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Colonne de l'Image (Animation depuis la droite) -->
            <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="fade-left" data-aos-delay="200">
                <img src="{{ asset('assets/img/hero-img.png') }}" class="img-fluid animated" alt="Illustration d'étudiants">
            </div>

        </div>
    </div>
</section><!-- /Form Section -->

@endsection

