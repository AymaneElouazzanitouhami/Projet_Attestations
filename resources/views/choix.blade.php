@extends('layouts.app')

@section('title', 'Espace Étudiant - ATTESTA')

@section('content')

<!-- Section de Choix -->
<section id="services" class="services section light-background" style="padding-top: 120px; min-height: 80vh;">
    <div class="container">

        {{-- Titre de la section --}}
        <div class="container section-title" data-aos="fade-up">
            @if(session('etudiant'))
                <h2>Bienvenue, {{ session('etudiant')->prenom }} {{ session('etudiant')->nom }}</h2>
            @endif
            <p>Que souhaitez-vous faire aujourd'hui ?</p>
        </div>

        <div class="row gy-4 justify-content-center">

            <!-- Carte pour "Nouvelle Demande" -->
            <div class="col-xl-4 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
                {{-- AJOUT de la classe "text-center" pour centrer le contenu --}}
                <div class="service-item position-relative text-center">
                    <div class="icon"><i class="bi bi-file-earmark-text icon"></i></div>
                    <h4><a href="{{ route('demande.formulaire') }}" class="stretched-link">Demander une attestation</a></h4>
                    <p>Remplissez le formulaire pour obtenir un nouveau document administratif.</p>
                </div>
            </div>

            <!-- Carte pour "Déposer une Réclamation" -->
            <div class="col-xl-4 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="200">
                <div class="service-item position-relative text-center">
                    <div class="icon"><i class="bi bi-exclamation-octagon icon"></i></div>
                    <h4><a href="{{ route('reclamation.formulaire') }}" class="stretched-link">Déposer une réclamation</a></h4>
                    <p>Un problème avec une demande précédente ? Faites-le nous savoir ici.</p>
                </div>
            </div>

        </div>
    </div>
</section><!-- /Section de Choix -->

@endsection

