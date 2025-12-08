@extends('layouts.app')

@section('title', '404 - Page non trouvée')

@section('content')

    <!-- La balise <main> est déjà dans le layout, nous ajoutons directement le contenu -->

    <!-- Page Title -->
    <div class="page-title" data-aos="fade">
      <div class="container">
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{ url('/') }}">Accueil</a></li>
            <li class="current">404</li>
          </ol>
        </nav>
        <h1>Page non trouvée</h1>
      </div>
    </div><!-- End Page Title -->

    <!-- Section -->
    <section class="section">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h2 class="mb-4">Désolé, la page que vous cherchez n'existe pas.</h2>
            <p class="mb-5">Vous avez peut-être mal tapé l'adresse ou la page a été déplacée.</p>
            <a href="{{ url('/') }}" class="btn-get-started">Retour à l'accueil</a>
          </div>
        </div>
      </div>
    </section><!-- /Section -->

@endsection
