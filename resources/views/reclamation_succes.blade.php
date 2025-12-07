@extends('layouts.app')

@section('title', 'Réclamation Envoyée - ATTESTA')

@section('content')

<section id="succes" class="succes section" style="padding-top: 120px; min-height: 80vh;">
    <div class="container text-center">

        <div class="container section-title" data-aos="fade-up">
            <h2 style="color: #28a745;">Réclamation envoyée avec succès !</h2>
            <p>Votre réclamation a bien été enregistrée et sera examinée par l'administration.<br>Vous serez contacté par email concernant le suivi.</p>
        </div>

        <div class="row gy-4 justify-content-center" data-aos="fade-up" data-aos-delay="100">
            <div class="col-lg-8 d-flex justify-content-center" style="gap: 20px;">
                
                <!-- Bouton Secondaire -->
                <a href="{{ route('demande.formulaire') }}" class="btn-succes-secondaire">Faire une demande</a>
                
                <!-- Bouton Principal -->
                <a href="{{ route('reclamation.formulaire') }}" class="btn-succes-primaire">Déposer une autre réclamation</a>

            </div>
        </div>
    </div>
</section>

@endsection

