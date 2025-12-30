<!DOCTYPE html>
<html lang="fr">
<!-- [Head] start -->

<head>
  <title>@yield('title', 'Admin Dashboard') | ATTESTA</title>
  <!-- [Meta] -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Espace Administration ATTESTA - ENSA Tétouan">
  <meta name="author" content="ATTESTA">

  <!-- [Favicon] icon -->
  <link rel="icon" href="{{ asset('assets/admin/assets/images/favicon.svg') }}" type="image/x-icon">

  <!-- [Google Font] Family -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
  
  <!-- [Tabler Icons] -->
  <link rel="stylesheet" href="{{ asset('assets/admin/assets/fonts/tabler-icons.min.css') }}">
  <!-- [Feather Icons] -->
  <link rel="stylesheet" href="{{ asset('assets/admin/assets/fonts/feather.css') }}">
  <!-- [Font Awesome Icons] -->
  <link rel="stylesheet" href="{{ asset('assets/admin/assets/fonts/fontawesome.css') }}">
  <!-- [Material Icons] -->
  <link rel="stylesheet" href="{{ asset('assets/admin/assets/fonts/material.css') }}">
  
  <!-- [Template CSS Files] -->
  <link rel="stylesheet" href="{{ asset('assets/admin/assets/css/style.css') }}" id="main-style-link">
  <link rel="stylesheet" href="{{ asset('assets/admin/assets/css/style-preset.css') }}">

  @yield('styles')
</head>
<!-- [Head] end -->

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
  <!-- [ Pre-loader ] start -->
  <div class="loader-bg">
    <div class="loader-track">
      <div class="loader-fill"></div>
    </div>
  </div>
  <!-- [ Pre-loader ] End -->

  <!-- [ Sidebar Menu ] start -->
  <nav class="pc-sidebar">
    <div class="navbar-wrapper">
      <div class="m-header">
        <a href="{{ route('admin.dashboard') }}" class="b-brand text-primary">
          <!-- LOGO : Utilisation de votre logo public pour la cohérence -->
          <img src="{{ asset('assets/img/logo.png') }}" alt="ATTESTA Logo" class="img-fluid logo-lg" style="max-height: 40px;">
        </a>
      </div>
      <div class="navbar-content">
        <ul class="pc-navbar">
          
          <!-- SECTION NAVIGATION -->
          <li class="pc-item pc-caption">
            <label>Navigation</label>
            <i class="ti ti-dashboard"></i>
          </li>
          <li class="pc-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}" class="pc-link">
              <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
              <span class="pc-mtext">Tableau de Bord</span>
            </a>
          </li>

          <!-- SECTION GESTION -->
          <li class="pc-item pc-caption">
            <label>Gestion des Services</label>
            <i class="ti ti-apps"></i>
          </li>

          <li class="pc-item {{ request()->routeIs('admin.demandes') ? 'active' : '' }}">
            <a href="{{ route('admin.demandes') }}" class="pc-link">
              <span class="pc-micon"><i class="ti ti-file-text"></i></span>
              <span class="pc-mtext">Demandes d'Attestation</span>
            </a>
          </li>

          <li class="pc-item {{ request()->routeIs('admin.reclamations') ? 'active' : '' }}">
            <a href="{{ route('admin.reclamations') }}" class="pc-link">
              <span class="pc-micon"><i class="ti ti-alert-circle"></i></span>
              <span class="pc-mtext">Réclamations</span>
            </a>
          </li>

          <li class="pc-item {{ request()->routeIs('admin.historique') ? 'active' : '' }}">
            <a href="{{ route('admin.historique') }}" class="pc-link">
              <span class="pc-micon"><i class="ti ti-history"></i></span>
              <span class="pc-mtext">Historique</span>
            </a>
          </li>

          <!-- SECTION COMPTE -->
          <li class="pc-item pc-caption">
            <label>Système</label>
            <i class="ti ti-settings"></i>
          </li>
          <li class="pc-item">
            <a href="#" class="pc-link" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
              <span class="pc-micon"><i class="ti ti-power"></i></span>
              <span class="pc-mtext">Déconnexion</span>
            </a>
            <form id="logout-form-sidebar" action="{{ route('admin.logout') }}" method="POST" class="d-none" style="display: none;">
                @csrf
            </form>
          </li>
        </ul>
        
        <!-- NOTE : La carte "Upgrade to Pro" a été supprimée ici pour nettoyer l'interface -->
      </div>
    </div>
  </nav>
  <!-- [ Sidebar Menu ] end -->

  <!-- [ Header Topbar ] start -->
  <header class="pc-header">
    <div class="header-wrapper">
      <!-- [Mobile Media Block] -->
      <div class="me-auto pc-mob-drp">
        <ul class="list-unstyled">
          <li class="pc-h-item header-mobile-collapse">
            <a href="#" class="pc-head-link head-link-secondary ms-0" id="sidebar-hide">
              <i class="ti ti-menu-2"></i>
            </a>
          </li>
          <li class="pc-h-item pc-sidebar-popup">
            <a href="#" class="pc-head-link head-link-secondary ms-0" id="mobile-collapse">
              <i class="ti ti-menu-2"></i>
            </a>
          </li>
        </ul>
      </div>
      
      <!-- [Header Right Menu] -->
      <div class="ms-auto">
        <ul class="list-unstyled">
        </ul>
      </div>
    </div>
  </header>
  <!-- [ Header ] end -->

  <!-- [ Main Content ] start -->
  <div class="pc-container">
    <div class="pc-content">
      
      <!-- [ breadcrumb ] start -->
      <div class="page-header">
        <div class="page-block">
          <div class="row align-items-center">
            <div class="col-md-12">
              <div class="page-header-title">
                <h5 class="m-b-10">@yield('title')</h5>
              </div>
              <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Accueil</a></li>
                @yield('breadcrumb')
              </ul>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->

      <!-- [ Main Content ] -->
      @yield('content')

    </div>
  </div>
  <!-- [ Main Content ] end -->

  <!-- [ Footer ] start -->
  <footer class="pc-footer">
    <div class="footer-wrapper container-fluid">
      <div class="row">
        <div class="col-sm my-1">
          <p class="m-0">ATTESTA &copy; {{ date('Y') }} - Administration des Services Étudiants ENSA Tétouan</p>
        </div>
        <div class="col-auto my-1">
          <ul class="list-inline footer-link mb-0">
            <li class="list-inline-item"><a href="{{ route('home') }}" target="_blank">Accéder au Site Public</a></li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
  <!-- [ Footer ] end -->

  <!-- [Page Specific JS] start -->
  <!-- Script ApexChart (Essentiel pour les graphiques) -->
  <script src="{{ asset('assets/admin/assets/js/plugins/apexcharts.min.js') }}"></script>
  <!-- [Page Specific JS] end -->
  
  <!-- Required Js -->
  <script src="{{ asset('assets/admin/assets/js/plugins/popper.min.js') }}"></script>
  <script src="{{ asset('assets/admin/assets/js/plugins/simplebar.min.js') }}"></script>
  <script src="{{ asset('assets/admin/assets/js/plugins/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/admin/assets/js/fonts/custom-font.js') }}"></script>
  <script src="{{ asset('assets/admin/assets/js/pcoded.js') }}"></script>
  <script src="{{ asset('assets/admin/assets/js/plugins/feather.min.js') }}"></script>

  <!-- Scripts de configuration du template -->
  <script>layout_change('light');</script>
  <script>change_box_container('false');</script>
  <script>layout_rtl_change('false');</script>
  <script>preset_change("preset-1");</script>
  <script>font_change("Public-Sans");</script>

  @yield('scripts')

</body>
<!-- [Body] end -->
</html>