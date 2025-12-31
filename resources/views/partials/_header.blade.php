<header id="header" class="header d-flex align-items-center fixed-top @if(request()->routeIs('demande.formulaire') || request()->routeIs('reclamation.formulaire')) header-solid-dark @endif">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

        <a href="{{ route('home') }}" class="logo d-flex align-items-center me-auto">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo ATTESTA">
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                {{-- Si on est sur la page d'accueil, on affiche les ancres --}}
                @if(request()->routeIs('home'))
                    <li><a href="#hero" class="active">Accueil</a></li>
                    <li><a href="#about">À Propos</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#contact">Contact</a></li>
                @else
                {{-- Sur les autres pages, on affiche un simple lien de retour --}}
                    <li><a href="{{ route('home') }}">Retour à l'Accueil</a></li>
                @endif
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <a class="btn-getstarted" href="{{ route('admin.login') }}">Espace Administration</a>

    </div>
</header>

