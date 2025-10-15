@extends('Users.Template.layout')
@section('title','Actualités Sportives - Europe')
@section('content')

@php
use Carbon\Carbon;
setlocale(LC_TIME, 'fr_FR.UTF-8');
@endphp

<div class="page-title position-relative">
    <div class="breadcrumbs">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bi bi-house"></i> Accueil</a></li>
                <li class="breadcrumb-item active current">Actualités Sportives / Afrique</li>
            </ol>
        </nav>
    </div>

    <div class="title-wrapper">
        <h1 style="color: #7ed957;">Actualités Sportives - Afrique</h1>
        <p>Retrouvez toutes les dernières actualités sportives, résultats et analyses du continent africain.</p>
    </div>
</div>

<div class="container">
    <div class="row">

        <!-- Articles -->
        <div class="col-lg-8">
            <section class="category-postst section">
                <div class="row gy-4">
                    @forelse($articlesafriques as $article)
                    @php
                    $author = $article->author ?? null;
                    $authorPhoto = $author && $author->photo
                    ? asset('assets/images/users/' . $author->photo)
                    : asset('assets/images/users/1.jpg');
                    $authorName = $author
                    ? trim(($author->prenom ?? '') . ' ' . ($author->nom ?? $author->name ?? ''))
                    : 'Admin';
                    @endphp

                    <div class="col-lg-6">
                        <article>
                            <div class="post-img position-relative">
                                <img src="{{ $article->image ? asset($article->image) : 'https://via.placeholder.com/600x400?text=Actualité+Sportive' }}"
                                    alt="{{ $article->title }}" class="img-fluid">
                                <h6 class="post-category position-absolute text-white px-2 py-1"
                                    style="background: #7ed957; bottom: 10px; left: 10px; border-radius: 2px;">
                                    ActuSport / {{ $article->category ?? 'Sport' }}
                                </h6>
                            </div>

                            <h2 class="title">
                                <a href="{{ route('actuafrique.detail', $article->slug) }}">
                                    {{ $article->title }}
                                </a>
                            </h2>

                            <div class="d-flex align-items-center justify-content-between" style="gap: 10px;">
                                <!-- Auteur -->
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $authorPhoto }}"
                                        alt="{{ $authorName }}"
                                        class="img-fluid rounded-circle flex-shrink-0"
                                        width="32" height="32" style="width:32px; height:32px; object-fit:cover;">

                                    @php
                                    // Détermine le "slug" du type d'auteur (pour la route)
                                    $authorType = ($author instanceof \App\Models\Collaborateur) ? 'collaborateur' : 'user';
                                    @endphp

                                    <p class="post-author">
                                        <a href="{{ route('articles.byAuthor', ['type' => $authorType, 'id' => $author->id]) }}"
                                            style="text-decoration:none; color:inherit;">
                                            {{ $authorName }}
                                        </a>
                                    </p>
                                </div>

                                <!-- Meta -->
                                <div class="post-meta d-flex align-items-center gap-3" style="font-size: 0.9rem; color: #555;">
                                    <!-- Date -->
                                    <p class="post-date mb-0 d-flex align-items-center gap-2">
                                        <i class="bi bi-calendar3"></i>
                                        {{ Carbon::parse($article->created_at)->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>

                            <p class="mt-2">{!! Str::limit(strip_tags($article->content), 150) !!}</p>
                        </article>
                    </div>
                    @empty
                    <p>Aucune actualité sportive pour la catégorie Afrique pour le moment.</p>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $articlesafriques->links('pagination::bootstrap-5') }}
                </div>
            </section>
        </div>


        <!-- Sidebar -->
        <div class="col-lg-4 sidebar">
            <div class="widgets-container">

                <!-- Search Widget -->
                <div class="search-widget widget-item">
                    <h3 class="widget-title">Recherche</h3>
                    <form action="" method="GET">
                        <input type="text" name="query" id="searchInput" placeholder="Rechercher une actualité...">
                        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
                    </form>
                </div>

                <!-- Recent Posts Widget -->
                <div class="recent-posts-widget widget-item mt-4">
                    <h3 class="widget-title">Articles récents</h3>
                    <div id="recentPostsContainer">
                        @foreach($recentPostsAfrique as $post)
                        <div class="post-item d-flex mb-3">
                            <img src="{{ $post->image ? asset($post->image) : 'https://via.placeholder.com/80x80?text=Sport' }}"
                                alt="{{ $post->title }}" class="flex-shrink-0 me-2" width="80">
                            <div class="post-info">
                                <h4 class="post-title">
                                    <a href="{{ route('actuafrique.detail', $post->slug) }}">{{ $post->title }}</a>
                                </h4>
                                <time datetime="{{ $post->created_at->format('Y-m-d') }}">
                                    {{ $post->created_at->translatedFormat('d F Y') }}
                                </time>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const postsContainer = document.getElementById('recentPostsContainer');

        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            const posts = postsContainer.querySelectorAll('.post-item');
            posts.forEach(post => {
                const title = post.querySelector('.post-title a').innerText.toLowerCase();
                post.style.display = title.includes(query) ? 'flex' : 'none';
            });
        });
    });
</script>