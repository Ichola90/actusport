@extends('Users.Template.layout')
@section('title', $article->title . ' – InfoflashSports')
@section('description', Str::limit(strip_tags($article->content), 160))
@section('keywords', 'sport, ' . $article->categorie . ', InfoflashSports')

@section('og_title', $article->title . ' – InfoflashSports')
@section('og_description', Str::limit(strip_tags($article->content), 160))
@section('og_image', $article->image ? asset($article->image) : asset('assets/img/logo/logoif.png'))
@section('og_type', 'article')

@section('twitter_title', $article->title . ' – InfoflashSports')
@section('twitter_description', Str::limit(strip_tags($article->content), 160))
@section('twitter_image', $article->image ? asset($article->image) : asset('assets/img/logo/logoif.png'))

@section('content')


<style>
    .hero-img-wrapper {
        position: relative !important;
        width: 100% !important;
        overflow: hidden !important;
    }

    .hero-article-img {
        width: 100% !important;
        height: 400px !important;
        /* desktop */
        object-fit: cover !important;
        display: block !important;
        border-radius: 0 !important;
        /* coins carrés */
    }

    /* Catégorie sur l’image */
    .post-category {
        position: absolute !important;
        bottom: 10px !important;
        left: 10px !important;
        background-color: #0044aa !important;
        color: #fff !important;
        padding: 0.2rem 0.5rem !important;
        border-radius: 2px !important;
        font-weight: bold !important;
        z-index: 10 !important;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-article-img {
            height: 250px !important;
        }
    }

    @media (max-width: 480px) {
        .hero-article-img {
            height: 180px !important;
        }
    }

    .blog-details.section {
        padding-top: 0 !important;
        margin-top: 0 !important;
    }

    .article-tags {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.5rem;
    }

    .article-tags h6 {
        margin: 0;
        margin-right: 0.5rem;
        white-space: nowrap;

    }

    .tag-link {
        background: #f1f3f7;
        color: #000;
        text-decoration: none;
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 0.85rem;
        display: inline-block;
    }
</style>


@php
use Carbon\Carbon;
setlocale(LC_TIME, 'fr_FR.UTF-8');

// Auteur principal
$author = $article->author ?? null;
$authorPhoto = $author && $author->photo
? asset('assets/images/users/' . $author->photo)
: asset('assets/images/users/1.jpg');
$authorName = $author
? trim(implode(' ', array_filter([
$author->prenom ?? null,
$author->nom ?? null,
$author->name ?? null
])))
: 'Admin';
$authorAbout = $author && $author->about ? $author->about : "Cet auteur n'a pas encore ajouté de description.";
@endphp

<!-- Page Title -->
<div class="page-title">
    <div class="breadcrumbs">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bi bi-house"></i> Accueil</a></li>
                <li class="breadcrumb-item active current">Omnisport / Details</li>
            </ol>
        </nav>
    </div>

    <div class="title-wrapper">
        <h1>{{ $article->title }}</h1>
        <p>{!! Str::limit(strip_tags($article->content), 100) !!}</p>
    </div>
</div>

<div class="container">
    <div class="row">

        <!-- Article Details -->
        <div class="col-lg-8">
            <section id="blog-details" class="blog-details section">


                <article class="article">

                    <!-- Hero Image -->
                    <div class="hero-img-wrapper" data-aos="zoom-in">
                        @if($article->image)
                        <img src="{{ asset($article->image) }}"
                            alt="{{ $article->title }}"
                            class="hero-article-img">
                        @else
                        <img src="https://via.placeholder.com/800x400?text=Article"
                            alt="No Image"
                            class="hero-article-img">
                        @endif

                        @if($article->category)
                        <h6 class="post-category">
                            {{ $article->category }}
                        </h6>
                        @endif
                    </div>


                    <!-- Article Content -->
                    <div class="article-content mt-2" data-aos="fade-up" data-aos-delay="100">
                        <div class="author-info d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ $authorPhoto }}" alt="{{ $authorName }}"
                                    class="img-fluid post-author-img flex-shrink-0" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                                <div>
                                   @php
                                    // Détermine le "slug" du type d'auteur (pour la route)
                                    $authorType = ($author instanceof \App\Models\Collaborateur) ? 'collaborateur' : 'user';
                                    @endphp

                                    <h5 class="post-author">
                                        <a href="{{ route('articles.byAuthor', ['type' => $authorType, 'id' => $author->id]) }}"
                                            style="text-decoration:none; color:inherit;">
                                            {{ $authorName }}
                                        </a>
</h5>
                                </div>
                            </div>
                            <div class="post-meta" style="display: flex; align-items: center; gap: 20px; font-size: 0.9rem; color: #555;">
                                <span class="date" style="display: flex; align-items: center; gap: 5px;">
                                    <i class="bi bi-calendar3"></i>
                                    {{ Carbon::parse($article->created_at)->format('d/m/Y') }}
                                </span>
                            </div>
                        </div>

                        <div class="content">
                            {!! embedSocial($article->content) !!}


                            @if($article->tags)
                            <div class="article-tags mt-4 d-flex align-items-center gap-2">
                                <h6 class="fw-bold me-2">Mots-clés :</h6>
                                @foreach(explode(',', $article->tags) as $tag)
                                <a href="{{ route('articles.byTag', ['tag' => trim($tag)]) }} "
                                    class="badge me-1 mb-2 tag-link"
                                    style="background:#f1f3f7; color:#000; text-decoration:none;">
                                    {{ trim($tag) }}
                                </a>
                                @endforeach
                            </div>
                            @endif
                        </div>

                        <!-- À propos de l'auteur -->
                        <div class="author-bio mt-5 p-3 rounded shadow-sm" style="background: #f9f9f9; border-left: 4px solid #7ed957;">
                            <div class="d-flex align-items-start gap-3">
                                <img src="{{ $authorPhoto }}" alt="{{ $authorName }}"
                                    class="rounded-circle flex-shrink-0" width="60" height="60"
                                    style="object-fit: cover; border: 2px solid #ddd;">
                                <div>
                                    <h5 class="mb-1">À propos de l'auteur: <strong>{{ $authorName }}</strong></h5>
                                    <p class="mb-0" style="font-size: 0.95rem; color: #555;">
                                        {{ $authorAbout }}
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="mt-2">
                        <br>
                        @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif
                        <br>
                        <button id="toggleCommentForm" class="btn btn-success px-4 py-2" style="margin-left: 15px;">
                            Laisser un commentaire
                        </button>
                    </div>

                    <!-- Comment Form (initialement caché) -->
                    <div id="commentForm" class="mt-4 p-4 rounded shadow-sm bg-white border border-light" style="display: none;">
                        <h5 class="mb-4 fw-bold text-success">Laissez un commentaire</h5>
                        <form action="{{ route('comments.store', $article->id) }}" method="POST">


                            @csrf

                            <!-- Champs cachés pour le polymorphisme -->
                            <input type="hidden" name="commentable_id" value="{{ $article->id }}">
                            <input type="hidden" name="commentable_type" value="{{ get_class($article) }}">


                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Nom</label>
                                <input type="text" name="name" id="name" class="form-control form-control-lg rounded-pill" placeholder="Votre nom" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" id="email" class="form-control form-control-lg rounded-pill" placeholder="Votre email" required>
                            </div>

                            <div class="mb-3">
                                <label for="comment" class="form-label fw-semibold">Commentaire</label>
                                <textarea name="comment" id="comment" rows="5" class="form-control rounded-3" placeholder="Votre commentaire..." required></textarea>
                            </div>

                            <button type="submit" class="btn btn-success px-4 py-2 fw-bold shadow-sm">
                                Envoyer
                            </button>
                        </form>
                    </div>

                    <!-- JS pour toggle du formulaire -->
                    <script>
                        document.getElementById('toggleCommentForm').addEventListener('click', function() {
                            const form = document.getElementById('commentForm');
                            form.style.display = form.style.display === 'none' ? 'block' : 'none';
                            this.textContent = form.style.display === 'block' ? 'Annuler' : 'Laisser un commentaire';
                        });
                    </script>

                </article>


            </section>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4 sidebar">
            <div class="widgets-container">

                <!-- Search Widget -->
                <div class="search-widget widget-item">
                    <h3 class="widget-title">Recherche</h3>
                    <form action="" method="GET">
                        <input type="text" name="query" placeholder="Rechercher un article...">
                        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
                    </form>
                </div>

                <!-- Recent Posts Widget -->
                <div class="recent-posts-widget widget-item mt-4">
                    <h3 class="widget-title">Articles récents</h3>
                    @foreach($recentPosts as $post)
                    <div class="post-item d-flex mb-3">
                        <img src="{{ $post->image ? asset($post->image) : 'https://via.placeholder.com/80x80?text=Article' }}"
                            alt="{{ $post->title }}" class="flex-shrink-0 me-2" width="80">
                        <div>
                            <h4><a href="{{ route('articles.show.omnisport', $post->slug) }}">{{ Str::limit($post->title, 30) }}</a></h4>
                            <time datetime="{{ $post->created_at->format('Y-m-d') }}">
                                {{ Carbon::parse($post->created_at)->translatedFormat('d F Y') }}
                            </time>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>

    </div>
</div>

<!-- Facebook SDK -->
<div id="fb-root"></div>
<script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v17.0"
        nonce="{{ Str::random(10) }}"></script>

<!-- Instagram SDK -->
<script async defer src="//www.instagram.com/embed.js"></script>

<!-- Twitter SDK -->
<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>

<!-- TikTok SDK -->
<script async src="https://www.tiktok.com/embed.js"></script>

<!-- Recharge automatique après le rendu -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Instagram
    if (window.instgrm && window.instgrm.Embeds) {
        window.instgrm.Embeds.process();
    }

    // Twitter / X
    if (window.twttr && window.twttr.widgets) {
        window.twttr.widgets.load();
    }

    // Facebook
    if (window.FB && window.FB.XFBML) {
        window.FB.XFBML.parse();
    }

    // TikTok (gère automatiquement la plupart des cas)
});
</script>
@endsection