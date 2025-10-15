<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>@yield('title', 'InfoflashSports – Toute l\'actualité sportive en temps réel')</title>
  <meta name="description" content="@yield('description', 'Suivez toutes les actualités sportives : transferts, analyses, résultats et tendances du sport africain et international.')">
  <meta name="keywords" content="@yield('keywords', 'sport, actualité sportive, transferts, résultats, analyses, Afrique, international, omnisport, mercato, wags, célébrités sportives')">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/logo/logoif.ico') }}" rel="icon" type="image/png">
  <link href="{{ asset('assets/img/logo/logoif.ico') }}" rel="apple-touch-icon" type="image/png">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

  <!-- CSS -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

  <!-- Open Graph -->
  <meta property="og:title" content="@yield('og_title', 'InfoflashSports – Toute l\'actualité sportive en temps réel')">
  <meta property="og:description" content="@yield('og_description', 'Suivez toutes les actualités sportives : transferts, analyses, résultats et tendances du sport africain et international.')">
  <meta property="og:image" content="@yield('og_image', asset('assets/img/logo/logoif.png'))">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta property="og:type" content="@yield('og_type', 'website')">

  <!-- Twitter -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="@yield('twitter_title', 'InfoflashSports – Toute l\'actualité sportive en temps réel')">
  <meta name="twitter:description" content="@yield('twitter_description', 'Suivez toutes les actualités sportives : transferts, analyses, résultats et tendances du sport africain et international.')">
  <meta name="twitter:image" content="@yield('twitter_image', asset('assets/img/logo/logoif.png'))">
</head>
