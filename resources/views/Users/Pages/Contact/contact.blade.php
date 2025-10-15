@extends('Users.Template.layout')
@section('title','Contact')
@section('content')

<div class="page-title position-relative">
    <div class="breadcrumbs">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bi bi-house"></i> Accueil</a></li>
                <li class="breadcrumb-item active current">Contact</li>
            </ol>
        </nav>
    </div>

    <div class="title-wrapper text-center">
        <h1 style="color: #7ed957;">Contactez-nous</h1>
        <p class="text-muted">Vous avez une question ? Remplissez le formulaire ci-dessous ou contactez-nous via nos réseaux sociaux.</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">

        <!-- Infos de contact avec slider -->
        <div class="col-lg-4">

            <!-- Slider -->
            <div id="contactCarousel" class="carousel slide mb-4 shadow-sm rounded overflow-hidden" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('assets/img/contact/contact2.jpg') }}" class="d-block w-100 carousel-img" alt="Contact 1">
                    </div>

                    <div class="carousel-item">
                        <img src="{{ asset('assets/img/contact/contact3.jpg') }}" class="d-block w-100 carousel-img" alt="Contact 3">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('assets/img/contact/contact4.jpg') }}" class="d-block w-100 carousel-img" alt="Contact 3">
                    </div>
                </div>

                <!-- Boutons de navigation -->
                <button class="carousel-control-prev" type="button" data-bs-target="#contactCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#contactCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                </button>

                <!-- Message overlay -->
                <div class="carousel-caption d-none d-md-block text-start" style="top: 10%; left: 5%; right: 5%;">
                    <h2 class="fw-bold text-white shadow-sm" style="text-shadow: 2px 2px 5px rgba(0,0,0,0.7);">
                        Contactez-nous facilement !
                    </h2>
                    <p class="text-white fw-semibold shadow-sm" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.7);">
                        Nous sommes là pour répondre à toutes vos questions.
                    </p>
                </div>
            </div>

            <style>
                .carousel-img {
                    height: 290px !important;
                    object-fit: cover;
                }
            </style>

            <!-- Bloc coordonnées -->
            <div class="p-4 rounded shadow-sm h-95" style="background: #f9f9f9; border-left: 6px solid #7ed957;">
                <h4 style="color: #7ed957;">Nos coordonnées</h4>
                <p><i class="bi bi-geo-alt-fill text-success"></i> Cotonou, Bénin</p>
                <p><i class="bi bi-telephone-fill text-success"></i> +229 01 53 08 74 33</p>
                <p><i class="bi bi-envelope-fill text-success"></i>contact@infoflashsport.com</p>
                <p><i class="bi bi-globe2 text-success"></i><a href="/" target="_blank" style="color: black;"> https://infoflashsport.com</a></p>
                <div class="mt-3">
                    <a href="https://wa.me/22953087433" class="btn btn-success btn-sm me-2">
                        <i class="bi bi-whatsapp"></i> WhatsApp
                    </a>
                    <a href="https://www.facebook.com/share/19ueTvN9PH/" class="btn btn-primary btn-sm me-2" target="_blank">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="https://www.instagram.com/infoflashsports?igsh=YzljYTk1ODg3Zg==" target="_blank" class="btn btn-danger btn-sm me-2">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="https://x.com/honv9915?t=XOnGJHAuJaOXA2633mDO_w&s=09" target="_blank" class="btn btn-info btn-sm">
                        <i class="bi bi-twitter"></i>
                    </a>
                </div>

            </div>
        </div>

        <!-- Formulaire -->
        <div class="col-lg-8">
            <div class="p-4 rounded shadow-lg h-80" style="background: #ffffff; border-left: 6px solid #7ed957;">
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <h3 class="mb-4 fw-bold" style="color: #333;">
                    <i class="bi bi-envelope-paper text-success"></i> Contactez-nous
                </h3>
                <form action="{{ route('contact.send') }}" method="POST">
                    @csrf

                    <!-- Nom -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold"><i class="bi bi-person-circle text-success"></i> Nom complet</label>
                        <input type="text" name="name" class="form-control border-success shadow-sm" placeholder="Votre nom complet" required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold"><i class="bi bi-envelope-at text-success"></i> Email</label>
                        <input type="email" name="email" class="form-control border-success shadow-sm" placeholder="Votre adresse email" required>
                    </div>

                    <!-- Sujet -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold"><i class="bi bi-chat-dots text-success"></i> Sujet</label>
                        <input type="text" name="subject" class="form-control border-success shadow-sm" placeholder="Sujet de votre message" required>
                    </div>

                    <!-- Message -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold"><i class="bi bi-pencil-square text-success"></i> Message</label>
                        <textarea name="message" class="form-control border-success shadow-sm" rows="5" placeholder="Écrivez votre message ici..." required></textarea>
                    </div>

                    <!-- Bouton -->
                    <button type="submit" class="btn btn-success px-5 py-2 fw-bold shadow-sm rounded-pill">
                        <i class="bi bi-send-fill"></i> Envoyer
                    </button>
                </form>
            </div>
        </div>

        <style>
            .form-control:focus {
                border-color: #7ed957 !important;
                box-shadow: 0 0 2px rgba(126, 217, 87, 0.5) !important;
            }

            button.btn-success:hover {
                background-color: #6cc94c !important;
                transform: scale(1.05);
                transition: 0.3s ease;
            }

            .carousel img {
                height: 200px;
                object-fit: cover;
            }
        </style>

    </div>
</div>


@endsection