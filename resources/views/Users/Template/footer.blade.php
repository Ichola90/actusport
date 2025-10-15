<footer id="footer" class="footer bg-dark text-light pt-5">
  <div class="container">
    <div class="row gy-4">

      <!-- Logo & Description -->
      <div class="col-lg-4 col-md-6 footer-about">
        <a href="{{ route('home') }}" class="logo d-flex align-items-center mb-3">
          <a href="{{ route('home') }}">
            <img src="{{ asset('assets/img/logo/logoif.png') }}" alt="ActuSport Logo" class="logo-img">
          </a>

        </a>
        <p>Votre source pour toutes les actualités sportives, le Mercato et les analyses Afrique/Europe. Restez informé en temps réel !</p>
        <div class="footer-contact mt-3">
          <p><i class="bi bi-geo-alt-fill me-2"></i>Cotonou, Bénin</p>
          <p><i class="bi bi-telephone-fill me-2"></i>+229 0153087433</p>
          <p><i class="bi bi-envelope-fill me-2"></i>contact@infoflashsport.com</p>
        </div>
        <div class="social-links mt-3 d-flex gap-2">
  
  <a href="https://www.facebook.com/share/19ueTvN9PH/" target="_blank" class="text-white fs-5">
    <i class="bi bi-facebook"></i>
  </a>
  <a href="https://www.instagram.com/infoflashsports?igsh=YzljYTk1ODg3Zg==" target="_blank" class="text-white fs-5">
    <i class="bi bi-instagram"></i>
  </a>
  <a href="https://x.com/honv9915?t=XOnGJHAuJaOXA2633mDO_w&s=09" target="_blank" class="text-white fs-5">
    <i class="bi bi-twitter"></i>
  </a>
</div>
  
      </div>

      <!-- Rubriques du Header -->
      <div class="col-lg-2 col-md-6 footer-links">
        <h5 class="mb-3 fw-bold text-white">Navigation</h5>
        <ul class="list-unstyled">
          <li><a href="{{ route('home') }}" class="text-light text-decoration-none">Accueil</a></li>
          <li>
            <a class="text-light text-decoration-none" data-bs-toggle="collapse" href="#footerMercatoDropdown" role="button" aria-expanded="false">
              Mercato
            </a>
            <ul class="collapse list-unstyled ps-3" id="footerMercatoDropdown">
              <li><a href="{{ route('show.mercato') }}" class="text-light text-decoration-none">Afrique</a></li>
              <li><a href="{{ route('show.actueurope') }}" class="text-light text-decoration-none">Europe</a></li>
            </ul>
          </li>
          <li>
            <a class="text-light text-decoration-none" data-bs-toggle="collapse" href="#footerActusDropdown" role="button" aria-expanded="false">
              ActusSport
            </a>
            <ul class="collapse list-unstyled ps-3" id="footerActusDropdown">
              <li><a href="{{ route('show.actuafrique') }}" class="text-light text-decoration-none">Afrique</a></li>
              <li><a href="{{ route('show.actueurope') }}" class="text-light text-decoration-none">Europe</a></li>
            </ul>
          </li>

          <li><a href="{{ route('show.omnisport') }}" class="text-light text-decoration-none">Omnisport</a></li>
          <li><a href="{{ route('show.wags') }}" class="text-light text-decoration-none">Wags</a></li>
          <li><a href="{{ route('show.celebrites') }}" class="text-light text-decoration-none">Célébrités Sportives</a></li>
        </ul>
      </div>

      <!-- Contact rapide -->
      <div class="col-lg-3 col-md-6 footer-links">
        <h5 class="mb-3 fw-bold text-white">Contact</h5>
        <ul class="list-unstyled">
          <li><a href="{{ route('show.contact') }}" class="text-light text-decoration-none">Nous contacter</a></li>
          <li><a href="{{ url('/') }}#newsletter" class="text-light text-decoration-none">Newsletter</a></li>
        </ul>
      </div>

      <!-- Tags / Thèmes populaires -->
      <div class="col-lg-3 col-md-6 footer-links">
        <h5 class="mb-3 fw-bold text-white">Thèmes populaires</h5>
        <ul class="list-unstyled d-flex flex-wrap gap-2">
          <li><a href="{{ route('show.mercato') }}" class="badge bg-primary text-white text-decoration-none">Mercato</a></li>
          <li><a href="{{ route('show.actuafrique') }}" class="badge bg-success text-white text-decoration-none">Afrique</a></li>
          <li><a href="{{ route('show.actueurope') }}" class="badge bg-danger text-white text-decoration-none">Europe</a></li>
          <li><a href="{{ route('show.omnisport') }}" class="badge bg-warning text-dark text-decoration-none">Omnisport</a></li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Copyright -->
  <div class="container text-center mt-4 pt-3 border-top border-secondary">
    <p class="mb-0">
      &copy; <strong>infoflashsports</strong>. Tous droits réservés. <br>
      développé par <a href="https://www.asoras.net" target="_blank" class="text-decoration-none"><strong>ASORAS</strong></a>
    </p>

  </div>

</footer>