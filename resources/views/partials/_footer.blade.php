<footer id="footer" class="footer">

    <section class="light-background">
        <div class="footer-newsletter" id="admin">
            <div class="container light-background">
                <div class="row justify-content-center text-center">
                    <div class="col-lg-6">
                        <h4>Espace Administration</h4>
                        <p>Accès réservé au personnel de l'ENSA Tétouan pour le traitement des demandes.</p>
                        
                        {{-- CORRECTION : Le href pointe maintenant vers la route de la page de connexion admin --}}
                        <a href="{{ route('admin.login') }}" class="btn-admin-login">Se connecter</a>

                    </div>
                </div>
            </div>
        </div>
    </section>
 
    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-12 footer-about">
          <img src="{{ asset('assets/img/logo.png') }}" alt="Logo ATTESTA" id="botnfooter">
          <a href="{{ url('/') }}" class="logo d-flex align-items-center">
            <span class="sitename">ATTESTA</span>
          </a>
          <div class="footer-contact pt-3">
            <p>Avenue de la Palestine</p>
            <p>Mhanech I, Tétouan</p>
            <p class="mt-3"><strong>Téléphone:</strong> <span>+212 539 68 80 27</span></p>
            <p><strong>Email:</strong> <span>contact@ensa-tetouan.ac.ma</span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>
 
        <div class="col-lg-2 col-6 footer-links">
          <h4>Liens Utiles</h4>
          <ul>
            <li><i class="bi bi-chevron-right"></i> <a href="#hero">Accueil</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#about">À Propos</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#services">Services</a></li>
          </ul>
        </div>
 
        <div class="col-lg-2 col-6 footer-links">
          <h4>Nos Services</h4>
          <ul>
            <li><i class="bi bi-chevron-right"></i> <a>Attestation de Scolarité</a></li>
            <li><i class="bi bi-chevron-right"></i> <a>Relevé de Notes</a></li>
            <li><i class="bi bi-chevron-right"></i> <a>Attestation de Réussite</a></li>
          </ul>
        </div>
 
        <div class="col-lg-4 col-md-12 footer-newsletter text-center" >
          <h4>Notre Objectif</h4>
          <p>Notre mission est d'offrir une plateforme centralisée et intuitive où chaque demande d'attestation est traitée de manière rapide, sécurisée et entièrement numérique, vous permettant de vous concentrer sur l'essentiel : vos études.</p>
        </div>
 
      </div>
    </div>
 
    <div class="container copyright text-center mt-4 ">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">ATTESTA</strong> <span>Tous droits réservés</span></p>
      <div class="credits">
        created by <a href="https://bootstrapmade.com/">ATTESTA</a>
      </div>
    </div>
 
</footer>
