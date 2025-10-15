@extends('Users.Template.layout')

@section('title', 'Articles liés au mot-clé : ' . $tag)
@section('description', "Découvrez les articles contenant le mot-clé $tag")
@section('keywords', $tag . ', sport, InfoflashSports')

@section('content')
@php
use Carbon\Carbon;
setlocale(LC_TIME, 'fr_FR.UTF-8');
@endphp

<style>
/* Cards articles */
.article-card {
  border: none;
  border-radius: 12px;
  overflow: hidden;
  background: #fff;
  transition: all 0.3s ease;
  height: 100%;
  display: flex;
  flex-direction: column;
}
.article-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}
.article-img {
  width: 100%;
  height: 200px;
  object-fit: cover;
}
.post-category {
  position: absolute;
  bottom: 12px;
  left: 12px;
  background: #7ed957;
  color: #fff;
  font-size: 0.8rem;
  padding: 4px 10px;
  border-radius: 6px;
  font-weight: 600;
}
.badge-tag {
  background: #f1f3f7;
  color: #000;
  padding: 4px 10px;
  border-radius: 6px;
  font-size: 0.85rem;
  text-decoration: none;
  display: inline-block;
  margin: 3px 5px 3px 0;
  transition: all 0.2s ease;
}
.badge-tag:hover {
  background: #7ed957;
  color: #fff;
}
.author-info {
  display: flex;
  align-items: center;
  margin-top: 12px;
}
.author-info img {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  object-fit: cover;
  margin-right: 8px;
  border: 2px solid #eee;
}
</style>

<!-- Page title -->
<div class="page-title mb-4">
  <div class="breadcrumbs">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bi bi-house"></i> Accueil</a></li>
        <li class="breadcrumb-item active">Mot-clé : {{ $tag }}</li>
      </ol>
    </nav>
  </div>

  <div class="title-wrapper">
    <h1 class="fw-bold">Articles avec le mot-clé : <span style="color:#7ed957">{{ $tag }}</span></h1>
    <p class="text-muted">Voici les articles correspondant à ce mot-clé.</p>
  </div>
</div>

<div class="container">
  <div class="row">

    <!-- Articles list -->
    <div class="col-lg-12">
      <div class="row g-4">
        @forelse($articles as $article)
          <div class="col-12 col-md-6 col-lg-4">
            <article class="article-card">
              <a href="{{ route('articles.show', $article->slug) }}" class="position-relative">
                <img src="{{ $article->image ? asset($article->image) : 'https://via.placeholder.com/600x400?text=Article' }}" 
                     alt="{{ $article->title }}" 
                     class="article-img">
                @if(!empty($article->category))
                  <span class="post-category">{{ $article->category }}</span>
                @endif
              </a>

              <div class="card-body p-3 d-flex flex-column flex-grow-1">
                              @php
$link = match(strtolower($article->category)) {
    'mercato'    => route('articles.show', $article->slug),
    'celebrite'  => route('articles.show.celebrite', $article->slug),
    'omnisport'  => route('articles.show.omnisport', $article->slug),
    'wag'        => route('articles.show.wags', $article->slug),
    'actusport'  => route('actuafrique.detail', $article->slug),
    default      => '#',
};
@endphp

<h5 class="card-title mb-2">
    <a href="{{ $link }}" class="text-dark text-decoration-none">
        <strong>{{ Str::limit($article->title, 70) }}</strong>
    </a>
</h5>



                <small class="text-muted mb-2">
                  <i class="bi bi-calendar3"></i> {{ Carbon::parse($article->created_at)->translatedFormat('d F Y') }}
                </small>

                <p class="card-text mb-2 flex-grow-1">{!! Str::limit(strip_tags($article->content), 100) !!}</p>

              @if(!empty($article->tags))
                <div class="mt-1">
                    @foreach(array_filter(explode(',', $article->tags), fn($tag) => !empty(trim($tag))) as $t)
                        <a href="{{ route('articles.byTag', ['tag' => trim($t)]) }}" class="badge-tag">
                            {{ trim($t) }}
                        </a>
                    @endforeach
                </div>
            @endif


              

              </div>
            </article>
          </div>
        @empty
          <div class="col-12">
            <div class="alert alert-info">Aucun article trouvé pour le mot-clé <strong>{{ $tag }}</strong>.</div>
          </div>
        @endforelse
      </div>

      <!-- Pagination -->
      <div class="mt-4">
        {{ $articles->links('pagination::bootstrap-5') }}
      </div>
    </div>

  </div>
</div>
@endsection
