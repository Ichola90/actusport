@extends('Users.Template.layout')

@section('title', 'Articles de l\'auteur : ' . ($author->prenom ?? '') . ' ' . ($author->nom ?? $author->name))
@section('content')
@php
use Carbon\Carbon;

function getAuthorFullName($author) {
    return !empty($author->prenom) && !empty($author->nom) 
        ? trim($author->prenom . ' ' . $author->nom) 
        : ($author->name ?? 'Admin');
}
$authorFullName = getAuthorFullName($author);
$totalArticles = $articles->total();
@endphp

<style>
.article-card {
    display: flex;
    flex-direction: column;
    height: 100%;
    border-radius: 12px;
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.article-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}
.article-card img {
    width: 100%;
    height: auto; /* rendu responsive */
    max-height: 200px;
    object-fit: cover;
}
.article-card .card-body {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.article-card .card-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
    min-height: 48px;
}
.article-card .card-text {
    flex-grow: 1;
    font-size: 0.9rem;
    color: #555;
    margin-bottom: 10px;
}
.btn-green, .btn-success {
    background-color: #7ed957;
    color: #fff;
    border: none;
    transition: 0.3s ease;
    font-weight: 600;
    border-radius: 20px;
    padding: 6px 14px;
}
.btn-green:hover, .btn-success:hover {
    background-color: #6ac347;
    transform: translateY(-2px);
    box-shadow: 0px 4px 12px rgba(126, 217, 87, 0.4);
}
.card-footer {
    background: #f8f9fa;
    font-size: 0.85rem;
    text-align: right;
}

/* Responsive tweaks */
@media (max-width: 767.98px) {
    .article-card .card-title {
        font-size: 1rem;
        min-height: auto;
    }
    .article-card .card-text {
        font-size: 0.85rem;
    }
}
</style>

<div class="container py-4">
    <h3 class="mb-2">Articles écrits par : <span class="text-success">{{ $authorFullName }}</span></h3>
    <p class="text-muted mb-4">{{ $totalArticles }} article{{ $totalArticles > 1 ? 's' : '' }} publié{{ $totalArticles > 1 ? 's' : '' }}</p>

    <div class="row g-3">
        @forelse ($articles as $article)
        @php
            $slug = trim($article->slug ?? '');
            $url = '#';

            switch($article->type) {
                case 'mercato': $url = $slug ? route('articles.show', $slug) : '#'; break;
                case 'actusport': $url = $slug ? route('actuafrique.detail', $slug) : '#'; break;
                case 'wags': $url = $slug ? route('articles.show.wags', $slug) : '#'; break;
                case 'omnisport': $url = $slug ? route('articles.show.omnisport', $slug) : '#'; break;
                case 'celebrite': $url = $slug ? route('articles.show.celebrite', $slug) : '#'; break;
            }
        @endphp

        <div class="col-12 col-sm-6 col-md-4">
            <div class="card article-card h-100">
                @if($article->image)
                    <img src="{{ asset($article->image) }}" alt="{{ $article->title }}">
                @endif
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $article->title }}</h5>
                    <p class="card-text">{!! Str::limit(strip_tags($article->content), 100, '...') !!}</p>
                    <a href="{{ $url }}" class="btn btn-success btn-sm mt-auto align-self-start">Lire plus</a>
                </div>
                <div class="card-footer">
                    <small class="text-muted">{{ ucfirst($article->category ?? $article->categorie ?? $article->type ?? '') }}</small>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info">Cet auteur n’a publié aucun article pour le moment.</div>
        </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center align-items-center mt-4 p-2">
        {{ $articles->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
