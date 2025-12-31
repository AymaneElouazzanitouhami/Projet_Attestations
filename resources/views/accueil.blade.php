@extends('layouts.app')

@section('title', 'Accueil - ATTESTA')

@section('content')

<!-- Hero Section -->
<section id="hero" class="hero section dark-background">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="zoom-out">
                <h1>Plateforme de gestion des attestations</h1>
                <p>Simple, rapide et sécurisé pour les étudiants de l'ENSA Tétouan.</p>

            </div>
            <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out" data-aos-delay="200">
                <img src="{{ asset('assets/img/hero.png') }}" class="img-fluid animated" alt="Illustration d'étudiants">
            </div>
        </div>
    </div>
</section><!-- /Hero Section -->

<!-- About Section -->
<section id="about" class="about section">
    <div class="container section-title" data-aos="fade-up">
        <h2>À Propos du Projet</h2>
    </div>
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
                <p>
                    ATTESTA a été conçu pour simplifier et accélérer le processus de demande et de délivrance des documents administratifs pour les étudiants.
                </p>
                <ul>
                    <li><i class="bi bi-check2-circle"></i> <span>Automatisation complète des demandes.</span></li>
                    <li><i class="bi bi-check2-circle"></i> <span>Communication 100% asynchrone par Email.</span></li>
                    <li><i class="bi bi-check2-circle"></i> <span>Logique de validation des demandes intégrée et sécurisée.</span></li>
                </ul>
            </div>
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                <p>Fini les déplacements et les longues files d'attente. Soumettez votre demande en ligne et recevez votre document directement dans votre boîte mail après validation par l'administration.</p>
                <a href="#services" class="read-more"><span>Voir nos services</span><i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section><!-- /About Section -->

<!-- Services Section -->
<section id="services" class="services section light-background">
    <div class="container section-title" data-aos="fade-up">
        <h2>Nos Services</h2>
        <p>Demandez facilement l'un des types d'attestations disponibles. Le traitement est entièrement numérique.</p>
    </div>
    <div class="container">
        <div class="row gy-4">
            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
                <div class="service-item position-relative">
                    <div class="icon"><i class="bi bi-patch-check icon"></i></div>
                    <h4><a href="#contact" class="stretched-link">Attestation de Scolarité</a></h4>
                    <p>Prouve votre inscription active pour l'année universitaire en cours.</p>
                </div>
            </div><!-- End Service Item -->
            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="200">
                <div class="service-item position-relative">
                    <div class="icon"><i class="bi bi-file-earmark-text icon"></i></div>
                    <h4><a href="#contact" class="stretched-link">Relevé de Notes</a></h4>
                    <p>Obtenez le détail de vos résultats pour une période clôturée.</p>
                </div>
            </div><!-- End Service Item -->
            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="300">
                <div class="service-item position-relative">
                    <div class="icon"><i class="bi bi-award icon"></i></div>
                    <h4><a href="#contact" class="stretched-link">Attestation de Réussite</a></h4>
                    <p>Confirme la validation de votre cycle ou de votre année universitaire.</p>
                </div>
            </div><!-- End Service Item -->
               <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="300">
                <div class="service-item position-relative">
                    <div class="icon"><i class="bi bi-award icon"></i></div>
                    <h4><a href="#contact" class="stretched-link">Convention de Stage</a></h4>
                    <p>Demander votre convention de stage.</p>
                </div>
            </div>
        </div>
    </div>
</section><!-- /Services Section -->

<!-- Contact Section -->
<section id="contact" class="contact section">
    <div class="container section-title" data-aos="fade-up">
        <h2>Faire une Demande / Réclamation</h2>
    </div>
    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="form-wrapper">
            <div class="row gy-4">
                <div class="col-lg-12">
                    <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                        <i class="bi bi-box-arrow-in-right flex-shrink-0"></i>
                        <div>
                            <h3>Accéder directement au Espace de Demande attestation ou Déposer une réclamation</h3>
                            <p>Pas d'identification préalable : cliquez ci-dessous pour saisir votre CIN, Apogée et Email puis choisir Réclamation ou Demande d'attestation.</p>
                            <a class="btn btn-primary mt-3" href="{{ route('demande_reclamation.formulaire') }}">Faire DEMANDE ou RECLAMATION</a>
                            <a class="btn btn-outline-primary mt-3 me-2" href="{{ route('demande.suivi.form') }}">Suivre l'etat de votre demande</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!-- /Contact Section -->




@endsection

