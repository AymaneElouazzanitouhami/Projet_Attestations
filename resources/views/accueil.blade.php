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
                <div class="d-flex" style="gap: 15px;">
                    <a href="#contact" class="btn-get-started">Commencer une demande</a>
                    <a href="#contact" class="btn-get-started">Déposer une réclamation</a>
                </div>
            </div>
            <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out" data-aos-delay="200">
                <img src="{{ asset('assets/img/hero-img.png') }}" class="img-fluid animated" alt="Illustration d'étudiants">
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
            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="400">
                <div class="service-item position-relative">
                    <div class="icon"><i class="bi bi-shield-check icon"></i></div>
                    <h4><a href="#contact" class="stretched-link">Non-Redoublement</a></h4>
                    <p>Atteste d'un parcours universitaire sans aucun redoublement.</p>
                </div>
            </div><!-- End Service Item -->
        </div>
    </div>
</section><!-- /Services Section -->

<!-- Team Section -->
<section id="team" class="team section">
    <div class="container section-title" data-aos="fade-up">
        <h2>Équipe Administrative</h2>
        <p>L'équipe de l'ENSA Tétouan dédiée au traitement rapide et efficace de vos demandes.</p>
    </div>
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                <div class="team-member d-flex align-items-start">
                    <div class="pic"><img src="{{ asset('assets/img/person/person-f-4.webp') }}" class="img-fluid" alt=""></div>
                    <div class="member-info">
                        <h4>Service Scolarité</h4>
                        <span>Traitement des attestations</span>
                        <p>Responsable de la vérification et de la validation de vos demandes.</p>
                    </div>
                </div>
            </div><!-- End Team Member -->
             <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                <div class="team-member d-flex align-items-start">
                    <div class="pic"><img src="{{ asset('assets/img/person/person-f-5.webp') }}" class="img-fluid" alt=""></div>
                    <div class="member-info">
                        <h4>Support Technique</h4>
                        <span>Administration de la plateforme</span>
                        <p>Assure le bon fonctionnement technique du service ATTESTA.</p>
                    </div>
                </div>
            </div><!-- End Team Member -->
        </div>
    </div>
</section><!-- /Team Section -->

<!-- Contact Section -->
<!-- Contact Section -->
<section id="contact" class="contact section">
    <div class="container section-title" data-aos="fade-up">
        <h2>Faire une Demande / Réclamation</h2>
    </div>
    <div class="container" data-aos="fade-up" data-aos-delay="100">

        {{-- AJOUT : Conteneur pour ajouter la bordure et le style --}}
        <div class="form-wrapper">
            <div class="row gy-4">
                <div class="col-lg-12">
                     <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                        <i class="bi bi-box-arrow-in-right flex-shrink-0"></i>
                        <div>
                            <h3>Identifiez-vous pour continuer</h3>
                            <p>Pour faire une nouvelle demande d'attestation ou déposer une réclamation, veuillez vous authentifier avec vos informations.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    
                    {{-- BLOC POUR AFFICHER LES ERREURS DE VALIDATION --}}
                    @if ($errors->any())
                        <div class="alert alert-danger my-3" role="alert" data-aos="fade-up" data-aos-delay="350">
                            <h4 class="alert-heading">Erreur d'identification !</h4>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('student.login') }}" method="post" data-aos="fade-up" data-aos-delay="400">
                        @csrf
                        <div class="row gy-4">
                            
                            <div class="col-md-12">
                                <input type="email" name="email" class="form-control" placeholder="Votre Email" value="{{ old('email') }}" required="">
                            </div>

                            <div class="col-md-6">
                                <input type="text" name="numero_apogee" class="form-control" placeholder="Votre N° Apogée" value="{{ old('numero_apogee') }}" required="">
                            </div>
                            
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="cin" placeholder="Votre CIN" value="{{ old('cin') }}" required="">
                            </div>

                            <div class="col-md-12 text-center"> 
                                <button type="submit">S'identifier et Continuer</button>
                            </div>
                        </div>
                    </form>
                </div><!-- End Contact Form -->
            </div>
        </div>
        {{-- FIN du conteneur --}}

    </div>
</section><!-- /Contact Section -->




@endsection

