@extends('Users.Template.layout')
@section('title','Mercato')
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
                <li class="breadcrumb-item active current">Mercato - Europe</li>
            </ol>
        </nav>
    </div>

    <div class="title-wrapper">
        <h1 style="color: #7ed957;">Mercato - Europe</h1>
        <p>Retrouvez toutes les dernières informations, transferts et analyses sur le mercato européen.</p>
    </div>
</div>

<div class="container">
    <div class="row">

        <!-- Articles -->
        <div class="col-lg-8">
            <section id="category-postst" class="category-postst section">
                <div class="row gy-4">
                    @foreach($articles as $article)
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
                                @if($article->image)
                                <img src="{{ asset($article->image) }}" alt="{{ $article->title }}" class="img-fluid">
                                @else
                                <img src="https://via.placeholder.com/600x400?text=Mercato" alt="No Image" class="img-fluid">
                                @endif

                                <h6 class="post-category position-absolute text-white px-2 py-1"
                                    style="background: #7ed957; bottom: 10px; left: 10px; border-radius: 2px;">
                                    Mercato / {{ $article->categorie ?? 'Mercato' }}
                                </h6>
                            </div>

                            <h2 class="title">
                                <a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a>
                            </h2>

                            <div class="d-flex align-items-center" style="justify-content: space-between;">
                                <!-- Auteur -->
                                <div style="display: flex; align-items: center; gap: 5px;">
                                    <img src="{{ $authorPhoto }}"
                                        alt="{{ $authorName }}"
                                        class="img-fluid post-author-img flex-shrink-0 rounded-circle"
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

                                <!-- Date et Vues -->
                                <div class="post-meta" style="display: flex; align-items: center; gap: 20px; font-size:0.9rem; color:#555;">
                                    <p class="post-date" style="margin:0; display:flex; align-items:center; gap:4px;">
                                        <i class="bi bi-calendar3"></i>
                                        {{ Carbon::parse($article->created_at)->format('d/m/Y') }}
                                    </p>

                                    <!-- @if(isset($article->views))
                            <p class="post-views" style="margin:0; display:flex; align-items:center; gap:4px;">
                                <i class="bi bi-eye"></i> {{ $article->views }}
                            </p>
                            @endif -->
                                </div>
                            </div>

                            <p class="mt-2">{!! Str::limit(strip_tags($article->content), 150) !!}</p>
                        </article>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $articles->links('pagination::bootstrap-5') }}
                </div>
            </section>
        </div>


        <!-- Sidebar -->
        <div class="col-lg-4 sidebar">
            <div class="widgets-container">

                <!-- Search Widget -->
                <div class="search-widget widget-item">
                    <h3 class="widget-title">Recherche</h3>
                    <form action="" method="GET"> <input type="text" name="query" placeholder="Rechercher un article..."> <button type="submit" title="Search"><i class="bi bi-search"></i></button> </form>
                </div>

                <!-- Recent Posts Widget -->
                <div class="recent-posts-widget widget-item mt-4">
                    <h3 class="widget-title">Articles récents</h3>
                    <div id="recentPostsContainer">
                        @foreach($recentPosts as $post)
                        <div class="post-item d-flex mb-3">
                            <img src="{{ $post->image ? asset($post->image) : 'https://via.placeholder.com/80x80?text=Mercato' }}"
                                alt="{{ $post->title }}" class="flex-shrink-0 me-2" width="80">
                            <div class="post-info">
                                <h4 class="post-title"> <a href="{{ route('articles.show', $article->slug) }}">{{ $post->title }}</a></h4>
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

            // Récupérer tous les post-items
            const posts = postsContainer.querySelectorAll('.post-item');

            posts.forEach(post => {
                const title = post.querySelector('.post-title').innerText.toLowerCase();
                if (title.includes(query)) {
                    post.style.display = 'flex';
                } else {
                    post.style.display = 'none';
                }
            });
        });
    });
</script>