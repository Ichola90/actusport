@extends('Users.Template.layout')
@section('title','Tous les articles publiés')
@section('content')
@php
use Carbon\Carbon;
setlocale(LC_TIME, 'fr_FR.UTF-8');
@endphp

<style>
    .btn-green {
        background-color: #7ed957;
        color: #fff;
        border: none;
        transition: 0.3s ease;
        font-weight: 600;
        border-radius: 25px;
        padding: 8px 16px;
    }

    .btn-green:hover {
        background-color: #6ac347;
        transform: translateY(-2px);
        box-shadow: 0px 4px 12px rgba(126, 217, 87, 0.4);
    }

    /* Pagination custom */
    .pagination .page-link {
        color: #7ed957;
        border-radius: 50%;
        margin: 0 4px;
        font-weight: bold;
    }

    .pagination .page-item.active .page-link {
        background-color: #7ed957;
        border-color: #7ed957;
        color: #fff;
    }

    .pagination .page-link:hover {
        background-color: #6ac347;
        color: #fff;
    }
</style>

<div class="page-title position-relative">
    <div class="breadcrumbs">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bi bi-house"></i> Accueil</a></li>
                <li class="breadcrumb-item active current">Tous les articles</li>
            </ol>
        </nav>
    </div>

    <div class="title-wrapper">
        <h1 style="color: #7ed957;">Tous les articles publiés</h1>
    </div>
</div>

<div class="container mt-4">
    <div class="row">
        @foreach($articles as $article)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0 rounded-3">
                <img src="{{ asset($article->image) }}" class="card-img-top" alt="{{ $article->title }}" style="height: 200px; object-fit: cover;">
                <div class="card-body d-flex flex-column">

                    {{-- Titre cliquable --}}
                    <h5 class="card-title">
                        <a href="{{ match($article->type) {
                            'mercato'   => route('articles.show', $article->slug),
                            'celebrite' => route('articles.show.celebrite', $article->slug),
                            'omnisport' => route('articles.show.omnisport', $article->slug),
                            'wags'      => route('articles.show.wags', $article->slug),
                            'actusport' => route('actuafrique.detail', $article->slug),
                            default     => '#'
                        } }}" class="text-decoration-none text-dark">
                            {{ $article->title }}
                        </a>
                    </h5>

                    <p class="card-text text-muted">
                        {!! Str::limit(strip_tags($article->content), 100, '...') !!}
                    </p>
                    <small class="text-secondary">
                        Publié le {{ Carbon::parse($article->created_at)->format('d/m/Y')  }}
                    </small>

                    {{-- Bouton lire l’article --}}
                    <a href="{{ match($article->type) {
                        'mercato'   => route('articles.show', $article->slug),
                        'celebrite' => route('articles.show.celebrite', $article->slug),
                        'omnisport' => route('articles.show.omnisport', $article->slug),
                        'wags'      => route('articles.show.wags', $article->slug),
                        'actusport' => route('actuafrique.detail', $article->slug),
                        default     => '#'
                    } }}" class="btn btn-green btn-sm mt-auto">
                        Lire l'article
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center align-items-center mt-4 p-2">
        {{ $articles->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection