<!DOCTYPE html>
<html lang="en">

@include('Users.Template.head')

<style>
    * {
        font-family: 'Lora', serif;
    }

    .whatsapp-float {
        position: fixed;
        bottom: 20px;
        left: 20px;
        width: 55px;
        height: 55px;
        background-color: #25D366;
        color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .whatsapp-float:hover {
        transform: scale(1.1);
        box-shadow: 2px 4px 12px rgba(0, 0, 0, 0.3);
        color: #fff;
    }
</style>

<body class="category-page">

    @include('Users.Template.header')

    <main class="main">
        @yield('content')
    </main>

    @include('Users.Template.footer')

    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>
    <a href="https://wa.me/22953087433" target="_blank" class="whatsapp-float">
        <i class="bi bi-whatsapp"></i>
    </a>
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <!-- Instagram -->
    <script async src="//www.instagram.com/embed.js"></script>

    <!-- Twitter -->

    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>

    <!-- Facebook -->
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v19.0"></script>

    <!-- TikTok -->
    <script async src="https://www.tiktok.com/embed.js"></script>
</body>

</html>