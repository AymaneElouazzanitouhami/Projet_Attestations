@extends('layouts.app')

@section('title', 'Demande Envoyée - ATTESTA')

@section('content')

<section id="succes" class="succes section" style="padding-top: 120px; min-height: 80vh;">
    <div class="container text-center">

        <div class="container section-title" data-aos="fade-up">
            <h2 style="color: #28a745;">Demande envoyée avec succès !</h2>
            <p>Votre demande a bien été enregistrée et sera traitée par l'administration dans les plus brefs délais.<br>Vous recevrez une notification par email une fois votre document prêt.</p>
        </div>

        <div class="row gy-4 justify-content-center" data-aos="fade-up" data-aos-delay="100">
            <div class="col-lg-8 d-flex justify-content-center" style="gap: 20px;">
                
                {{-- CORRECTION : On utilise des classes CSS dédiées pour un style robuste --}}
                
                <!-- Bouton Secondaire (style "outline") -->
                
                <!-- Bouton Principal (style plein) -->

            </div>
        </div>
    </div>
</section>

@endsection

