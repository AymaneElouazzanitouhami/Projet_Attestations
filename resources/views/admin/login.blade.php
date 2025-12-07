@extends('layouts.app')

@section('title', 'Connexion Administration - ATTESTA')

@section('content')

<section id="admin-login" class="admin-login section" style="padding-top: 120px; min-height: 80vh;">
    <div class="container">

        <div class="row gy-4 align-items-center">

            <!-- COLONNE 1 : L'ILLUSTRATION -->
            <div class="col-lg-6" data-aos="fade-right">
                <img src="{{ asset('assets/img/illustration_admin.png') }}" class="img-fluid" alt="Illustration de l'espace administration">
            </div>

            <!-- COLONNE 2 : LE FORMULAIRE DE CONNEXION -->
            <div class="col-lg-6">
                <div class="admin-login-card" data-aos="fade-left" data-aos-delay="100">
                    
                    <div class="container section-title text-center mb-4">
                        <h2>Espace Administration</h2>
                        <p>Veuillez vous connecter pour continuer.</p>
                    </div>

                    {{-- Affiche les erreurs de connexion ici --}}
                    @if ($errors->any())
                        <div class="alert alert-danger my-3" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="php-email-form">
                        
                        {{-- CORRECTION : L'attribut "action" est maintenant actif et pointe vers la bonne route --}}
                        <form action="{{ route('admin.login.submit') }}" method="post">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-12">
                                    <label for="email">Adresse Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="Votre Email" value="{{ old('email') }}" required>
                                </div>

                                <div class="col-12">
                                    <label for="password">Mot de passe</label>
                                    <input type="password" class="form-control" name="password" placeholder="Votre Mot de passe" required>
                                </div>

                                <div class="col-12 text-center mt-4">
                                    <button type="submit">Se Connecter</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

        </div>

    </div>
</section>
